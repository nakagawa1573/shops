<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Shop;


class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favorites = User::with('favorite.genre', 'favorite.area', 'favorite.evaluation')->where('id', $user->id)->get();
        $reservations = User::with('reservation.genre', 'reservation.area')->where('id', $user->id)->get();
        foreach ($favorites as $favorite) {
            foreach ($favorite->favorite as $favorite) {
                if ($favorite->average === null) {
                    $evaluationController = new EvaluationController();
                    $evaluationController->average($favorite);
                }
            }
        }
        return view('mypage', compact('user', 'favorites', 'reservations'));
    }

    public function store(Shop $shop)
    {
        $favorite['shop_id'] = $shop->id;
        $favorite['user_id'] = Auth::user()->id;
        Favorite::create($favorite);

        return back();
    }

    public function destroy(Shop $shop)
    {
        Favorite::where([
            ['user_id', '=', Auth::user()->id],
            ['shop_id', '=', $shop->id],
        ])->delete();

        return back();
    }
}
