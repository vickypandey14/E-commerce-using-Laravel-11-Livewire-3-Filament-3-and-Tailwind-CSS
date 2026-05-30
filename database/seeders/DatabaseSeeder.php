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
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Database is refreshed by migrate:fresh, so truncate is not needed.

        // 2. Create Users
        $admin = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );
        
        $users = collect([$admin]);
        for ($i = 1; $i <= 5; $i++) {
            $users->push(User::firstOrCreate(
                ['email' => "user{$i}@example.com"],
                [
                    'name' => "Customer {$i}",
                    'password' => bcrypt('password'),
                ]
            ));
        }

        // 3. Create Categories
        $categoriesData = [
            'Smartphones' => 'smartphones',
            'Laptops & Computers' => 'laptops-computers',
            'Audio & Headphones' => 'audio-headphones',
            'Smartwatches' => 'smartwatches',
            'Televisions' => 'televisions',
        ];

        $categories = [];
        foreach ($categoriesData as $name => $slug) {
            $categories[$slug] = Category::create([
                'name' => $name,
                'slug' => $slug,
                'is_active' => true,
            ]);
        }

        // 4. Create Brands
        $brandsData = [
            'Apple' => 'apple',
            'Samsung' => 'samsung',
            'Sony' => 'sony',
            'Dell' => 'dell',
            'Lenovo' => 'lenovo',
        ];

        $brands = [];
        foreach ($brandsData as $name => $slug) {
            $brands[$slug] = Brand::create([
                'name' => $name,
                'slug' => $slug,
                'is_active' => true,
            ]);
        }

        // 5. Create Products with Real Specifications and Prices
        $productsData = [
            // Apple Category: Smartphones
            [
                'category' => 'smartphones',
                'brand' => 'apple',
                'name' => 'Apple iPhone 15 Pro Max',
                'price' => 159900.00,
                'short_description' => 'Apple iPhone 15 Pro Max with 256GB storage, Titanium design, A17 Pro chip, and 5x Telephoto camera.',
                'sku' => 'IPH15PM-256',
                'is_featured' => true,
                'on_sale' => false,
            ],
            [
                'category' => 'smartphones',
                'brand' => 'apple',
                'name' => 'Apple iPhone 15',
                'price' => 79900.00,
                'short_description' => 'Apple iPhone 15 with 128GB storage, Dynamic Island, 48MP Main camera, and A16 Bionic chip.',
                'sku' => 'IPH15-128',
                'is_featured' => false,
                'on_sale' => true,
            ],
            // Apple Category: Laptops
            [
                'category' => 'laptops-computers',
                'brand' => 'apple',
                'name' => 'Apple MacBook Pro 14-inch (M3)',
                'price' => 169900.00,
                'short_description' => 'Apple MacBook Pro with M3 chip, 8-core CPU, 10-core GPU, 8GB Unified Memory, and 512GB SSD.',
                'sku' => 'MBP14M3-512',
                'is_featured' => true,
                'on_sale' => false,
            ],
            [
                'category' => 'laptops-computers',
                'brand' => 'apple',
                'name' => 'Apple MacBook Air 13-inch (M2)',
                'price' => 99900.00,
                'short_description' => 'Apple MacBook Air with M2 chip, 8GB Unified Memory, 256GB SSD, and Liquid Retina Display.',
                'sku' => 'MBA13M2-256',
                'is_featured' => false,
                'on_sale' => true,
            ],

            // Samsung Category: Smartphones
            [
                'category' => 'smartphones',
                'brand' => 'samsung',
                'name' => 'Samsung Galaxy S24 Ultra',
                'price' => 129999.00,
                'short_description' => 'Samsung Galaxy S24 Ultra with 12GB RAM, 256GB storage, Titanium Gray, and S Pen.',
                'sku' => 'S24U-256',
                'is_featured' => true,
                'on_sale' => false,
            ],
            [
                'category' => 'smartphones',
                'brand' => 'samsung',
                'name' => 'Samsung Galaxy Z Fold 5',
                'price' => 154999.00,
                'short_description' => 'Samsung Galaxy Z Fold 5 with 12GB RAM, 512GB storage, Phantom Black, and folding display.',
                'sku' => 'ZFOLD5-512',
                'is_featured' => false,
                'on_sale' => true,
            ],
            // Samsung Category: Smartwatches
            [
                'category' => 'smartwatches',
                'brand' => 'samsung',
                'name' => 'Samsung Galaxy Watch 6 LTE',
                'price' => 29999.00,
                'short_description' => 'Samsung Galaxy Watch 6 with LTE connectivity, 44mm aluminum body, and sleep tracking.',
                'sku' => 'GW6LTE-44',
                'is_featured' => false,
                'on_sale' => false,
            ],

            // Sony Category: Audio
            [
                'category' => 'audio-headphones',
                'brand' => 'sony',
                'name' => 'Sony WH-1000XM5 Wireless Headphones',
                'price' => 29990.00,
                'short_description' => 'Sony industry-leading noise canceling wireless over-ear headphones with 30-hour battery life.',
                'sku' => 'WH1000XM5-B',
                'is_featured' => true,
                'on_sale' => true,
            ],
            [
                'category' => 'audio-headphones',
                'brand' => 'sony',
                'name' => 'Sony WF-1000XM5 Wireless Earbuds',
                'price' => 24990.00,
                'short_description' => 'Sony WF-1000XM5 wireless noise canceling earbuds with high-res audio and premium call quality.',
                'sku' => 'WF1000XM5-B',
                'is_featured' => false,
                'on_sale' => false,
            ],
            // Sony Category: Televisions
            [
                'category' => 'televisions',
                'brand' => 'sony',
                'name' => 'Sony Bravia XR 55-inch OLED TV',
                'price' => 139900.00,
                'short_description' => 'Sony Bravia XR 55A80L Smart TV, 4K Ultra HD OLED, Cognitive Processor XR, Google TV.',
                'sku' => 'A80L-55',
                'is_featured' => true,
                'on_sale' => false,
            ],

            // Dell Category: Laptops
            [
                'category' => 'laptops-computers',
                'brand' => 'dell',
                'name' => 'Dell XPS 15 9530 Laptop',
                'price' => 189900.00,
                'short_description' => 'Dell XPS 15 with Intel Core i7, 16GB RAM, 512GB SSD, and NVIDIA RTX 4050 GPU.',
                'sku' => 'XPS15-9530',
                'is_featured' => true,
                'on_sale' => false,
            ],
            [
                'category' => 'laptops-computers',
                'brand' => 'dell',
                'name' => 'Dell Inspiron 15 Laptop',
                'price' => 54900.00,
                'short_description' => 'Dell Inspiron 15 with Intel Core i5 CPU, 8GB RAM, 512GB SSD, and 15.6-inch FHD Display.',
                'sku' => 'INS15-I5',
                'is_featured' => false,
                'on_sale' => true,
            ],

            // Lenovo Category: Laptops
            [
                'category' => 'laptops-computers',
                'brand' => 'lenovo',
                'name' => 'Lenovo ThinkPad X1 Carbon Gen 11',
                'price' => 199900.00,
                'short_description' => 'Lenovo ThinkPad X1 Carbon with Intel Core i7, 16GB RAM, 1TB SSD, and 14-inch WUXGA display.',
                'sku' => 'X1CG11-1T',
                'is_featured' => true,
                'on_sale' => false,
            ],
            [
                'category' => 'laptops-computers',
                'brand' => 'lenovo',
                'name' => 'Lenovo Legion 5 Pro Gaming Laptop',
                'price' => 144900.00,
                'short_description' => 'Lenovo Legion 5 Pro with AMD Ryzen 7, 16GB RAM, 1TB SSD, and NVIDIA RTX 4060 GPU.',
                'sku' => 'LEG5P-4060',
                'is_featured' => false,
                'on_sale' => true,
            ],
        ];

        $products = collect();
        foreach ($productsData as $p) {
            $products->push(Product::create([
                'category_id' => $categories[$p['category']]->id,
                'brand_id' => $brands[$p['brand']]->id,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'images' => [],
                'description' => $p['short_description'] . ' Features next-generation components and robust build quality.',
                'short_description' => $p['short_description'],
                'price' => $p['price'],
                'sku' => $p['sku'],
                'is_active' => true,
                'is_featured' => $p['is_featured'],
                'in_stock' => true,
                'on_sale' => $p['on_sale'],
                'meta_title' => $p['name'],
                'meta_description' => $p['short_description'],
                'meta_keywords' => strtolower($p['name'] . ', electronics, gadget'),
            ]));
        }

        // 6. Create Orders, OrderItems, and Addresses
        foreach ($users as $user) {
            // Create 1-2 orders for each customer
            $orderCount = rand(1, 2);
            for ($i = 0; $i < $orderCount; $i++) {
                $itemsCount = rand(1, 2);
                $selectedProducts = $products->random($itemsCount);
                
                $grandTotal = 0;
                $orderItemsData = [];

                foreach ($selectedProducts as $product) {
                    $qty = rand(1, 2);
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

                $shippingAmount = rand(0, 1) ? 150.00 : 0.00;
                $grandTotal += $shippingAmount;

                $order = Order::create([
                    'user_id' => $user->id,
                    'grand_total' => $grandTotal,
                    'payment_method' => 'cod',
                    'payment_status' => 'pending',
                    'status' => 'new',
                    'currency' => 'inr',
                    'shipping_amount' => $shippingAmount,
                    'shipping_method' => 'standard',
                    'notes' => 'Seeded real-world order.',
                ]);

                foreach ($orderItemsData as $itemData) {
                    OrderItem::create(array_merge($itemData, [
                        'order_id' => $order->id,
                    ]));
                }

                Address::create([
                    'order_id' => $order->id,
                    'first_name' => explode(' ', $user->name)[0],
                    'last_name' => explode(' ', $user->name)[1] ?? 'Customer',
                    'phone' => '9876543210',
                    'street_address' => '123 Tech Park Road, Sector 5',
                    'city' => 'Mumbai',
                    'state' => 'Maharashtra',
                    'zip_code' => '400001',
                ]);
            }
        }
    }
}
