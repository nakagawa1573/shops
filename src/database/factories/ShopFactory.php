<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'area_id' => fake()->numberBetween($min = 1, $max = 47),
            'owner_id' => 21,
            'shop' => 'テスト',
            'overview' => 'testtesttest',
            'img' => UploadedFile::fake()->image('shop.jpg'),
        ];
    }
}
