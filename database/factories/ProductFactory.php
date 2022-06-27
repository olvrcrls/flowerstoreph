<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' => "Product " . $this->faker->firstName(),
            'product_description' => $this->faker->text(50),
            'quantity' => mt_rand(1, 100),
            'price' => mt_rand(1000, 2499.99)
        ];
    }
}
