<?php

namespace App\Http\Controllers;

use App\Jobs\AddRequest;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Search;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    /**
     * User: search contract
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function userSearch(Request $request)
    {
        $contract = Contract::where('company_id', $request->data['company'])->where('encrypt_number', base64_encode(hash('sha256', $request->data['policy'] . '@' . $request->data['tax'])))->With('company')->latest()->first();
        $cont = collect();
        $status = false;
        if ($contract) {
            $cont = collect(['company' => $contract->company->title, 'date' => $contract->end_date]);
            $status = true;
        }
        AddRequest::dispatch($request->all(), $contract, $request->ip());

        return response()->json([
            'contract' => $cont,
            'status' => $status
        ]);
    }


    public function index()
    {
        $companies = Company::where('type', 1)->get()->reverse();
        $searches = Search::With('company')->paginate(10);

        return Inertia::render('Admin/Requests/Index', ['companies' => $companies, 'requests' => $searches]);
    }

    public function search(Request $request)
    {
        $order = $request->date ? $request->date : 'desc';
        $value = $request->value;
        $id = $request->company;
        if ($id != null) {
            $searches = Search::where('policy_number', 'like', "%$value%")
                ->where('company_id', $id)->With('company')
                ->orWhere('ip_address', 'like', "%$value%")
                ->where('company_id', $id)->With('company')
                ->orderBy('created_at', $order)->paginate(10);
        } else {
            $searches = Search::where('policy_number', 'like', "%$value%")->With('company')
                ->orWhere('ip_address', 'like', "%$value%")->With('company')
                ->orderBy('created_at', $order)->paginate(10);
        }
        return $searches;
    }
}
