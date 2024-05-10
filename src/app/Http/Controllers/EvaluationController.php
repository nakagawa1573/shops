<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Shop;
use App\Http\Requests\EvaluationRequest;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EvaluationController extends Controller
{
    public function show(Shop $shop_id)
    {
        $shop = Shop::find($shop_id->id);
        $favorite = Favorite::where('user_id', Auth::user()->id)->where('shop_id', $shop_id->id)->first();
        $evaluation = Evaluation::where('user_id', Auth::user()->id)->where('shop_id', $shop_id->id)->first();
        return view('evaluation', compact('shop', 'favorite', 'evaluation'));
    }

    public function store(EvaluationRequest $request, Shop $shop_id)
    {
        $flag = Evaluation::where('user_id', Auth::user()->id)->where('shop_id', $shop_id->id)->exists();
        if ($flag) {
            return back()->with('message', '既に口コミが投稿されています');
        }
        $evaluations = $request->only(['evaluation', 'comment']);
        if ($request->file('img')) {
            $img = $request->file('img');
            $path = Storage::disk('public')->put('/evaluation', $img);
            $evaluations['img'] =  basename($path);
        }
        $evaluations['user_id'] = Auth::user()->id;
        $evaluations['shop_id'] = $shop_id->id;
        Evaluation::create($evaluations);
        $shop = Shop::find($shop_id->id);
        $this->average($shop);
        return redirect('/detail/' . $shop_id->id)->with('message', '投稿に成功しました');
    }

    public function update(Shop $shop_id, Evaluation $evaluation_id, EvaluationRequest $request)
    {
        $this->authorize('update', $evaluation_id);
        $evaluations = $request->only(['evaluation', 'comment']);
        if ($request->file('img')) {
            $img = $request->file('img');
            $path = Storage::disk('public')->put('/evaluation', $img);
            $evaluations['img'] = basename($path);
            if (isset($evaluation_id->img)) {
                Storage::disk('public')->delete('evaluation/'. $evaluation_id->img);
            }
        }
        $evaluation_id->update($evaluations);
        return redirect('/detail/' . $shop_id->id)->with('message', '更新に成功しました');
    }

    public function destroy(Evaluation $evaluation_id)
    {
        if (!Auth::guard('admins')->check()) {
            $this->authorize('destroy', $evaluation_id);
        }
        if (isset($evaluation_id->img)) {
            Storage::disk('public')->delete('evaluation/' . $evaluation_id->img);
        }
        Evaluation::find($evaluation_id->id)->delete();
        $shop = Shop::find($evaluation_id->shop_id);
        $this->average($shop);
        return back()->with('message', '削除に成功しました');
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
