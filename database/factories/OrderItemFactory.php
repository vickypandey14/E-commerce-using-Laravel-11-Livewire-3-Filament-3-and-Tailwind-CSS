<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 5);
        $unitAmount = fake()->randomFloat(2, 10, 500);
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'quantity' => $quantity,
            'unit_amount' => $unitAmount,
            'total_amount' => $quantity * $unitAmount,
        ];
    }
}
