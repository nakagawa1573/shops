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
        $favorites = User::with('favorite.genre', 'favorite.area')->get();
        $reservations = User::with('reservation.genre', 'reservation.area')->get();

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

        if (Carbon::parse($date . $time) > Carbon::now()) {
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

    public function storeFavorite(FavoriteRequest $request)
    {
        $favorite = $request->only('user_id', 'shop_id');
        Favorite::create($favorite);

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
