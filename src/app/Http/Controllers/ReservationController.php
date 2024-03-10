<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
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
        $reservation = $request->only(['user_id', 'shop_id', 'date', 'time', 'number']);
        $date = $request->date;
        $time = $request->time;
        $user = Auth::user();

        if (Carbon::parse($date . $time) > Carbon::now() && $user->id == $request->user_id) {
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

    public function showChange(Request $request)
    {
        $reservation = Reservation::with('shop')->where('id', $request->id)->first();
        return view('change', compact('reservation'));
    }

    public function change(ReservationRequest $request)
    {
        $user = Auth::user();
        $date = $request->date;
        $time = $request->time;

        if (Carbon::parse($date . $time) > Carbon::now() && $request->id == $user->id) {
            Reservation::find($request->id)->update([
                'date' => $request->date,
                'time' => $request->time,
                'number' => $request->number,
            ]);
        } else {
            return back()->with('message', '予約手続きに失敗しました');
        }

        return redirect('/mypage');
    }
}
