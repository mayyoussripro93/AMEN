<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class NewEmployeeAdded extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    //protected $url;
    public $data;
    public function __construct($dddddd)
    {
       // $this->url = $url;
        $this->data=$dddddd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//dd($this->data);
        return $this->subject( config('app.name'))
            ->view('emails.employee.NewAdd')
            ->with(
                [   'user'=>$this->data,
                    'url' =>  route('login')
                ]
            );

    }
}
