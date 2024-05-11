<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateAccountRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationEmail;
use App\Models\User;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\ImportRequest;
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

    public function storeShop(ImportRequest $request)
    {
        $count = 0;
        $imgBox = [];
        try {
            DB::beginTransaction();
            $file = $request->file('csvFile');
            $csv = IOFactory::load($file->getPathName());
            $csvData = $csv->getActiveSheet()->toArray();
            foreach ($csvData as $data) {
                $shop = ['owner_id' => null];

                $imgData = Http::get($data[4]);
                $imageId = Str::uuid()->toString();
                if ($imgData->header('Content-Type') === 'image/jpeg') {
                    $imgPath = 'shop/' . $imageId . '.jpeg';
                } elseif ($imgData->header('Content-Type') === 'image/png') {
                    $imgPath = 'shop/' . $imageId . '.png';
                }
                Storage::disk('public')->put($imgPath, $imgData->body());
                $shop['img'] = basename($imgPath);
                $imgBox[] = basename($imgPath);

                $area = Area::where('area', $data[1])->first();
                $shop['area_id'] = $area->id;
                $shop['shop'] = $data[0];
                $shop['overview'] = $data[3];
                $shopId = Shop::create($shop)->id;

                $genre = Genre::where('genre', $data[2])->first();
                $genreData['genre_id'] = $genre->id;
                $genreData['shop_id'] = $shopId;
                ShopGenre::create($genreData);
                $count++;
            }
            $message = $count . '個の店舗を作成しました';
            DB::commit();
            return back()->with('message', $message);
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
