<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Genre;
use App\Models\Area;
use App\Models\Shop;
use App\Models\ShopGenre;
use App\Http\Requests\CreateShopRequest;
use App\Models\Reservation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

class OwnerController extends Controller
{

    public function index()
    {
        $genres = Genre::all();
        $areas = Area::all();
        $id = Auth::guard('owners')->user()->id;
        $shopData = Shop::with('genre')->where('owner_id', $id)->first();
        if ($shopData) {
            $genreDatas = ShopGenre::where('shop_id', $shopData->id)->get();
            $reservations = Reservation::with('user')->where('shop_id', $shopData->id)->oldest('Date')->get();
            return view('owner', compact('genres', 'areas', 'shopData', 'genreDatas', 'reservations'));
        }

        return view('owner', compact('genres', 'areas'));
    }

    public function create()
    {
        if (Auth::guard('owners')->user()) {
            return redirect('/owner');
        }

        return view('auth.ownerLogin');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (Auth::guard('owners')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/owner');
        } else {
            return back()->withErrors([
                'error' => 'ログインに失敗しました'
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('owners')->logout();
        return redirect('/owner/login');
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

    public function update(CreateShopRequest $request)
    {
        $shop = Shop::with('genre')->where('id', $request->id)->first();

        if (Auth::guard('owners')->user()->id !== $shop->owner_id) {
            return redirect('/owner');
        }

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
