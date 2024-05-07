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

use function PHPUnit\Framework\isNull;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $area_id = $request->area_id;
        $genre_id = $request->genre_id;
        $sort = $request->sort;

        $shops = Shop::with('area', 'genre', 'evaluation')
            ->shopSearch($keyword)
            ->areaSearch($area_id)
            ->genreSearch($genre_id)
            ->get();
        $user = Auth::user();
        $areas = Area::all();
        $genres = Genre::all();

        foreach ($shops as $shop) {
            if ($shop->average == null) {
                $this->average($shop);
            }
        }

        if ($sort === "random") {
            $shops = $shops->shuffle();
        } elseif ($sort === "high") {
            $shops = $shops->sortByDesc('average');
        } elseif ($sort === "low") {
            $shops = $shops->sortBy(function($shop){
                return $shop->average == 0 ? PHP_FLOAT_MAX : $shop->average;
            });
        }

        if ($user) {
            $favorites = Favorite::where('user_id', $user->id)->get();
            return view('index', compact('shops', 'areas', 'genres', 'favorites', 'keyword', 'area_id','genre_id', 'sort'));
        }

        return view('index', compact('shops', 'areas', 'genres', 'keyword', 'area_id', 'genre_id', 'sort'));
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
        if (isNull($url)) {
            return redirect('/');
        }
        return redirect($url);
    }

    public function store(EvaluationRequest $request, Shop $shop_id)
    {
        $evaluations = $request->only(['evaluation', 'comment']);
        $evaluations['user_id'] = Auth::user()->id;
        $evaluations['shop_id'] = $shop_id->id;
        Evaluation::create($evaluations);
        $shop = Shop::find($shop_id->id);
        $this->average($shop);
        return back();
    }

    public function average($shop)
    {
        $count = 0;
        $countData = $shop->evaluation->count();
        foreach ($shop->evaluation as $evaluation) {
            $count += $evaluation->pivot->evaluation;
        }
        if ($countData == 0) {
            $average = 0;
        } else {
            $average = number_format($count / $countData, 1);
        }
        $shop->average = $average;
        $shop->save();
    }
}
