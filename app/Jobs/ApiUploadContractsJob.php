<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Country;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApiUploadContractsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $contracts;
    public $share;
    public $relativeToken;
    public $usedToken;
    public $ip_address;
    public $company;
    public $upload;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->contracts = $data['contracts'];
        $this->share = $data['share'];
        $this->relativeToken = $data['relativeToken'];
        $this->usedToken = $data['usedToken'];
        $this->ip_address = $data['ip_address'];
        $this->company = $data['company'];
        $this->upload = $data['upload'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $chunkedContracts = array_chunk($this->contracts, 1000);
        foreach ($chunkedContracts as $contracts) {
            Contract::insert($contracts);
        }


        if ($this->share == true){
            if ($this->relativeToken != 0) {
                Token::create([
                    'ip_address' => $this->ip_address,
                    'company_id' => $this->company->id,
                    'amount' => -$this->relativeToken,
                ]);
                $this->company->checkTokens();
            }
            if ($this->usedToken != 0) {
                Token::create([
                    'ip_address' => $this->ip_address,
                    'company_id' => $this->upload ? $this->upload->id : $this->company->id,
                    'amount' => -$this->usedToken,
                ]);
                $this->upload->checkTokens();
            }
        }
        else
        {
            if ($this->upload && $this->usedToken != 0) {
                Token::create([
                    'ip_address' => $this->ip_address,
                    'company_id' => $this->upload->id,
                    'amount' => -$this->usedToken,
                ]);
                $this->upload->checkTokens();
            }
            else if($this->usedToken != 0)
            {
                Token::create([
                    'ip_address' => $this->ip_address,
                    'company_id' => $this->company->id,
                    'amount' => -$this->usedToken,
                ]);
                $this->company->checkTokens();
            }
        }
    }
}
