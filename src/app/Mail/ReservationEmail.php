<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $shop;
    public $time;
    public $number;
    public $qrCode;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $shop, $time, $number, $qrCode)
    {
        $this->name = $name;
        $this->shop = $shop;
        $this->time = $time;
        $this->number = $number;
        $this->qrCode = $qrCode;
    }

    public function build()
    {
        return $this->subject('予約情報の通知')
            ->view('emails.sendReservation');
    }
}
