<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Owner;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class OwnerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function testCreateShopSuccess(): void
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('shops', [
            'area_id' => $area_id,
            'owner_id' => $owner->id,
            'shop' => 'test',
            'overview' => 'test',
        ]);
        $shop = Shop::where('owner_id', $owner->id)->first();
        foreach ($genre_id as $genre_id) {
            $this->assertDatabaseHas('shop_genres', [
                'shop_id' => $shop->id,
                'genre_id' => $genre_id
            ]);
        }
        //テストで使用した画像を削除するための処理
        $shop = Shop::where('owner_id', $owner->id)->first();
        Storage::disk('public')->delete('shop/' . $shop->img);
    }

    public function testCreateShopErrorNotLogin(): void
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->post('/owner', [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('shops', [
            'area_id' => $area_id,
            'owner_id' => $owner->id,
            'shop' => 'test',
            'overview' => 'test',
        ]);
    }

    public function testCreateShopErrorShopNull()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => null,
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('shop');
    }

    public function testCreateShopErrorShopType()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => ['shop' => 'test'],
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('shop');
    }

    public function testCreateShopErrorShopMax()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('shop');
    }

    public function testCreateShopErrorAreaIdNull()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => null,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('area_id');
    }

    public function testCreateShopErrorAreaIdType()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => 'test',
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('area_id');
    }

    public function testCreateShopErrorAreaIdBetween()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => 0,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('area_id');
    }

    public function testCreateShopErrorGenreIdNull()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => null,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('genre_id');
    }

    public function testCreateShopErrorGenreIdNoArray()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => 1,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('genre_id');
    }

    public function testCreateShopErrorGenreIdMax()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 4, $max = 5);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('genre_id');
    }

    public function testCreateShopErrorGenreIdType()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => ['test'],
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('genre_id.*');
    }

    public function testCreateShopErrorGenreIdBetween()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => [0, 1, 2],
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('genre_id.*');
    }

    public function testCreateShopErrorOverviewNull()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => null,
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('overview');
    }

    public function testCreateShopErrorOverviewMax()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('overview');
    }

    public function testCreateShopErrorImgNull()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => null,
        ]);
        $response->assertSessionHasErrors('img');
    }

    public function testCreateShopErrorImgType()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => 'test.jpg',
        ]);
        $response->assertSessionHasErrors('img');
    }

    public function testCreateShopErrorImgMax()
    {
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg')->size(6000);
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->post('/owner', [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertSessionHasErrors('img');
    }

    public function testUpdateShopSuccess()
    {
        $shop = Shop::factory()->create();
        $owner = Owner::find($shop->owner_id);
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $this->actingAs($owner, 'owners')->patch('/owner/update/' . $shop->id, [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $this->assertDatabaseHas('shops', [
            'shop' => 'test',
            'owner_id' => $owner->id,
            'area_id' => $area_id,
            'overview' => 'test',
        ]);
        foreach ($genre_id as $genre_id) {
            $this->assertDatabaseHas('shop_genres', [
                'shop_id' => $shop->id,
                'genre_id' => $genre_id
            ]);
        }
        //テストで使用した画像を削除するための処理
        $shop = Shop::where('owner_id', $owner->id)->first();
        Storage::disk('public')->delete('shop/' . $shop->img);
    }

    public function testUpdateShopErrorNotLogin()
    {
        $shop = Shop::factory()->create();
        $owner = Owner::find($shop->owner_id);
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->patch('/owner/update/' . $shop->id, [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('shops', [
            'shop' => 'test',
            'owner_id' => $owner->id,
            'area_id' => $area_id,
            'overview' => 'test',
        ]);
    }

    public function testUpdateShopSuccessVerImgNull()
    {
        $shop = Shop::factory()->create();
        $owner = Owner::find($shop->owner_id);
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $this->actingAs($owner, 'owners')->patch('/owner/update/' . $shop->id, [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
        ]);
        $this->assertDatabaseHas('shops', [
            'shop' => 'test',
            'owner_id' => $owner->id,
            'area_id' => $area_id,
            'overview' => 'test',
        ]);
        foreach ($genre_id as $genre_id) {
            $this->assertDatabaseHas('shop_genres', [
                'shop_id' => $shop->id,
                'genre_id' => $genre_id
            ]);
        }
    }

    public function testUpdateShopErrorShopId()
    {
        $shop = Shop::inRandomOrder()->first();
        $owner = Owner::factory()->create();
        $image = UploadedFile::fake()->image('shop.jpg');
        $count = fake()->numberBetween($min = 1, $max = 3);
        $area_id = fake()->numberBetween($min = 1, $max = 47);
        $genre_id = [];
        for ($i = 0; $i < $count; $i++) {
            $genre_id[] = fake()->numberBetween($min = 1, $max = 5);
        }
        $response = $this->actingAs($owner, 'owners')->patch('/owner/update/' . $shop->id, [
            'shop' => 'test',
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'overview' => 'test',
            'img' => $image,
        ]);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('shops', [
            'shop' => 'test',
            'owner_id' => $owner->id,
            'area_id' => $area_id,
            'overview' => 'test',
            'img' => $image,
        ]);
    }
}
