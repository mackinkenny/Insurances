<?php

namespace App\Jobs;

use App\Models\Search;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $contract;
    public $ip;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $contract, $ip)
    {
        $this->data = $data;
        $this->contract = $contract;
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $search = Search::create([
            'policy_number' => $this->data['data']['policy'],
            'ip_address' => $this->ip,
            'company_id' => $this->data['data']['company'],
            'status' => $this->contract ? true : false,
            'contract_id' => $this->contract ? $this->contract->id : null,
            'encrypt_number' => base64_encode(hash('sha256', $this->data['data']['policy'] . '@' . $this->data['data']['tax'])),
        ]);
    }
}
