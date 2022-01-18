<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadContracts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $ip;
    public $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $ip, $id)
    {
        //
        $this->data = $data;
        $this->ip = $ip;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $insertData = [];
        $upload = null;
        $relativeToken = null;
        $share = false;
        $usedToken = 0;


        $company = Company::find($this->id);
        if ($this->data['company'] != $this->id) {
            $upload = $company;
            $company = Company::find($this->data['company']);
        }
        if ($upload && $company->agencies->where('id', $upload->id)->first()->pivot->share == true) {
            $share = true;
            $relativeToken = 0;
        }

        foreach ($this->data['items'] as $index => $policy) {
            if ($share == true && $relativeToken == $company->tokens_count) {
                if ($usedToken == $upload->tokens_count) {
                    break;
                }
            }
            $insertData[$index] = [
                'id' => hexdec(uniqid()),
                'company_id' => $company->id,
                'ip_address' => $this->ip,
                'encrypt_number' => base64_encode(hash('sha256', $policy['policy_number'].'@'.$policy['tax_id'])),
                'policy_number' => $policy['policy_number'],
                'country_id' => $policy['country']['id'],
                'start_date' => $policy['start_date'],
                'end_date' => $policy['end_date'],
                'upload_id' => $upload ? $upload->id : $company->id,
                'api' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            if ($share == true && $relativeToken != $company->tokens_count) {
                $relativeToken++;
            } else {
                $usedToken++;
            }
        }

        Contract::insert($insertData);
        if ($share == true){
            if ($relativeToken != 0) {
                Token::create([
                    'ip_address' => $this->ip,
                    'company_id' => $company->id,
                    'amount' => -$relativeToken,
                ]);
                $company->checkTokens();
            }
            if ($usedToken != 0) {
                Token::create([
                    'ip_address' => $this->ip,
                    'company_id' => $upload ? $upload->id : $company->id,
                    'amount' => -$usedToken,
                ]);
                $upload->checkTokens();
            }
        }
        else
        {
            if ($upload) {
                Token::create([
                    'ip_address' => $this->ip,
                    'company_id' => $upload->id,
                    'amount' => -$usedToken,
                ]);
                $upload->checkTokens();
            }
            else
            {
                Token::create([
                    'ip_address' => $this->ip,
                    'company_id' => $company->id,
                    'amount' => -$usedToken,
                ]);
                $company->checkTokens();
            }
        }
    }
}
