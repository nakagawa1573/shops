<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function showDone()
    {
        return view('done');
    }

    public function store(ReservationRequest $request)
    {
        $reservation = $request->only(['shop_id', 'date', 'time', 'number']);
        $reservation['user_id'] = Auth::user()->id;
        $date = $request->date;
        $time = $request->time;

        if (Carbon::parse($date . $time) > Carbon::now()) {
            Reservation::create($reservation);
            return redirect('/done');
        } else {
            return back()->with('message', '予約手続きに失敗しました');
        }
    }

    public function destroy(Request $request)
    {
        Reservation::find($request->id)->delete();

        return back();
    }

    public function showUpdate(Request $request)
    {
        session(['url' => route('mypage')]);
        $reservation = Reservation::with('shop')->where('id', $request->id)->first();
        return view('updateReservation', compact('reservation'));
    }

    public function update(ReservationRequest $request)
    {
        $date = $request->date;
        $time = $request->time;
        $data = Reservation::find($request->id);
        if (!is_null($data) && $data->shop_id == $request->shop_id && Carbon::parse($date . ' ' . $time) > Carbon::now()) {
            $data->update([
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
        $this->authorize('create', $reservation);
        $priceId = Product::find($reservation->product_id)->product;
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $response = $stripe->checkout->sessions->create(
            [
                'line_items' => [
                    [
                        'price' => $priceId,
                        'quantity' => 1,
                    ],
                ],
                'automatic_tax' => ['enabled' => true],
                'mode' => 'payment',
                'success_url' => route('success', ['reservation' => $reservation->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('mypage'),
            ],
            ['stripe_account' => 'acct_1OwaFqIAfOPo2c24'],
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
