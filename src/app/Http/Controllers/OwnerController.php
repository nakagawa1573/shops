<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Genre;
use App\Models\Area;
use App\Models\Shop;
use App\Models\ShopGenre;
use App\Http\Requests\CreateShopRequest;
use App\Http\Requests\KeywordRequest;
use App\Models\Reservation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class OwnerController extends Controller
{

    public function index(keywordRequest $request)
    {
        $genres = Genre::all();
        $areas = Area::all();
        $id = Auth::guard('owners')->user()->id;
        $shopData = Shop::with('genre')->where('owner_id', $id)->first();
        if ($shopData) {
            $genreDatas = ShopGenre::where('shop_id', $shopData->id)->get();
            $now = Carbon::now()->format('Y-m-d');
            $filter = $request->filter ?? 1;
            $keyword = $request->keyword;
            if ($filter == 1) {
                $reservations = Reservation::with('user')
                    ->where('shop_id', $shopData->id)
                    ->where('date', '>=', $now)
                    ->searchKeyword($keyword)
                    ->oldest('Date')
                    ->get();
            } else {
                $reservations = Reservation::with('user')
                    ->where('shop_id', $shopData->id)
                    ->searchKeyword($keyword)
                    ->oldest('Date')
                    ->get();
            }
            return view('owner', compact('genres', 'areas', 'shopData', 'genreDatas', 'reservations', 'filter', 'keyword'));
        }

        return view('owner', compact('genres', 'areas'));
    }

    public function store(CreateShopRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'img' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['img' => 'トップ画像を選択してください']);
        }

        $shopData = $request->only(['shop', 'area_id', 'overview']);
        $img = $request->file('img');
        $path = $img->store('public/shop');
        $imgName = basename($path);
        $shopData['img'] = $imgName;
        $shopData['owner_id'] = Auth::guard('owners')->user()->id;
        $shopId = Shop::create($shopData)->id;
        foreach ($request->genre_id as $id) {
            $data = ['shop_id' => $shopId, 'genre_id' => $id];
            ShopGenre::create($data);
        }

        return redirect('/owner');
    }

    public function update(CreateShopRequest $request, Shop $shop)
    {
        $this->authorize($shop);
        $shopData = $request->only(['shop', 'area_id', 'overview']);
        $img = $request->file('img');
        if ($img) {
            $imgName = $shop->img;
            Storage::disk('public')->delete('shop/' . $imgName);
            $path = $img->store('public/shop');
            $imgName = basename($path);
            $shopData['img'] = $imgName;
        }
        $shop->update($shopData);
        ShopGenre::where('shop_id', $shop->id)->delete();
        foreach ($request->genre_id as $id) {
            $data = ['shop_id' => $shop->id, 'genre_id' => $id];
            ShopGenre::create($data);
        }

        return redirect('/owner');
    }
}
