<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class sendInvite extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $token;
    public $server;
    public $date;
    public $title;
    public $logo;

    public function __construct($token, $server, $date, $title, $logo)
    {
        $this->token = $token;
        $this->server = $server;
        $this->date = $date;
        $this->title = $title;
        $this->logo = $logo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('naspekov@welumicool.com', 'POLIZZACERTA')->subject('You were invited to the company')->markdown('mail.inviteEmployee');
    }
}
