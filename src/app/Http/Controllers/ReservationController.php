<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;

class ReservationController extends Controller
{
    public function showDone()
    {
        return view('done');
    }

    public function store(ReservationRequest $request, Shop $shop)
    {
        $reservation = $request->only(['date', 'time', 'number']);
        $reservation['user_id'] = Auth::user()->id;
        $reservation['shop_id'] = $shop->id;
        $date = $request->date;
        $time = $request->time;

        if (Carbon::parse($date . $time) > Carbon::now()) {
            Reservation::create($reservation);
            return redirect('/done');
        } else {
            return back()->with('message', '予約手続きに失敗しました');
        }
    }

    public function destroy(Reservation $reservation)
    {
        $this->authorize('create', $reservation);
        Reservation::find($reservation->id)->delete();

        return back();
    }

    public function showUpdate(Reservation $reservation)
    {
        $this->authorize('create', $reservation);
        session(['url' => route('mypage')]);
        return view('updateReservation', compact('reservation'));
    }

    public function update(ReservationRequest $request, Reservation $reservation)
    {
        $this->authorize('create', $reservation);
        $date = $request->date;
        $time = $request->time;
        if (Carbon::parse($date . ' ' . $time) > Carbon::now()) {
            $reservation->update([
                'date' => $date,
                'time' => $time,
                'number' => $request->number,
            ]);
        } else {
            return back()->with('message', '予約手続きに失敗しました');
        }

        return redirect('/mypage');
    }

    public function create(Reservation $reservation)
    {
        $this->authorize($reservation);
        $product = Product::with('shop')->find($reservation->product_id);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $response = $stripe->checkout->sessions->create(
            [
                'line_items' => [
                    [
                        'price' => $product->product,
                        'quantity' => 1,
                    ],
                ],
                'automatic_tax' => ['enabled' => true],
                'mode' => 'payment',
                'success_url' => route('success', ['reservation' => $reservation->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('mypage'),
            ],
            ['stripe_account' => $product->shop->stripe_account],
        );
        return redirect($response['url']);
    }

    public function success(Reservation $reservation, Request $request)
    {
        if (!$request->get('session_id')) {
            return redirect('/mypage');
        }
        $reservation->update(['pay' => 'done']);
        return redirect('/mypage');
    }
}
