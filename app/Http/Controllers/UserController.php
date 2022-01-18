<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Jobs\SendSms;
use App\Models\Company;
use App\Models\Invite;
use App\Models\Ltm_translation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

class UserController extends Controller
{
    use PasswordValidationRules;

    /**
     * HomePage function
     *
     *
     * @return Response
     */
    public function index()
    {
        $translations = Ltm_translation::where('locale', substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))->where('group', 'userpage')->where('value', '!=', null)->get();
        if (count($translations) == 0) {
            $translations = Ltm_translation::where('locale', 'en')->where('group', 'userpage')->where('value', '!=', null)->get();
        }
        $phrases = collect();
        foreach ($translations as $translation) {
            $phrases->put($translation->key, $translation->value);
        }
        App::setLocale(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        session()->put('locale', substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        $companies = Company::where('type', 1)->With('masks')->get();
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'companies' => $companies,
            'phrases' => $phrases
        ]);
    }

    /**
     * Onboarding Page function
     *
     *
     * @return Response
     */
    public function onboarding()
    {
        $translations = Ltm_translation::where('locale', substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))->where('group', 'landing')->where('value', '!=', null)->get();
        if (count($translations) == 0) {
            $translations = Ltm_translation::where('locale', 'en')->where('group', 'landing')->where('value', '!=', null)->get();
        }
        $phrases = collect();
        foreach ($translations as $translation) {
            $phrases->put($translation->key, $translation->value);
        }

        return view('landing', ['phrases' => $phrases]);
    }

    /**
     * New employees validate function
     *
     *
     * @return Response
     */
    public function register($token)
    {
        $invite = Invite::where('token', $token)->where('status', false)->where('end_date', '>', Carbon::now())->first();

        if (!$invite) {
            return redirect('/');
        }

        return Inertia::render('Auth/Register', ['email' => $invite->email]);
    }

    /**
     * New Employee register function
     *
     *
     * @return Response
     */
    public function createEmployee(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $invite = Invite::where('email', $request->email)->where('end_date', '>', Carbon::now())->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'position' => 'Employee',
            'company_id' => $invite->company_id,
            'login' => $request->email,
            'role_id' => $invite->company->type == 1 ? 2 : 3,
        ]);

        $invite->status = true;
        $invite->save();

        Auth::loginUsingId($user->id);

        return redirect()->route('dashboard');
    }

    /**
     * Send subscribe notification to mail
     *
     *
     * @return Response
     */
    public function subscribe(Request $request)
    {
        $data["ip"] = $request->ip();
        $data["date"] = Carbon::now();
        $data["subscriber"] = $request->email;
        $data["email"] = "riccardo.tortora@innovass.it";
        $data["title"] = "Newsletter subscription request";
        \Mail::to($data["email"])->send(new \App\Mail\newSubscribe($data));
    }


    public function getCode(Request $request) {
        // SEND SMS WITH REDIS QUEUE
        $code = rand(100000, 999999);
        SendSms::dispatch($request->phone, $code);
//        Redis::set($request->phone, $code);
        return 'Success';
    }

    public function verifyCode(Request $request) {
        if ($code = Redis::get($request->phone)) {
            if ($code == $request->code) {
                return Response::json(true);
                Redis::del($request->phone);
            } else {
                return Response::json(false);
            }
        } else {
            return 'Not isset or Expired';
        }
    }


    public function privacyPolicy() {
        $translations = Ltm_translation::where('locale', substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))->where('group', 'privacyPolicy')->where('value', '!=', null)->get();
        if (count($translations) == 0) {
            $translations = Ltm_translation::where('locale', 'en')->where('group', 'privacyPolicy')->where('value', '!=', null)->get();
        }
        $phrases = collect();
        foreach ($translations as $translation) {
            $phrases->put($translation->key, $translation->value);
        }
        $policy = $phrases['privacy'];
        return Inertia::render('PrivacyPolicy', ['policy' => $policy]);
    }
}
