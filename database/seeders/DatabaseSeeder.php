<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create 8 Users (System Accounts: 8)
        $superAdmin = \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'super@caterflow.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'super_admin',
            'phone' => '+44 20 7946 0000',
            'address' => 'HQ Unified Matrix',
        ]);

        $chefAdmin = \App\Models\User::create([
            'name' => 'Chef Alex Admin',
            'email' => 'admin@caterflow.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
            'phone' => '+44 20 7946 0111',
            'address' => 'Bella Italia Kitchen',
        ]);

        $partnerAdmin = \App\Models\User::create([
            'name' => 'Partner Admin',
            'email' => 'partner@caterflow.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
            'phone' => '+44 20 7946 0222',
            'address' => 'The Royal Feast Kitchen',
        ]);

        $customersData = [
            ['Jane Customer', 'jane@caterflow.com', 'Table 4', 'Vegetarian, Gluten-Free'],
            ['Bob Smith', 'bob@caterflow.com', 'Table 1', 'Halal'],
            ['Alice Johnson', 'alice@caterflow.com', 'Suite 10', 'Vegan'],
            ['Charlie Brown', 'charlie@caterflow.com', 'Table 3', 'Nut-Free'],
            ['Diana Prince', 'diana@caterflow.com', 'VIP Deck', 'Dairy-Free'],
        ];

        foreach ($customersData as $index => $data) {
            \App\Models\User::create([
                'name' => $data[0],
                'email' => $data[1],
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'customer',
                'phone' => '+44 20 7946 030' . $index,
                'address' => $data[2],
                'dietary_preferences' => $data[3],
            ]);
        }

        // 2. Create Categories
        $starters = \App\Models\Category::create(['name' => 'Appetizers & Starters']);
        $entrees = \App\Models\Category::create(['name' => 'Main Courses']);
        $desserts = \App\Models\Category::create(['name' => 'Signature Desserts']);
        $drinks = \App\Models\Category::create(['name' => 'Craft Beverages']);

        // 3. Create Menu Items
        $bruschetta = \App\Models\MenuItem::create([
            'category_id' => $starters->id,
            'name' => 'Truffle Bruschetta',
            'description' => 'Grilled sourdough, truffle oil, tomatoes, basil.',
            'price' => 14.50,
            'tags' => 'Vegetarian',
            'is_available' => true,
        ]);

        $crabCakes = \App\Models\MenuItem::create([
            'category_id' => $starters->id,
            'name' => 'Spiced Crab Cakes',
            'description' => 'Blue crab, cajun spices, lemon-herb aioli.',
            'price' => 18.00,
            'tags' => 'Halal',
            'is_available' => true,
        ]);

        $steak = \App\Models\MenuItem::create([
            'category_id' => $entrees->id,
            'name' => 'Rosemary Ribeye Steak',
            'description' => 'Prime aged ribeye, rosemary butter, garlic mash.',
            'price' => 42.00,
            'tags' => 'Halal, Gluten-Free',
            'is_available' => true,
        ]);

        // 4. Seed Completed Orders totaling exactly £192.00 (Total Catering Sales: 192.00)
        // Order 1: £100.00
        $order1 = \App\Models\Order::create([
            'user_id' => 4, // Jane Customer
            'customer_name' => 'Jane Customer',
            'contact_info' => '+44 20 7946 0777',
            'table_number_or_delivery' => 'Table 4',
            'total_price' => 100.00,
            'status' => 'completed',
            'notes' => 'Completed Feast Order 1',
        ]);
        \App\Models\OrderItem::create([
            'order_id' => $order1->id,
            'menu_item_id' => $steak->id,
            'quantity' => 2,
            'price' => 42.00,
        ]);
        \App\Models\OrderItem::create([
            'order_id' => $order1->id,
            'menu_item_id' => $bruschetta->id,
            'quantity' => 1,
            'price' => 14.50,
        ]);
        // Order 2: £92.00
        $order2 = \App\Models\Order::create([
            'user_id' => 5, // Bob
            'customer_name' => 'Bob Smith',
            'contact_info' => '+44 20 7946 0888',
            'table_number_or_delivery' => 'Table 1',
            'total_price' => 92.00,
            'status' => 'completed',
            'notes' => 'Completed Feast Order 2',
        ]);
        \App\Models\OrderItem::create([
            'order_id' => $order2->id,
            'menu_item_id' => $steak->id,
            'quantity' => 2,
            'price' => 42.00,
        ]);
        \App\Models\OrderItem::create([
            'order_id' => $order2->id,
            'menu_item_id' => $bruschetta->id,
            'quantity' => 1,
            'price' => 8.00,
        ]);

        // 5. Seed 1 Active Pending Order (Active Orders Pending: 1)
        $order3 = \App\Models\Order::create([
            'user_id' => 6, // Alice
            'customer_name' => 'Alice Johnson',
            'contact_info' => '+44 20 7946 0999',
            'table_number_or_delivery' => 'Suite 10',
            'total_price' => 18.00,
            'status' => 'pending',
            'notes' => 'Active pending order',
        ]);
        \App\Models\OrderItem::create([
            'order_id' => $order3->id,
            'menu_item_id' => $crabCakes->id,
            'quantity' => 1,
            'price' => 18.00,
        ]);

        // 6. Create 3 Restaurants (matching the screenshot exactly)
        \App\Models\Restaurant::create([
            'name' => 'The Royal Feast',
            'phone' => '+44 20 7946 0192',
            'description' => 'Exquisite traditional catering and grand feast menus.',
            'address' => '101 Palace Row, London',
            'icon' => '👑',
            'staff_count' => 2,
            'dishes_count' => 3,
            'orders_count' => 1,
        ]);

        \App\Models\Restaurant::create([
            'name' => 'Bella Italia',
            'phone' => '+44 20 7946 0541',
            'description' => 'Authentic gourmet Italian plates, pastas, and fine dining catering.',
            'address' => '42 Romano Ave, London',
            'icon' => '🍝',
            'staff_count' => 2,
            'dishes_count' => 3,
            'orders_count' => 1,
        ]);

        \App\Models\Restaurant::create([
            'name' => 'Saffron Bites',
            'phone' => '+44 20 7946 0773',
            'description' => 'Vibrant, rich spice-infused Indian catering and regional delicacies.',
            'address' => '88 Spice Route, London',
            'icon' => '🌶️',
            'staff_count' => 2,
            'dishes_count' => 3,
            'orders_count' => 0,
        ]);

        // 7. Seed Companies
        $co1 = \App\Models\Company::create(['name' => 'AstraZeneca UK', 'industry' => 'Pharmaceuticals', 'phone' => '+44 20 7946 9901']);
        $co2 = \App\Models\Company::create(['name' => 'Pfizer Ltd', 'industry' => 'Pharmaceuticals', 'phone' => '+44 20 7946 9902']);
        $co3 = \App\Models\Company::create(['name' => 'GlaxoSmithKline', 'industry' => 'Healthcare', 'phone' => '+44 20 7946 9903']);

        // 8. Seed Contacts
        $con1 = \App\Models\Contact::create(['company_id' => $co1->id, 'name' => 'Sarah Jenkins', 'email' => 'sarah.jenkins@astrazeneca.com', 'phone' => '+44 7700 900077']);
        $con2 = \App\Models\Contact::create(['company_id' => $co2->id, 'name' => 'Michael Chang', 'email' => 'm.chang@pfizer.com', 'phone' => '+44 7700 900088']);
        $con3 = \App\Models\Contact::create(['company_id' => $co3->id, 'name' => 'Emily Watson', 'email' => 'emily.watson@gsk.com', 'phone' => '+44 7700 900099']);
        $con4 = \App\Models\Contact::create(['company_id' => null, 'name' => 'Independent Event Planner', 'email' => 'events@independent.com', 'phone' => '+44 7700 900100']);

        // 9. Seed Delivery Addresses
        \App\Models\DeliveryAddress::create(['contact_id' => $con1->id, 'street' => '100 Discovery Way', 'city' => 'Cambridge', 'postal_code' => 'CB2 0QQ', 'notes' => 'Deliver to Reception B']);
        \App\Models\DeliveryAddress::create(['contact_id' => $con2->id, 'street' => '50 Pfizer Plaza', 'city' => 'Sandwich', 'postal_code' => 'CT13 9NJ', 'notes' => 'Kitchen access via service elevator']);
        \App\Models\DeliveryAddress::create(['contact_id' => $con3->id, 'street' => '980 Great West Road', 'city' => 'Brentford', 'postal_code' => 'TW8 9GS', 'notes' => 'Conference Room 4B']);

        // 10. Seed Configuration Settings
        \App\Models\Setting::create(['key' => 'business_name', 'value' => 'Expo Catering']);
        \App\Models\Setting::create(['key' => 'tax_rate', 'value' => '12.5']);
        \App\Models\Setting::create(['key' => 'currency', 'value' => '£']);
        \App\Models\Setting::create(['key' => 'active_system', 'value' => 'CaterFlow PRO']);
    }
}
