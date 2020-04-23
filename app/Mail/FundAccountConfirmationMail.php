<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FundAccountConfirmationMail extends Mailable //implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $topup;
    public $wallet;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $topup, $wallet)
    {
        $this->user = $user;
        $this->topup = $topup;
        $this->wallet = $wallet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.fundaccountconfirmationmail')
        ->subject('Wallet Topup Successful')
        ->from(env('MAIL_ADDRESS_FROM'), env('MAIL_FROM_NAME'));
    }
}
