<?php

namespace App\Http\Controllers;

use App\Jobs\ApiUploadContractsJob;
use App\Jobs\UploadContracts;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Country;
use App\Models\Phone;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ContractController extends Controller
{
    /**
     * Admin:: contracts list page
     *
     * @return Response
     */
    public function index()
    {
        $companies = Company::where('type', 1)->get()->reverse();

//        $contracts = Contract::With('company', 'country', 'uploader')->orderBy('created_at', 'desc')->get();
//        return Inertia::render('Admin/Contract/Main', ['companies' => $companies, 'contrs' => $contracts]);
        $contracts = Contract::With('company', 'country', 'uploader')->orderBy('created_at', 'desc')->paginate(50);
        return Inertia::render('Admin/Contract/Main', ['companies' => $companies, 'contrs' => $contracts]);
    }

    /**
     * Admin:: changelog contracts list page
     *
     * @return Response
     */
    public function changelog()
    {
        $companies = Company::where('type', 1)->get()->reverse();

        $contracts = Contract::With('company', 'country', 'uploader')->orderBy('created_at', 'desc')->paginate(50);
        return Inertia::render('Admin/Contract/Index', ['companies' => $companies, 'contrs' => $contracts]);
    }

    /**
     * Company:: Manual upload contracts page
     * @param $id
     *
     * @return Response
     */
    public function create()
    {
        $id = Company::getCompanyId();
        $company = Company::find($id);
        if ($company->type == 2) {
//            $company = $company->parents()->With('masks')->get();
            $company = $company->parents()->with(['masks' => function ($query) {
                $query->select('mask', 'company_id');
            }])->get()->map(function ($item) {
                return collect($item->toArray())
                    ->only(['id', 'title', 'masks'])
                    ->all();
            });
            $type = true;
        } else {
            $company = $company->where('id', $id)->with(['masks' => function ($query) {
                $query->select('mask', 'company_id');
            }])->first(['id', 'title']);
            $type = false;
        }
        $countries = Country::select('id', 'name')->get();
        $phones = Phone::where('company_id', $id)->pluck('phone')->toArray();
        return Inertia::render('Company/Contract/Create', [
            'comp' => $company,
            'countries' => $countries,
            'type' => $type,
            'phones' => $phones
        ]);
    }

    /**
     * Admin: contract pages filter function
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function search(Request $request)
    {
        $order = $request->date ? $request->date : 'desc';
        $value = $request->value;
        $id = $request->company;
        if ($id != null) {
            $contracts = Contract::where('policy_number', 'like', "%$value%")
                ->where('company_id', $id)->With('company')->With('country')
                ->orWhere('id', 'like', "%$value%")
                ->where('company_id', $id)->With('company')->With('country')
                ->orderBy('created_at', $order)->paginate(50);
        } else {
            $contracts = Contract::where('policy_number', 'like', "%$value%")->With('company')->With('country')
                ->orWhere('id', 'like', "%$value%")->With('company')->With('country')
                ->orderBy('created_at', $order)->paginate(50);
        }
        return $contracts;
    }


    /**
     * Manual store contracts
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $id = Company::getCompanyId();
        UploadContracts::dispatch($request->all(), $request->ip(), $id);

        return Redirect::route('contract/upload/success');
    }

    /**
     * Success upload page
     *
     * @return Response
     */
    public function uploadSuccess() {
        return Inertia::render('Company/Contract/SuccessUpload');
    }

    /**
     * Api store contracts
     * @param Request $request
     *
     * @return Response
     */

    public function apiUploadContract(Request $request)
    {

        if (!$request->isJson()) {
            $requestData = json_decode(json_encode(simplexml_load_string($request->getContent())), true);
        } else {
            $requestData = $request->json()->all();
        }

        $company = Company::find(Company::getCompanyId());

        $phones = Phone::where("company_id", $company->id)->pluck("phone")->map(function($item) {
            return str_replace(' ', '', $item);
        })->toArray();
        $requestPhone = isset($requestData['phone']) ? str_replace(' ', '', $requestData['phone']) : null;

        if (!in_array($requestPhone, $phones)) {
            $response = array(
                "errors" => array(
                    array(
                        "code" => "UPN-001",
                        "message" => "Unauthorized phone number."
                    )
                ),
                "contracts" => array(
                    "requested" => false,
                    "registered" => false,
                    "not-registered" => true
                )
            );

            return \response()->json($response, 403);
        }
        $parent = null;
        $requestCompany = isset($requestData['company_id']) ? $requestData['company_id'] : null;
        if ($company->type == 2) {
            if (in_array($requestCompany, $company->parents->pluck("id")->toArray())){
                $parent = Company::find($requestCompany);
            }
            else{
                $response = array(
                    "errors" => array(
                        array(
                            "code" => "IIC-001",
                            "message" => "Invalid Insurance Company code."
                        )
                    ),
                    "contracts" => array(
                        "requested" => false,
                        "registered" => false,
                        "not-registered" => true
                    )
                );

                return \response()->json($response, 400);
            }
        }

        $data = [
            'phone' => $requestPhone,
            'contracts' => $requestData['contracts'],
            'company' => $company,
            'ip' => $request->ip(),
            'parent' => $parent
        ];
        $chunkedContracts = $data['contracts'];
        $usedToken = 0;
        $relativeToken = null;
        $share = false;
        $usedToken = 0;
        $upload = null;
        $maskError = 0;
        $dateError = 0;
        $countryError = 0;
        $tokensError = false;
        $contracts = collect();
        $total = count($data['contracts']);

        $company = $data['company'];
        if ($data['parent'] != null) {
            $upload = $company;
            $company = $data['parent'];
        }
        if ($upload && $company->agencies->where('id', $upload->id)->first()->pivot->share == true) {
            $share = true;
            $relativeToken = 0;
        }
        $insertData = [];
        foreach ($chunkedContracts as $index => $policy) {
            if (isset($policy['policy_number']) && isset($policy['start_date']) && isset($policy['end_date']) && isset($policy['country_id'])) {
                if ($share == true && $relativeToken == $company->tokens_count) {
                    if ($upload->tokens_count < 0 || $usedToken == $upload->tokens_count) {
                        $tokensError = true;
                        break;
                    }
                } else {
                    if (isset($upload) && $share == false && ($usedToken == $upload->tokens_count || $upload->tokens_count < 0)) {
                        $tokensError = true;
                        break;
                    }
                    elseif ($usedToken == $company->tokens_count || $company->tokens_count < 0) {
                        $tokensError = true;
                        break;
                    }
                }
                $checkFormat = false;
                $checkDate = false;
                $checkCountry = false;

                foreach ($company->masks as $mask) {
                    $count = 0;
                    for ($i = 0; $i < strlen($mask->mask); $i++) {
                        if (isset($policy['policy_number'][$i]) && $mask->mask[$i] == 'X' && (is_numeric($policy['policy_number'][$i]) || ctype_alpha($policy['policy_number'][$i]))) {
                            $count = $count + 1;
                        } elseif (isset($policy['policy_number'][$i]) && $mask->mask[$i] == '#' && is_numeric($policy['policy_number'][$i])) {
                            $count = $count + 1;
                        } elseif (isset($policy['policy_number'][$i]) && $mask->mask[$i] == 'A' && ctype_alpha($policy['policy_number'][$i])) {
                            $count = $count + 1;
                        } elseif (isset($policy['policy_number'][$i]) && $mask->mask[$i] == $policy['policy_number'][$i]) {
                            $count = $count + 1;
                        }
                    }
                    if ($count == strlen($policy['policy_number'])) {
                        $checkFormat = true;
                        break;
                    }
                }


                if ($checkFormat == false) {
                    $maskError++;
                }

                if (Carbon::now() < Carbon::parse($policy['end_date']) && Carbon::parse($policy['start_date']) < Carbon::parse($policy['end_date'])) {
                    $checkDate = true;
                }
                if ($checkDate == false) {
                    $dateError++;
                }
                if (Country::find($policy['country_id'])) {
                    $checkCountry = true;
                }
                if ($checkCountry == false) {
                    $countryError++;
                }

                if ($checkFormat == true && $checkDate == true && $checkCountry == true) {
                    $insertData[$index] = [
                        'id' => hexdec(uniqid()),
                        'company_id' => $company->id,
                        'ip_address' => $data['ip'],
                        'encrypt_number' => base64_encode(hash('sha256', $policy['policy_number'] . '@' . $policy['tax_id'])),
                        'policy_number' => $policy['policy_number'],
                        'country_id' => $policy['country_id'],
                        'start_date' => Carbon::parse($policy['start_date'])->format("Y-m-d H:i:s"),
                        'end_date' => Carbon::parse($policy['end_date'])->format("Y-m-d H:i:s"),
                        'upload_id' => $upload ? $upload->id : $company->id,
                        'api' => true,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                    if ($share == true && $relativeToken != $company->tokens_count) {
                        $relativeToken++;
                    } else {
                        $usedToken++;
                    }
                }
            }
            else{
                $response = array(
                    "errors" => array(
                        array(
                            "code" => "ICF-001",
                            "message" => "invalid insurance contracts format"
                        )
                    ),
                    "contracts" => array(
                        "requested" => false,
                        "registered" => false,
                        "not-registered" => true
                    )
                );

                return \response()->json($response, 400);
            }
        }
        if (count($insertData)){
            ApiUploadContractsJob::dispatch(['contracts' => $insertData, 'share' => $share, 'relativeToken' => $relativeToken, 'usedToken' => $usedToken, 'ip_address' => $data['ip'], 'company' => $company, 'upload' => $upload]);
        }
        if ($tokensError == true) {
            // if any data error occurred for any contracts
            if (($maskError + $dateError + $countryError) > 0) {
                $response = array(
                    "errors" => array(
                        array(
                            "code" => "NET-001",
                            "message" => "Not enough tokens to complete the request, the process was stopped.",
                        ),
                        array(
                            "code" => "DAT-001",
                            "message" => 'Registered ' . ($relativeToken + $usedToken) . ' of ' . $total . ', Policy Number Format error: ' . $maskError . ', Contract Dates error: '. $dateError . ', Invalid Country error: ' . $countryError . ', Others error: 0'
                        )
                    ),
                    "contracts" => array(
                        "requested" => $total,
                        "registered" => $relativeToken + $usedToken,
                        "not-registered" => array(
                            "ctr_no_format" => $maskError,
                            "dates_error" => $dateError,
                            "country_error" => $countryError,
                            "other_error" => 0
                        )
                    )
                );

                return \response()->json($response, 400);
            }
            // if no error occurred other than tokens
            else {
                $response = array(
                    "errors" => array(
                        array(
                            "code" => "NET-001",
                            "message" => "Not enough tokens to complete the request, the process was stopped."
                        )
                    ),
                    "contracts" => array(
                        "requested" => $total,
                        "registered" => $relativeToken + $usedToken,
                        "not-registered" => false
                    )
                );

                return \response()->json($response, 403);
            }
        }
        else {
            // if any data error occurred for any contracts
            if (($maskError + $dateError + $countryError) > 0) {
                $response = array(
                    "errors" => array(
                        array(
                            "code" => "DAT-001",
                            "message" => 'Registered ' . ($relativeToken + $usedToken) . ' of ' . $total . ', Policy Number Format error: ' . $maskError . ', Contract Dates error: '. $dateError . ', Invalid Country error: ' . $countryError . ', Others error: 0'
                        )
                    ),
                    "contracts" => array(
                        "requested" => $total,
                        "registered" => $relativeToken + $usedToken,
                        "not-registered" => array(
                            "ctr_no_format" => $maskError,
                            "dates_error" => $dateError,
                            "country_error" => $countryError,
                            "other_error" => 0
                        )
                    )
                );

                return \response()->json($response, 400);
            }
            // if everything OK
            else {
                $response = array(
                    "errors" => false,
                    "contracts" => array(
                        "requested" => $total,
                        "registered" => $relativeToken + $usedToken,
                        "not-registered" => false
                    )
                );

                return \response()->json($response, 200);
            }

        }
    }

}
