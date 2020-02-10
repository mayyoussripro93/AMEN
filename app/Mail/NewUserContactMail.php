<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserContactMail extends Mailable
{

    use Queueable,
        SerializesModels;

    public $data;
    public $data1;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$data1)
    {
        $this->data = $data;
        $this->data1 = $data1;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->data1['from_email'], $this->data1['from_name'])
                        ->replyTo($this->data1['from_email'], $this->data1['from_name'])
                        ->to($this->data['email'], $this->data1['first_name'])
                        ->subject(__('Massage From Contact').': '. $this->data['subject'])
                        ->view('emails.send_mail_message')
                        ->with($this->data,$this->data1);
    }

}
