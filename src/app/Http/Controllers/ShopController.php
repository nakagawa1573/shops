<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\ShopGenre;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $area_id = $request->area_id;
        $genre_id = $request->genre_id;

        $shops = Shop::with('area', 'genre')
            ->shopSearch($keyword)
            ->areaSearch($area_id)
            ->genreSearch($genre_id)
            ->get();
        $user = Auth::user();
        $areas = Area::all();
        $genres = Genre::all();

        if ($user) {
            $favorites = Favorite::where('user_id', $user->id)->get();
            return view('index', compact('shops', 'areas', 'genres', 'favorites', 'user', 'keyword', 'area_id', 'genre_id'));
        }

        return view('index', compact('shops', 'areas', 'genres', 'keyword', 'area_id', 'genre_id'));
    }

    public function showDetail(Request $request)
    {
        $shop = Shop::find($request->id);
        $url = url()->previous();
        $mypage = route('mypage');
        $home = route('home') . '/';
        if ($url == $mypage || $url == $home) {
            session(['url' => $url]);
        }

        return view('detail', compact('shop'));
    }

    public function back()
    {
        $url = session('url');

        return redirect($url);
    }
}
