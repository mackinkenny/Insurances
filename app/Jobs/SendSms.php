<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phone;
    public $code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone, $code)
    {
        $this->phone = $phone;
        $this->code  = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws ConfigurationException|TwilioException
     */
    public function handle()
    {
        $account_sid   = getenv('TWILIO_ACCOUNT_SID');
        $auth_token    = getenv('TWILIO_AUTH_TOKEN');
        $twilio_number = getenv('TWILIO_NUMBER');
        $client        = new Client($account_sid, $auth_token);
        $message = "Your verification code: ". $this->code;
        $client->messages->create(
            $this->phone,
            [
                'from' => $twilio_number,
                'body' => $message
            ]
        );
        Redis::set($this->phone, $this->code);
        Redis::expire($this->phone, 5 * 60);
    }
}
