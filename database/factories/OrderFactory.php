<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'grand_total' => fake()->randomFloat(2, 50, 2000),
            'payment_method' => fake()->randomElement(['cod', 'stripe', 'paypal']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed']),
            'status' => fake()->randomElement(['new', 'processing', 'shipped', 'delivered', 'cancelled']),
            'currency' => 'usd',
            'shipping_amount' => fake()->randomFloat(2, 5, 50),
            'shipping_method' => fake()->randomElement(['standard', 'express']),
            'notes' => fake()->sentence(),
        ];
    }
}
