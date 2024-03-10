<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 2, $max = 11),
            'shop_id' => $this->faker->numberBetween($min = 1, $max = 20),
            'evaluation' => $this->faker->numberBetween($min = 1, $max = 5),
            'comment' => 'こちらのお店は雰囲気がとても良く、リラックスして過ごすことができました。メニューも豊富で、美味しい料理を楽しむことができました。次回もぜひ訪れたいと思います。',
        ];
    }
}
