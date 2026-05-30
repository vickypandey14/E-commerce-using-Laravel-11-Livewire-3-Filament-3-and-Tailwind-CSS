<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $name = fake()->unique()->company;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => null,
            'is_active' => true,
        ];
    }
}
