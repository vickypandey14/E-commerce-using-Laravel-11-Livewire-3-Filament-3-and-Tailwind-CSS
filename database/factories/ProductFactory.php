<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        return [
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'images' => [],
            'description' => fake()->paragraphs(3, true),
            'short_description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'sku' => strtoupper(fake()->bothify('???-#####')),
            'is_active' => true,
            'is_featured' => fake()->boolean(20),
            'in_stock' => true,
            'on_sale' => fake()->boolean(30),
            'meta_title' => ucfirst($name),
            'meta_description' => fake()->sentence(),
            'meta_keywords' => implode(',', fake()->words(5)),
        ];
    }
}
