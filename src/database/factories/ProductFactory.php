<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_name' => $this->faker->word,
            'brand' => $this->faker->company,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(1000, 10000),
            'condition' => $this->faker->word,
            'img_url' => 'test.jpg',
            'user_id' => User::factory(),
        ];
    }
}