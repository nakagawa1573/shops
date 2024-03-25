<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EvaluationRequest;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Evaluation;
use App\Models\Genre;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;



class ShopController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $area_id = $request->area_id;
        $genre_id = $request->genre_id;

        $shops = Shop::with('area', 'genre', 'evaluation')
            ->shopSearch($keyword)
            ->areaSearch($area_id)
            ->genreSearch($genre_id)
            ->get();
        $user = Auth::user();
        $areas = Area::all();
        $genres = Genre::all();

        if ($user) {
            $favorites = Favorite::where('user_id', $user->id)->get();
            return view('index', compact('shops', 'areas', 'genres', 'favorites', 'keyword', 'area_id', 'genre_id'));
        }

        return view('index', compact('shops', 'areas', 'genres', 'keyword', 'area_id', 'genre_id'));
    }

    public function show(Request $request)
    {
        $shop = Shop::find($request->id);
        $url = url()->previous();
        $mypage = route('mypage');
        $home = route('home') . '/';
        if ($url == $mypage || $url == $home) {
            session(['url' => $url]);
        }

        $evaluations = Evaluation::with('user')->where('shop_id', $shop->id)->get();

        return view('detail', compact('shop', 'evaluations'));
    }

    public function back()
    {
        $url = session('url');

        return redirect($url);
    }

    public function store(EvaluationRequest $request)
    {
        $evaluations = $request->only(['shop_id', 'evaluation', 'comment']);
        $evaluations['user_id'] = Auth::user()->id;
        Evaluation::create($evaluations);

        return back();
    }
}
