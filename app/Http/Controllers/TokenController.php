<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TokenController extends Controller
{
    //

    public function history($id, Request $request)
    {
        $tokens = Token::where('company_id', $id)->where('created_at', '>=', Carbon::parse($request->dates['start']))->where('created_at', '<=', Carbon::parse($request->dates['end']))->paginate(30);
        $amount = $tokens->sum('amount');

        return response()->json([
            'tokens' => $tokens,
            'sum' => $amount
        ]);
    }

    public function store($id, Request $request)
    {
        Token::create([
            'ip_address' => $request->ip(),
            'company_id' => $id,
            'amount' => $request->tokensAmount,
        ]);
        $company = Company::find($id);
        $company->checkTokens();

        return Redirect::route('company/tokens', $id);
    }
}
