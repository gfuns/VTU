<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FundsReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $transfer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $transfer)
    {
        $this->user = $user;
        $this->transfer = $transfer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.fundsreceiptmail')
        ->subject('Notification Of Funds Receipt')
        ->from(env('MAIL_ADDRESS_FROM'), env('MAIL_FROM_NAME'));
    }
}
