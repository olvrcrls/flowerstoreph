<?php

namespace Database\Factories;

use App\Models\{Order, Product, User};
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => mt_rand(1, 15),
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'price' => function (array $attributes) {
                $prodPrice = Product::find($attributes['product_id'])->price;
                return $prodPrice * $attributes['quantity'];
            }
        ];
    }
}
