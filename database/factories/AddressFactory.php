<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => fake()->phoneNumber(),
            'street_address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'zip_code' => fake()->postcode(),
        ];
    }
}
