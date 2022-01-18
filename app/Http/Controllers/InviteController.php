<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Jobs\SendInvite;
use Auth;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InviteController extends Controller
{
    use PasswordValidationRules;

    /**
     * The guard implementation.
     *
     * @var StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param StatefulGuard $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users'), Rule::unique('invites')],
        ])->validate();

        SendInvite::dispatch($request->email, $user->company);

        return redirect()->back();
    }
}
