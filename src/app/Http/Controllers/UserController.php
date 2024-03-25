<?php

namespace App\Http\Controllers;


use App\Http\Requests\FavoriteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favorites = User::with('favorite.genre', 'favorite.area', 'favorite.evaluation')->where('id', $user->id)->get();
        $reservations = User::with('reservation.genre', 'reservation.area')->where('id', $user->id)->get();

        return view('mypage', compact('user', 'favorites', 'reservations'));
    }

    public function store(FavoriteRequest $request)
    {
        $user = Auth::user();
        $favorite = $request->only('shop_id');
        $favorite['user_id'] = $user->id;
        Favorite::create($favorite);

        return back();
    }

    public function destroy(Request $request)
    {
        Favorite::where([
            ['user_id', '=', Auth::user()->id],
            ['shop_id', '=', $request->shop_id],
        ])->delete();

        return back();
    }
}
