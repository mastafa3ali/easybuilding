<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderEmail extends Mailable
{
    use Queueable;
    use SerializesModels;
    protected $mailData;
    protected $item;


    public $code;

    public function __construct($mailData,$item)
    {
        $this->mailData = $mailData;
        $this->item = $item;
        //
    }

    public function build()
    {


   $address = $this->mailData->to;
        $subject = $this->mailData->subject;
        $name = $this->mailData->name;
        $cc = $this->mailData->cc;
        $bcc = $this->mailData->bcc;
        $from = $this->mailData->from;
        return $this->view('orderemail')
            ->from($from, $name)
            ->cc($address, $name)
            ->bcc($cc, $name)
            ->replyTo($from, $name)
            ->subject('طلب جديد')
            ->with(['item' => $this->item]);

    }
}
