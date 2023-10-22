<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

   /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = $this->mailData->email;
        $subject = $this->mailData->subject;
        $name = config('constant.MailName');
        $from = config('constant.MailSenderAddress');

        return $this->view($this->mailData->view)
            ->text($this->mailData->text)
            ->from($from, $name)
            ->to($address, $name)
            ->subject($subject)
            ->with(['mailMessage' => $this->mailData]);;
    }
}
