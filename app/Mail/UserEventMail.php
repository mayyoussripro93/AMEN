<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEventMail extends Mailable
{

    use Queueable,
        SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {

        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if ($this->data['note']== __('A new appointment has been Updated')){
            return $this->from($this->data['from_email'], $this->data['from_name'])
                ->replyTo($this->data['from_email'], $this->data['from_name'])
                ->to($this->data['to_email'], $this->data['to_name'])
                ->subject('تعديل فعالية: '.$this->data['subject'])
                ->view('emails.event_send_message')
                ->with($this->data);
        }elseif($this->data['note']== __('A new appointment has been added')){
            return $this->from($this->data['from_email'], $this->data['from_name'])
                ->replyTo($this->data['from_email'], $this->data['from_name'])
                ->to($this->data['to_email'], $this->data['to_name'])
                ->subject('فعالية جديدة: '.$this->data['subject'])
                ->view('emails.event_send_message')
                ->with($this->data);
        }elseif($this->data['note']== __('Your appointment has been canceled and you will be contacted shortly')){
            return $this->from($this->data['from_email'], $this->data['from_name'])
                ->replyTo($this->data['from_email'], $this->data['from_name'])
                ->to($this->data['to_email'], $this->data['to_name'])
                ->subject('إلغاء فعالية: '.$this->data['subject'])
                ->view('emails.event_send_message')
                ->with($this->data);
        }

    }

}
