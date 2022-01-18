<?php

namespace App\Jobs;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ContractSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request;
    public $responseData = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $contract = Contract::where('company_id', $this->request->data['company'])->where('encrypt_number', base64_encode(hash('sha256',$this->request->data['tax'].'_'.$this->request->data['policy'], true)))->With('company')->first();
        $cont = collect();
        $status = false;
        if ($contract) {
            $cont = collect(['company' => $contract->company->title, 'date' => $contract->end_date]);
            $status = true;
        }
        $this->responseData = [
            'contract' => $cont,
            'status' => $status
        ];
    }

    public function getResponse()
    {
        return $this->responseData;
    }
}
