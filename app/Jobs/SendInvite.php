<?php

namespace App\Jobs;

use App\Models\Invite;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SendInvite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $email;
    public $company;

    public function __construct($email, $company)
    {
        $this->email = $email;
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invite = Invite::create([
            'email' => $this->email,
            'token' => Str::random(60),
            'end_date' => Carbon::now()->addDay(1),
            'company_id' => $this->company->id,
        ]);

            \Mail::to($this->email)->send(new \App\Mail\sendInvite($invite->token, \url()->to('/'), $invite->end_date, $this->company->title, $this->company->logo));
    }
}
