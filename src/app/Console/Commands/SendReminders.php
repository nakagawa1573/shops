<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Mail\ReservationEmail;
use Illuminate\Support\Facades\Mail;

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
            $qrCode = $reservation->id;
            Mail::to($reservation->user)->send(new ReservationEmail($name, $shop, $time, $number, $qrCode));
        }
    }
}
