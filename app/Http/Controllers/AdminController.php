<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Search;
use App\Models\Token;
use Auth;
use Carbon\Carbon;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3) {
            return redirect()->route('company/dashboard');
        }
        $total_tokens = Token::where('amount', '>', 0)->get()->sum('amount');
        $total_contracts = Contract::all()->count();

        $ly_tokens = Token::where('amount', '>', 0)->where('created_at', '>', Carbon::now()->subYear(1))->get()->sum('amount');
        $ly_contracts = Contract::where('created_at', '>', Carbon::now()->subYear(1))->get()->count();

        $contracts = Contract::whereYear('created_at', Carbon::now()->format('Y'))->get()->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('M');
        });

        $dataContracts = collect();

        for ($i = 0; $i < 12; $i++) {
            if (isset($contracts[Carbon::now()->startOfYear()->subMonth(-$i)->format('M')])) {
                $dataContracts->push($contracts[Carbon::now()->startOfYear()->subMonth(-$i)->format('M')]->count());
            } else {
                $dataContracts->push(0);
            }
        }

        $tokens = Token::whereYear('created_at', Carbon::now()->format('Y'))->get()->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('M');
        });

        $dataTokens = collect();

        for ($i = 0; $i < 12; $i++) {
            if (isset($tokens[Carbon::now()->startOfYear()->subMonth(-$i)->format('M')])) {
                $dataTokens->push($tokens[Carbon::now()->startOfYear()->subMonth(-$i)->format('M')]->sum('amount'));
            } else {
                $dataTokens->push(0);
            }
        }

        $searchesDone = Search::where('status', true)->get()->count();
        $searchesMatched = Search::where('status', false)->get()->count();

        return Inertia::render('Admin/Dashboard', [
            'total_tokens' => $total_tokens,
            'total_contracts' => $total_contracts,
            'ly_tokens' => $ly_tokens,
            'ly_contracts' => $ly_contracts,
            'dataTokens' => $dataTokens,
            'dataContracts' => $dataContracts,
            'searchesDone' => $searchesDone,
            'searchesMatched' => $searchesMatched
        ]);
    }
}
