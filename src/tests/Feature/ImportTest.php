<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Owner;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImportTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testImportCsvSuccessFromAdmin(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                '東京都',
                '寿司',
                'テストです',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
            [
                'テスト2号店',
                '大阪府',
                'ラーメン',
                'テストだよ',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
            [
                'テスト3号店',
                '福岡県',
                '居酒屋',
                'テストだ',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
            ->post('/admin/import', [
                'csvFile' => $file,
            ]);
        $response->assertSessionHas('message', '3個の店舗を作成しました');
        foreach ($csvRows as $csvRow) {
            $genreId = Genre::where('genre', $csvRow[2])->first()->id;
            $areaId = Area::where('area', $csvRow[1])->first()->id;
            $shop = Shop::where('area_id', $areaId)
                ->where('shop', $csvRow[0])
                ->where('overview', $csvRow[3])
                ->first();
            $this->assertTrue(isset($shop));
            $this->assertDatabaseHas('shop_genres', [
                'shop_id' => $shop->id,
                'genre_id' => $genreId,
            ]);
            Storage::disk('public')->delete('shop/' . $shop->img);
        }
        $response->assertSessionHasNoErrors();
    }

    public function testImportCsvErrorFromOwner(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                '東京都',
                '寿司',
                'テストです',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
            [
                'テスト2号店',
                '大阪府',
                'ラーメン',
                'テストだよ',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
            [
                'テスト3号店',
                '福岡県',
                '居酒屋',
                'テストだ',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Owner::inRandomOrder()->first();
        $response = $this->followingRedirects()
            ->actingAs($user, 'owners')
            ->post('/admin/import', [
                'csvFile' => $file,
            ]);
        $response->assertViewIs('index');
        foreach ($csvRows as $csvRow) {
            $areaId = Area::where('area', $csvRow[1])->first()->id;
            $this->assertDatabaseMissing('shops', [
                'area_id' => $areaId,
                'shop' => $csvRow[0],
                'overview' => $csvRow[3],
            ]);
        }
    }

    public function testImportCsvErrorFromUser(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                '東京都',
                '寿司',
                'テストです',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
            [
                'テスト2号店',
                '大阪府',
                'ラーメン',
                'テストだよ',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
            [
                'テスト3号店',
                '福岡県',
                '居酒屋',
                'テストだ',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = User::inRandomOrder()->first();
        $response = $this->followingRedirects()
            ->actingAs($user)
            ->post('/admin/import', [
                'csvFile' => $file,
            ]);
        $response->assertViewIs('index');
        foreach ($csvRows as $csvRow) {
            $areaId = Area::where('area', $csvRow[1])->first()->id;
            $this->assertDatabaseMissing('shops', [
                'area_id' => $areaId,
                'shop' => $csvRow[0],
                'overview' => $csvRow[3],
            ]);
        }
    }

    public function testImportCsvErrorShopNull(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                null,
                '東京都',
                '寿司',
                'テストです',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
            ->post('/admin/import', [
                'csvFile' => $file,
            ]);
        $response->assertSessionHasErrors('csv_data.*.0');
    }

    public function testImportCsvErrorShopMax(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                fake()->realText(55),
                '東京都',
                '寿司',
                'テストです',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
            ->post('/admin/import', [
                'csvFile' => $file,
            ]);
        $response->assertSessionHasErrors('csv_data.*.0');
    }

    public function testImportCsvErrorAreaNull(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                null,
                '寿司',
                'テストです',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
            ->post('/admin/import', [
                'csvFile' => $file,
            ]);
        $response->assertSessionHasErrors('csv_data.*.1');
    }

    public function testImportCsvErrorAreaOther(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                '埼玉県',
                '寿司',
                'テストです',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
        ->post('/admin/import', [
            'csvFile' => $file,
        ]);
        $response->assertSessionHasErrors('csv_data.*.1');
    }

    public function testImportCsvErrorGenreNull(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                '埼玉県',
                null,
                'テストです',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
        ->post('/admin/import', [
            'csvFile' => $file,
        ]);
        $response->assertSessionHasErrors('csv_data.*.2');
    }

    public function testImportCsvErrorGenreOther(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                '東京都',
                '和食',
                'テストです',
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
        ->post('/admin/import', [
            'csvFile' => $file,
        ]);
        $response->assertSessionHasErrors('csv_data.*.2');
    }

    public function testImportCsvErrorUrlNull(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                '東京都',
                '寿司',
                'テストです',
                null,
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
        ->post('/admin/import', [
            'csvFile' => $file,
        ]);
        $response->assertSessionHasErrors('csv_data.*.4');
    }

    public function testImportCsvErrorUrlFormat(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                '東京都',
                '寿司',
                'テストです',
                'test',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
        ->post('/admin/import', [
            'csvFile' => $file,
        ]);
        $response->assertSessionHasErrors('csv_data.*.4');
    }

    public function testImportCsvErrorUrlOther(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                '東京都',
                '寿司',
                'テストです',
                'https://docs.google.com/spreadsheets/d/1uAMsN2plJJnslMP9b08rwPnR5UznwJlhxVj3-LSqCuI/edit#gid=0',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
        ->post('/admin/import', [
            'csvFile' => $file,
        ]);
        $response->assertSessionHasErrors('csv_data.*.4');
    }

    public function testImportCsvErrorImgFormat(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                '東京都',
                '寿司',
                'テストです',
                'https://raw.githubusercontent.com/nakagawa1573/images/d1433b88e80c85a3c56707f954b9f473f1342631/market/logo.svg',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
        ->post('/admin/import', [
            'csvFile' => $file,
        ]);
        $response->assertSessionHasErrors('csv_data.*.4');
    }

    public function testImportCsvErrorOverviewNull(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                '東京都',
                '寿司',
                null,
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
        ->post('/admin/import', [
            'csvFile' => $file,
        ]);
        $response->assertSessionHasErrors('csv_data.*.3');
    }

    public function testImportCsvErrorOverviewMax(): void
    {
        $tmp_fp = tmpfile();
        $csvRows = [
            [
                'テスト店',
                '東京都',
                '寿司',
                fake()->realText(450),
                'https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/menu1.png',
            ],
        ];
        foreach ($csvRows as $csvRow) {
            fputcsv($tmp_fp, $csvRow);
        }
        $tmp_meta = stream_get_meta_data($tmp_fp);
        $tmp_path = $tmp_meta['uri'];
        $file = new UploadedFile($tmp_path, 'upload.csv', 'text/csv', null, true);
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
        ->post('/admin/import', [
            'csvFile' => $file,
        ]);
        $response->assertSessionHasErrors('csv_data.*.3');
    }

    public function testImportCsvErrorHavenotCsv(): void
    {
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
        ->post('/admin/import');
        $response->assertSessionHasErrors('csvFile');
    }

    public function testImportCsvErrorCsvFormat()
    {
        $file = UploadedFile::fake()->image('shop.jpg');
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
        ->post('/admin/import', [
            'csvFile' => $file,
        ]);
        $response->assertSessionHasErrors('csvFile');
    }
}
