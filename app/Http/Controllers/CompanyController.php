<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Country;
use App\Models\Invite;
use App\Models\Mask;
use App\Models\Payment;
use App\Models\Phone;
use App\Models\StripePrices;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Intervention\Image\Facades\Image;
use PhpParser\Parser\Tokens;
use Spatie\Searchable\Search;
use Carbon\Carbon;
use Stripe\Product;
use Stripe\Price;
use Stripe\Checkout\Session;
use Stripe\StripeClient;

class CompanyController extends Controller
{
    /**
     * Admin:: companies list page
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $companies = Company::where('type', 1)->With('country')->latest()->paginate(30);
        $status = isset($request->status) ? true : false;

        return Inertia::render('Admin/Company/index', ['companies' => $companies, 'status' => $status]);
    }

    /**
     * Admin:: create company page
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::where('type', 1)->get();
        $countries = Country::all();

        return Inertia::render('Admin/Company/Create', ['companies' => $companies, 'countries' => $countries]);
    }

    /**
     * Admin:: edit company page
     *
     * @param $id // company id
     *
     * @return Response
     */

    public function edit($id)
    {
        $company = Company::where('id', $id)->With('owner', 'masks', 'phones', 'country')->first();
        $companies = Company::where('type', 1)->get();
        $associate = null;
        if (count($company->parents)) {
            $associate = $company->parents->pluck('id');
        }
        $countries = Country::all();

        return Inertia::render('Admin/Company/Edit', ['company' => $company, 'countries' => $countries, 'associate' => $associate, 'companies' => $companies]);
    }

    /**
     * Admin:: store new company function // create company, user, associate trusted phones and policy number masks
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $data = json_decode($request['form'], true);

        // Validate request values
        Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password'      => ['required', 'string', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', 'min:8'],
            'phone'         => ['required', 'string', 'max:255', Rule::unique('users')],
            'position'      => ['required', 'string', 'max:255'],
            'title'         => ['required', 'string', 'max:255'],
            'address'       => ['required', 'string', 'max:255'],
            'country'       => ['required', 'max:255'],
            'city'          => ['required', 'max:255'],
            'tax_id'        => ['required', 'max:255', Rule::unique('companies')],
            'assist_phone'  => ['required', 'string', 'max:255'],
            'tokens'        => ['required', 'max:255'],
        ])->validate();
        //parse parameters to collection
        $data = json_decode($request['form']);
        //create a responsible user
        $user = User::create([
            'name'      => $data->name,
            'email'     => $data->email,
            'password'  => Hash::make($data->password),
            'phone'     => $data->phone,
            'position'  => $data->position,
            'login'     => $data->tax_id,
            'role_id'   => $data->type == 1 ? 2 : 3,
        ]);
        //store company logo image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $logo = time() . '.' . $image->extension();

            $img = Image::make($image->path());
            $img->resize(240, 240, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->stream();

            Storage::disk('s3')->put('public/company/logo' . '/' . $logo, $img, 'public');
        }
        //store company example image
        if ($request->hasFile('example')) {
            $image = $request->file('example');
            $example = time() . '.' . $image->extension();

            $img = Image::make($image->path());
            $img->resize(1024, 1024, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->stream();

            Storage::disk('s3')->put('public/company/example' . '/' . $example, $img, 'public');
        }
        //create Company
        $company = Company::create([
            'id'            => hexdec(uniqid()),
            'title'         => $data->title,
            'address'       => $data->address,
            'country_id'    => $data->country->id,
            'city'          => $data->city,
            'tax_id'        => $data->tax_id,
            'phone'         => $data->assist_phone,
            'type'          => $data->type,
            'user_id'       => $user->id,
            'logo'          => 'public/company/logo/' . $logo,
            'example'       => 'public/company/example/' . $example,
            'tokens_count'  => $data->tokens,
        ]);
        if ($data->type === 2) {
            $company->parents()->sync($data->associate);
        }
        //create trusted phones and associate with company
        foreach ($data->trustedPhones as $phone) {
            Phone::create([
                'phone' => $phone,
                'company_id' => $company->id
            ]);
        }
        //create policy number masks and associate with company
        foreach ($data->policyFormats as $mask) {
            Mask::create([
                'mask' => $mask,
                'company_id' => $company->id,
            ]);
        }

        Token::create([
            'ip_address' => $request->ip(),
            'company_id' => $company->id,
            'amount' => $data->tokens,
        ]);

        return Redirect::route('company/list', ['status' => 1]);
    }

    /**
     * Admin:: update company function // update company, user, associate trusted phones and policy number masks
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $data = json_decode($request['form'], true);
        $company = Company::find($data['id']);

        // Validate request values
        Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($company->owner->id)],
            'password' => ['nullable', 'string', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', 'min:8'],
            'phone' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($company->owner->id)],
            'position' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'country' => ['required', 'max:255'],
            'city' => ['required', 'max:255'],
            'tax_id' => ['required', 'max:255', Rule::unique('companies')->ignore($company->id)],
            'assist_phone' => ['required', 'string', 'max:255'],
            'tokens' => ['required', 'max:255'],
        ])->validate();
        //parse parameters to collection
        $data = json_decode($request['form']);
        //store company logo image
        $logo = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $logo = time() . '.' . $image->extension();

            $img = Image::make($image->path());
            $img->resize(240, 240, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->stream();

            Storage::disk('s3')->put('public/company/logo' . '/' . $logo, $img, 'public');
        }
        //store company example image
        $example = null;
        if ($request->hasFile('example')) {
            $image = $request->file('example');
            $example = time() . '.' . $image->extension();

            $img = Image::make($image->path());
            $img->resize(1024, 1024, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->stream();

            Storage::disk('s3')->put('public/company/example' . '/' . $example, $img, 'public');
        }
        //update company values
        $company = Company::find($data->id);
        $company->title = $data->title;
        $company->address = $data->address;
        $company->country_id = $data->country->id;
        $company->city = $data->city;
        $company->tax_id = $data->tax_id;
        $company->phone = $data->assist_phone;
        if ($logo) {
            $company->logo = 'public/company/logo/' . $logo;
        }
        if ($example) {
            $company->example = 'public/company/example/' . $example;
        }
        if ($data->increaseTokens) {
            Token::create([
                'ip_address' => $request->ip(),
                'company_id' => $company->id,
                'amount' => intval($data->increaseTokens),
            ]);
        }
        $company->save();
        $company->checkTokens();
        if ($data->type === 2) {
            $company->parents()->sync($data->associate);
        }

        //update user values
        $user = $company->owner;
        $user->name = $data->name;
        $user->email = $data->email;
        if ($data->password) {
            $user->password = Hash::make($data->password);
        }
        $user->phone = $data->phone;
        $user->position = $data->position;
        $user->login = $data->tax_id;
        $user->save();

        //update and associate trusted phones and policy number masks
        foreach ($company->phones as $phone) {
            $phone->delete();
        }
        foreach ($company->masks as $mask) {
            $mask->delete();
        }

        foreach ($data->trustedPhones as $phone) {
            Phone::create([
                'phone' => $phone,
                'company_id' => $company->id
            ]);
        }

        foreach ($data->policyFormats as $mask) {
            Mask::create([
                'mask' => $mask,
                'company_id' => $company->id,
            ]);
        }

        return Redirect::route('company/list', ['status' => 2]);
    }

    /**
     * Search company by title
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function search(Request $request)
    {
        $value = $request->value;
        $tab = $request->tab;
        if ($tab == 'true') {
            $companies = Company::where('title', 'like', "%$value%")->where('type', 1)->With('country')->latest()->paginate(30);
        } else {
            $companies = Company::where('title', 'like', "%$value%")->where('type', 2)->With('country')->latest()->paginate(30);
        }
        return $companies;
    }


    /**
     * Company tokens page
     *
     * @param $id // Company id
     *
     * @return Response
     */
    public function tokens()
    {
        $company = Company::where('id', Company::getCompanyId())->With('agencies')->first();
//        dd($company->agencies[0]->pivot->parent_id);
        $company->makeHidden(['api_key', 'tax_id']);
        $tokens = Token::where('company_id', $company->id)->latest()->paginate(30);
        return Inertia::render('Company/Tokens/List', [
            'company' => $company,
            'toks' => $tokens
        ]);
    }

    /**
     * Company share tokens
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function shareTokens(Request $request)
    {
        $company = Company::find(Company::getCompanyId());
        $company->agencies()->sync([$request->id => ['share' => $request->status]]);
    }


    /**
     * company contracts list page
     *
     * @param $id // Company id
     *
     * @return $company  // with contracts
     */
    public function contracts()
    {
        $company = Company::find(Company::getCompanyId());
        $contrs = $company->type == 1 ? Contract::where('company_id', $company->id)->With('country', 'uploader', 'company')->latest()->paginate(50) : Contract::where('upload_id', $company->id)->With('country', 'uploader', 'company')->latest()->paginate(50);

        return Inertia::render('Company/Contract/Index', [
            'company' => $company,
            'contrs' => $contrs
        ]);
    }


    /**
     * Dashboard Page
     * @param $id
     *
     * @return Response
     */
    public function dashboard(): Response
    {
        $id = Company::getCompanyId();
        $company = Company::where('id', $id)->With(['owner' => function ($query) {
            $query->select('id', 'name', 'email', 'phone', 'position');
        }])->first(['id', 'title', 'logo', 'tax_id', 'user_id', 'phone', 'address']);
        if ($company->type == 1) {
            $contracts = Contract::where('company_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))
                ->get()
                ->groupBy(function ($val) {
                    return Carbon::parse($val->created_at)->format('M');
                });
        } else {
            $contracts = Contract::where('upload_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))
                ->get()
                ->groupBy(function ($val) {
                    return Carbon::parse($val->created_at)->format('M');
                });
        }
        $data = collect();
        for ($i = 0; $i < 12; $i++) {
            if (isset($contracts[Carbon::now()->startOfYear()->subMonth(-$i)->format('M')])) {

                $data->push($contracts[Carbon::now()->startOfYear()->subMonth(-$i)->format('M')]->count());
            } else {
                $data->push(0);
            }
        }
        return Inertia::render('Company/Dashboard', ['company' => $company, 'options' => $data]);
    }


    public function updateResponsive(Request $request)
    {
        $user = \Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->phone = $request->phone;
        $user->save();

        $company = Company::where('id', $user->company->id)->With(['owner' => function ($query) {
            $query->select('id', 'name', 'email', 'phone', 'position');
        }])->first(['id', 'title', 'logo', 'tax_id', 'user_id', 'phone', 'address']);

        return $company;
    }

    public function updatePhone(Request $request)
    {
        $id = Company::getCompanyId();
        $company = Company::where('id', $id)->With(['owner' => function ($query) {
            $query->select('id', 'name', 'email', 'phone', 'position');
        }])->first(['id', 'title', 'logo', 'tax_id', 'user_id', 'phone', 'address']);
        $company->phone = $request->phone;
        $company->save();

        return $company;
    }

    /**
     * Search company contracts by date and(or) keyword
     *
     * @param $id // Company id
     * @param Request $request
     *
     * @return mixed
     */
    public function searchCompanyContracts($id, Request $request)
    {
        $company = Company::find($id);
        $contracts = $company->type == 1 ? Contract::where('company_id', $id)->With('country', 'uploader', 'company') : Contract::where('upload_id', $id)->With('country', 'uploader', 'company');
        if ($request->date) {
            $contracts->whereDate('created_at', $request->date);
        }

        if ($request->keyword) {
            $contracts->where('policy_number', 'like', "%$request->keyword%");
        }

        return $contracts->latest()->paginate(50);
    }


    public function checkout(Request $request)
    {
        // Process id
        $session_id = hexdec(uniqid());

        $YOUR_DOMAIN = getenv('APP_URL');

        $price = StripePrices::where('quantity', $request->get('quantity'))->first();
        $unitAmount = (int)getenv('TOKEN_PRICE') * $request->get('quantity');

        if ($price == null) {

            $product = Product::create([
                'name' => $request->get('quantity') . " Quantity Tokens"
            ]);

            $stripePrice = Price::create([
                'product' => $product->id,
                'unit_amount' => $unitAmount,
                'currency' => 'USD'
            ]);

            $price = new StripePrices();
            $price->quantity = (int)$request->get('quantity');
            $price->price_id = $stripePrice->id;
            $price->product_id = $product->id;
            $price->save();
        }

        $checkout_session = Session::create([
            'payment_method_types' => [
                'card'
            ],
            'line_items' => [
                [
                    'price' => $price->price_id,
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/company/checkout/success/' . $session_id,
            'cancel_url' => $YOUR_DOMAIN . '/company/checkout/cancel/' . $session_id,
        ]);

        $payment = new Payment;


        $payment->stripe_id = $checkout_session->id;
        $payment->session_id = $session_id;
        $payment->token_count = (int)$request->quantity;
        $payment->price = $unitAmount;
        $payment->company_id = $request->company_id;
        $payment->ip_address = $request->ip();

        $payment->save();


        return $checkout_session->url;
    }

    public function success($session_id)
    {

        $stripeClient = new StripeClient(getenv('STRIPE_API_KEY'));
        $session = Payment::where('session_id', $session_id)->first();
        $company = Company::find($session->company_id);

        $session->status = Payment::SUCCESS_STATUS;
        $token = new Token;
        $token->amount = $session->token_count;
        $token->company_id = $company->id;
        $token->ip_address = $session->ip_address;
        $token->save();
        $company->checkTokens();
        $payment = $stripeClient->checkout->sessions->retrieve(
            $session->stripe_id,
            []
        );
        $paymentIntent = $stripeClient->paymentIntents->retrieve(
            $payment->payment_intent,
            []
        );
        $session->method = $paymentIntent->charges->data[0]->payment_method_details->type;
        $session->save();

        return Redirect::route('company/tokens');
    }

    public function cancel($session_id)
    {
        $session = Payment::where('session_id', $session_id)->first();
        $session->status = Payment::CANCEL_STATUS;
        $session->save();
        return Redirect::route('company/tokens');
    }

    public function api()
    {
        $company = Company::where('id', Company::getCompanyId())->first(['id', 'type']);
        $companies = null;
        if ($company->type == 2) {
            $companies = $company->parents->map(function ($item) {
                return collect($item->toArray())
                    ->only(['id', 'title', 'type'])
                    ->all();
            });
            $company = null;
        }
        $phones = Phone::where('company_id', Company::getCompanyId())->pluck('phone')->toArray();
        $countries = Country::select('id', 'name')->get();
        return Inertia::render('Company/Api', ['companies' => $companies, 'company' => $company, 'phones' => $phones, 'countries' => $countries]);
    }

    public function getApi()
    {
        $user = Auth::user();
        $token = Str::random(60);

        $user->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return $token;
    }

    public function employees()
    {
        $user = Auth::user();
        $invites = $user->company->invites->where('end_date', '>', Carbon::now())->where('status', false);
        Invite::where('company_id', $user->company->id)->where('end_date', '<', Carbon::now())->delete();;
        $invites->makeHidden(['token']);
        $company = $user->company;
        $employees = $company->employees->reverse()->map(function ($item) {
            return collect($item->toArray())
                ->only(['id', 'name', 'email'])
                ->all();
        });;

        return Inertia::render('Company/Employees/Index', ['invites' => $invites, 'employees' => $employees]);
    }
}
