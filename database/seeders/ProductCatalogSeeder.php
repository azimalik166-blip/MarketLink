<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FarmerProfile;
use App\Models\Market;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Adds a demo catalog of exactly 25 products per MarketLink category.
 *
 * Safe to run on the existing database: it updates/reuses the demo farmer's
 * products by name and only creates products that are missing. It does not
 * delete customer/farmer/admin data or reset the database.
 *
 * Product images are stored as public image URLs so the catalog is lightweight.
 * The product-media Blade component is patched to recognise full URLs while
 * continuing to support normal uploaded images saved to storage.
 */
class ProductCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $farmer = User::firstOrCreate(
            ['email' => 'farmer@marketlink.local'],
            [
                'name' => 'Green Valley Farms',
                'password' => Hash::make('Password123!'),
                'role' => 'farmer',
                'status' => 'active',
                'phone' => '03111111111',
                'address' => 'Hyderabad',
            ]
        );

        FarmerProfile::firstOrCreate(
            ['user_id' => $farmer->id],
            [
                'stall_name' => 'Green Valley Organics',
                'bio' => 'Fresh seasonal produce from local growers.',
                'operating_days' => 'Saturday, Sunday',
                'pickup_windows' => '09:00 AM - 02:00 PM',
                'address' => 'Auto Bhan Road, Hyderabad',
                'latitude' => 25.3960,
                'longitude' => 68.3578,
                'approval_status' => 'approved',
            ]
        );

        $markets = [
            Market::firstOrCreate(
                ['name' => 'Green Saturday Market'],
                [
                    'address' => 'Auto Bhan Road, Hyderabad',
                    'days' => 'Saturday',
                    'hours' => '08:00 AM - 03:00 PM',
                    'latitude' => 25.3960,
                    'longitude' => 68.3578,
                    'is_active' => true,
                ]
            ),
            Market::firstOrCreate(
                ['name' => 'Community Farmers Market'],
                [
                    'address' => 'Latifabad Unit 7, Hyderabad',
                    'days' => 'Sunday',
                    'hours' => '09:00 AM - 02:00 PM',
                    'latitude' => 25.3670,
                    'longitude' => 68.3530,
                    'is_active' => true,
                ]
            ),
        ];

        $catalog = [
            'Vegetables' => [
                ['Fresh Tomatoes', 180, 'kg'],
                ['Crisp Cucumbers', 140, 'kg'],
                ['Fresh Spinach', 60, 'bunch'],
                ['Crunchy Carrots', 110, 'kg'],
                ['Golden Potatoes', 95, 'kg'],
                ['Red Onions', 105, 'kg'],
                ['Fresh Cauliflower', 120, 'kg'],
                ['Green Cabbage', 90, 'kg'],
                ['Green Capsicum', 220, 'kg'],
                ['Fresh Green Chilies', 180, 'kg'],
                ['Tender Eggplant', 130, 'kg'],
                ['Okra', 170, 'kg'],
                ['Green Peas', 240, 'kg'],
                ['Fresh Beetroot', 150, 'kg'],
                ['Red Radish', 100, 'kg'],
                ['Fresh Turnip', 95, 'kg'],
                ['Organic Pumpkin', 90, 'kg'],
                ['Bottle Gourd', 100, 'kg'],
                ['Bitter Gourd', 160, 'kg'],
                ['Ridge Gourd', 140, 'kg'],
                ['Fresh Lettuce', 120, 'head'],
                ['Broccoli', 260, 'kg'],
                ['Sweet Corn', 130, 'kg'],
                ['Fresh Garlic', 420, 'kg'],
                ['Fresh Ginger', 360, 'kg'],
            ],
            'Fruits' => [
                ['Seasonal Mangoes', 320, 'kg'],
                ['Sweet Bananas', 180, 'dozen'],
                ['Red Apples', 360, 'kg'],
                ['Kinnow Oranges', 220, 'kg'],
                ['Fresh Guava', 240, 'kg'],
                ['Ripe Papaya', 190, 'kg'],
                ['Watermelon', 120, 'kg'],
                ['Sweet Muskmelon', 180, 'kg'],
                ['Pomegranates', 520, 'kg'],
                ['Seedless Grapes', 480, 'kg'],
                ['Fresh Strawberries', 650, 'box'],
                ['Juicy Peaches', 480, 'kg'],
                ['Fresh Plums', 420, 'kg'],
                ['Green Pears', 390, 'kg'],
                ['Fresh Kiwi', 850, 'kg'],
                ['Pineapple', 420, 'piece'],
                ['Fresh Coconut', 260, 'piece'],
                ['Fresh Lemons', 180, 'kg'],
                ['Fresh Limes', 240, 'kg'],
                ['Dragon Fruit', 950, 'kg'],
                ['Creamy Avocado', 900, 'kg'],
                ['Premium Dates', 650, 'kg'],
                ['Fresh Lychee', 700, 'kg'],
                ['Black Jamun', 420, 'kg'],
                ['Ripe Chikoo', 330, 'kg'],
            ],
            'Dairy' => [
                ['Farm Eggs', 360, 'dozen'],
                ['Fresh Farm Milk', 220, 'liter'],
                ['Desi Yogurt', 180, 'kg'],
                ['Greek Yogurt', 360, 'kg'],
                ['Plain Lassi', 180, 'liter'],
                ['Mango Lassi', 220, 'liter'],
                ['Salted Lassi', 190, 'liter'],
                ['Fresh Paneer', 620, 'kg'],
                ['Cottage Cheese', 580, 'kg'],
                ['Cheddar Cheese', 1250, 'kg'],
                ['Mozzarella Cheese', 1350, 'kg'],
                ['Farm Butter', 950, 'kg'],
                ['Desi Ghee', 1850, 'kg'],
                ['Fresh Cream', 720, 'liter'],
                ['Sour Cream', 650, 'kg'],
                ['Buttermilk', 160, 'liter'],
                ['Labneh', 680, 'kg'],
                ['Khoya', 900, 'kg'],
                ['Milk Cream', 700, 'kg'],
                ['Chocolate Milk', 260, 'liter'],
                ['Strawberry Milk', 260, 'liter'],
                ['Vanilla Milk', 250, 'liter'],
                ['Free Range Eggs', 430, 'dozen'],
                ['Desi Chicken Eggs', 410, 'dozen'],
                ['Fresh Ricotta', 980, 'kg'],
            ],
            'Baked Goods' => [
                ['Sourdough Loaf', 280, 'loaf'],
                ['Whole Wheat Bread', 220, 'loaf'],
                ['Milk Bread', 200, 'loaf'],
                ['Multigrain Bread', 300, 'loaf'],
                ['Butter Croissant', 260, 'piece'],
                ['Chocolate Croissant', 320, 'piece'],
                ['Cinnamon Roll', 240, 'piece'],
                ['Dinner Rolls', 180, 'pack'],
                ['Burger Buns', 190, 'pack'],
                ['Hot Dog Buns', 200, 'pack'],
                ['Classic Muffin', 160, 'piece'],
                ['Blueberry Muffin', 220, 'piece'],
                ['Chocolate Muffin', 210, 'piece'],
                ['Vanilla Cupcake', 180, 'piece'],
                ['Chocolate Cupcake', 220, 'piece'],
                ['Fudge Brownie', 260, 'piece'],
                ['Walnut Brownie', 290, 'piece'],
                ['Oat Cookies', 260, 'box'],
                ['Chocolate Chip Cookies', 300, 'box'],
                ['Coconut Cookies', 280, 'box'],
                ['Fruit Cake', 650, 'kg'],
                ['Classic Pound Cake', 580, 'kg'],
                ['Carrot Cake', 720, 'kg'],
                ['Garlic Bread', 260, 'loaf'],
                ['Sesame Naan', 100, 'piece'],
            ],
            'Herbs' => [
                ['Fresh Coriander', 60, 'bunch'],
                ['Fresh Mint', 70, 'bunch'],
                ['Fresh Basil', 120, 'bunch'],
                ['Rosemary', 150, 'bunch'],
                ['Fresh Thyme', 140, 'bunch'],
                ['Fresh Parsley', 110, 'bunch'],
                ['Fresh Dill', 100, 'bunch'],
                ['Fresh Chives', 130, 'bunch'],
                ['Fresh Oregano', 140, 'bunch'],
                ['Fresh Sage', 150, 'bunch'],
                ['Fresh Tarragon', 160, 'bunch'],
                ['Fresh Methi Leaves', 80, 'bunch'],
                ['Fresh Curry Leaves', 90, 'bunch'],
                ['Fresh Lemongrass', 130, 'bunch'],
                ['Green Onion Bunch', 90, 'bunch'],
                ['Fresh Arugula', 150, 'bunch'],
                ['Fresh Rocket Leaves', 160, 'bunch'],
                ['Celery Leaves', 120, 'bunch'],
                ['Fresh Bay Leaves', 110, 'bunch'],
                ['Microgreens Mix', 320, 'box'],
                ['Fresh Fennel Leaves', 120, 'bunch'],
                ['Fresh Sorrel', 150, 'bunch'],
                ['Fresh Stevia Leaves', 160, 'bunch'],
                ['Fresh Green Garlic', 180, 'bunch'],
                ['Fresh Lemon Basil', 170, 'bunch'],
            ],
            'Organic Pantry' => [
                ['Brown Rice', 380, 'kg'],
                ['Premium Basmati Rice', 520, 'kg'],
                ['Red Masoor Dal', 360, 'kg'],
                ['Moong Dal', 390, 'kg'],
                ['Chana Dal', 330, 'kg'],
                ['Organic Chickpeas', 360, 'kg'],
                ['Black Chickpeas', 390, 'kg'],
                ['Red Kidney Beans', 480, 'kg'],
                ['Black Beans', 520, 'kg'],
                ['Organic Quinoa', 980, 'kg'],
                ['Rolled Oats', 520, 'kg'],
                ['Whole Wheat Flour', 220, 'kg'],
                ['Gram Flour', 260, 'kg'],
                ['Corn Flour', 240, 'kg'],
                ['Pearl Barley', 300, 'kg'],
                ['Organic Millet', 340, 'kg'],
                ['Flax Seeds', 650, 'kg'],
                ['Chia Seeds', 1250, 'kg'],
                ['Sunflower Seeds', 780, 'kg'],
                ['Pumpkin Seeds', 1100, 'kg'],
                ['Raw Almonds', 2200, 'kg'],
                ['Cashew Nuts', 2600, 'kg'],
                ['Walnuts', 2400, 'kg'],
                ['Raw Honey', 1350, 'kg'],
                ['Medjool Dates', 1250, 'kg'],
            ],
        ];

        foreach ($catalog as $categoryName => $items) {
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );

            foreach ($items as $index => [$name, $price, $unit]) {
                $product = Product::firstOrNew([
                    'farmer_id' => $farmer->id,
                    'category_id' => $category->id,
                    'name' => $name,
                ]);

                if (!$product->exists) {
                    $product->slug = Str::slug($name . '-' . $categoryName . '-' . ($index + 1));
                }

                $product->market_id = $markets[$index % count($markets)]->id;
                $product->description = "Fresh {$categoryName} stock from Green Valley Organics, prepared for local market pickup.";
                $product->price = $price;
                $product->unit = $unit;
                $product->stock_quantity = 18 + (($index * 7) % 58);
                $product->is_available = true;
                $product->image = $this->imageUrl($name, $categoryName, $index);
                $product->save();
            }
        }

        $this->command?->info('MarketLink catalog ready: 25 demo products in each of 6 categories (150 products total).');
        $this->command?->info('Product images use category-specific public photo URLs; uploaded local images continue to work normally.');
    }

    private function imageUrl(string $name, string $category, int $index): string
    {
        $photos = [
            'Vegetables' => [
                'https://upload.wikimedia.org/wikipedia/commons/4/4a/Fresh_vegetables_in_Pakistan.jpg',
                'https://images.unsplash.com/photo-1774173822458-2a45e722ae5f?auto=format&fit=crop&w=1000&q=82',
            ],
            'Fruits' => [
                'https://images.unsplash.com/photo-1772984613890-e3bfbca7f245?auto=format&fit=crop&w=1000&q=82',
                'https://images.unsplash.com/photo-1764543603830-0eb9fb26ed35?auto=format&fit=crop&w=1000&q=82',
            ],
            'Dairy' => [
                'https://images.unsplash.com/photo-1643114453626-97ae781657b6?auto=format&fit=crop&w=1000&q=82',
                'https://images.unsplash.com/photo-1552767057-0316d96a96c4?auto=format&fit=crop&w=1000&q=82',
            ],
            'Baked Goods' => [
                'https://images.unsplash.com/photo-1567995512752-015cd3edb4e8?auto=format&fit=crop&w=1000&q=82',
                'https://images.unsplash.com/photo-1546309919-de939db3b32f?fm=jpg&q=82&w=1000',
            ],
            'Herbs' => [
                'https://images.unsplash.com/photo-1744659747310-39564f92c25b?auto=format&fit=crop&w=1000&q=82',
                'https://images.unsplash.com/photo-1773869910064-b3bf8f0f0d97?auto=format&fit=crop&w=1000&q=82',
            ],
            'Organic Pantry' => [
                'https://images.unsplash.com/photo-1633151057773-f3ef85aa6d6d?auto=format&fit=crop&w=1000&q=82',
                'https://upload.wikimedia.org/wikipedia/commons/2/2f/MyPlate_gov_Cultural_Food_%2820241025-USDA-FNS-UNK-0065%29.jpg',
            ],
        ];

        $choices = $photos[$category] ?? [];
        return $choices ? $choices[$index % count($choices)] : '';
    }
}
