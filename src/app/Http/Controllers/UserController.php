<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Http\Requests\FavoriteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favorites = User::with('favorite.genre', 'favorite.area')->where('id', $user->id)->get();
        $reservations = User::with('reservation.genre', 'reservation.area')->where('id', $user->id)->get();

        return view('mypage', compact('user', 'favorites', 'reservations'));
    }

    public function showDone()
    {
        return view('done');
    }

    public function storeReservation(ReservationRequest $request)
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

    public function destroyReservation(Request $request)
    {
        Reservation::find($request->id)->delete();

        return back();
    }

    public function showChange(Request $request)
    {
        $reservation = Reservation::with('shop')->where('id', $request->id)->first();
        // dd($reservation);
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

    public function storeFavorite(FavoriteRequest $request)
    {
        $user = Auth::user();
        if ($user->id == $request->user_id) {
            $favorite = $request->only('user_id', 'shop_id');
            Favorite::create($favorite);
        }

        return back();
    }

    public function destroyFavorite(Request $request)
    {
        Favorite::where([
            ['user_id', '=', $request->user_id],
            ['shop_id', '=', $request->shop_id],
        ])->delete();

        return back();
    }
}
