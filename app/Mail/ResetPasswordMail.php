<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable //implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reset;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reset)
    {
        $this->reset = $reset;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
     return $this->view('emails.passwordresetmail')
     ->subject('Reset Password Request')
     ->from(env('MAIL_ADDRESS_FROM'), env('MAIL_FROM_NAME'));
 }
}
