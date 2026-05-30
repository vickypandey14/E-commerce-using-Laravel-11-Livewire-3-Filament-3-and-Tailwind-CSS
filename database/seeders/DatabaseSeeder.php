<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a default admin/test user and additional random users
        $admin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        
        $users = User::factory(10)->create();
        $users->push($admin);

        // 2. Create Categories
        $categories = Category::factory(5)->create();

        // 3. Create Brands
        $brands = Brand::factory(5)->create();

        // 4. Create Products and assign them to categories and brands
        $products = collect();
        foreach ($categories as $category) {
            foreach ($brands as $brand) {
                // Create 2 products per category/brand combination (total 50 products)
                $categoryBrandProducts = Product::factory(2)->create([
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                ]);
                $products = $products->concat($categoryBrandProducts);
            }
        }

        // 5. Create Orders, OrderItems, and Addresses
        foreach ($users as $user) {
            // Create 1-3 orders for each user
            $orderCount = rand(1, 3);
            for ($i = 0; $i < $orderCount; $i++) {
                // Determine order items details (1 to 4 products)
                $itemsCount = rand(1, 4);
                $selectedProducts = $products->random($itemsCount);
                
                $grandTotal = 0;
                $orderItemsData = [];

                foreach ($selectedProducts as $product) {
                    $qty = rand(1, 3);
                    $price = $product->price;
                    $total = $qty * $price;
                    $grandTotal += $total;

                    $orderItemsData[] = [
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'unit_amount' => $price,
                        'total_amount' => $total,
                    ];
                }

                $shippingAmount = rand(0, 1) ? 10.00 : 0.00; // Free shipping or $10.00
                $grandTotal += $shippingAmount;

                // Create the order
                $order = Order::factory()->create([
                    'user_id' => $user->id,
                    'grand_total' => $grandTotal,
                    'shipping_amount' => $shippingAmount,
                ]);

                // Create the order items associated with the order
                foreach ($orderItemsData as $itemData) {
                    OrderItem::factory()->create(array_merge($itemData, [
                        'order_id' => $order->id,
                    ]));
                }

                // Create the address for the order
                Address::factory()->create([
                    'order_id' => $order->id,
                ]);
            }
        }
    }
}
