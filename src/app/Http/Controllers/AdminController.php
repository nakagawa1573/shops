<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateAccountRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationEmail;
use App\Models\User;
use App\Http\Requests\EmailRequest;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\ShopGenre;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AdminController extends Controller
{
    public function index()
    {
        return view('auth.admin');
    }

    public function store(CreateAccountRequest $request)
    {
        $owner = $request->only(['name', 'email']);
        $owner['password'] = Hash::make($request->password);
        $user = Owner::create($owner);
        event(new Registered($user));
        return redirect('/admin')->with('message', 'アカウントを作成しました');
    }

    public function create()
    {
        return view('import');
    }

    public function storeShop(Request $request)
    {
        $count = 0;
        $imgBox = [];
        $validateRule = [
            0 => ['required', 'max:50'],
            1 => ['required'],
            2 => ['required'],
            3 => ['required', 'max:400'],
            4 => ['required'],
        ];
        try {
            DB::beginTransaction();
            if ($request->hasFile('csvFile')) {
                $file = $request->file('csvFile');
                $csv = IOFactory::load($file->getPathName());
                $csvData = $csv->getActiveSheet()->toArray();
                foreach ($csvData as $data) {
                    //配列のバリデート
                    $result = Validator::make($data, $validateRule);
                    if ($result->fails()) {
                        throw new Exception('要件を満たしていないデータがあります');
                    }
                    $shop = ['owner_id' => null];
                    if (filter_var($data[4], FILTER_VALIDATE_URL)) {
                        $imgData = Http::get($data[4]);
                        if ($imgData->successful()) {
                            $imageId = Str::uuid()->toString();
                            //拡張子のバリデート
                            if ($imgData->header('Content-Type') === 'image/jpeg') {
                                $imgPath = 'shop/' . $imageId . '.jpeg';
                            } elseif ($imgData->header('Content-Type') === 'image/png') {
                                $imgPath = 'shop/' . $imageId . '.png';
                            } else {
                                throw new Exception('jpegかpngの画像を選択してください');
                            }
                            Storage::disk('public')->put($imgPath, $imgData->body());
                            $shop['img'] = basename($imgPath);
                            $imgBox[] = basename($imgPath);
                        } else {
                            throw new Exception('画像の取得に失敗しました');
                        }
                    } else {
                        throw new Exception('正しいURLを記述してください');
                    }
                    //地域のバリデート
                    if ($data[1] === '東京都' || $data[1] === '大阪府' || $data[1] === '福岡県') {
                        $area = Area::where('area', $data[1])->first();
                    }else{
                        throw new Exception('正しい地域を入力してください');
                    }
                    $shop['area_id'] = $area->id;
                    $shop['shop'] = $data[0];
                    $shop['overview'] = $data[3];
                    $shopId = Shop::create($shop)->id;
                    $genreData['shop_id'] = $shopId;
                    $genres = explode('、', $data[2]);
                    foreach ($genres as $genre) {
                        $genre = Genre::where('genre', $genre)->first();
                        //ジャンルのバリデート
                        if ($genre === null) {
                            throw new Exception('正しいジャンルを入力してください');
                        }
                        $genreData['genre_id'] = $genre->id;
                        ShopGenre::create($genreData);
                    }
                    $count++;
                }
                $message = $count . '個の店舗を作成しました';
                DB::commit();

                return back()->with('message', $message);
            } else {
                throw new Exception('ファイルを選択してください');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            foreach ($imgBox as $img) {
                Storage::disk('public')->delete('shop/' . $img);
            }
            $message = $e->getMessage();

            return back()->with('message', $message);
        }
    }

    public function showMail()
    {
        return view('mail');
    }

    public function send(EmailRequest $request)
    {
        $subject = $request->input('subject');
        $content = $request->input('content');
        $addresses = User::all();
        foreach ($addresses as $address) {
            Mail::to($address)->send(new NotificationEmail($subject, $content));
        }

        return redirect('/admin/mail')->with('message', 'メールを送信しました');
    }
}
