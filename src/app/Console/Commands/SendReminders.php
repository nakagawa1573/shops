<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Mail\ReservationEmail;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reservations = Reservation::with('user', 'shop')->where('date', Carbon::now()->format('Y-m-d'))->get();
        foreach ($reservations as $reservation) {
            $name = $reservation->user->name;
            $shop = $reservation->shop->shop;
            $time = Carbon::parse($reservation->time)->format('H:i');
            $number = $reservation->number;
            $writer = new PngWriter();
            $qrCode = QrCode::create('Data')
            ->setEncoding(new Encoding('UTF-8'))
            ->setSize(300)
            ->setMargin(10)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
            $result = $writer->write($qrCode);
            $qrCode = base64_encode($result->getString());
            Mail::to($reservation->user)->send(new ReservationEmail($name, $shop, $time, $number, $qrCode));
        }
    }
}
