<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            IdentitySeeder::class,
            CategorySeeder::class,
            WarehouseSeeder::class,
            ReasonSeeder::class,
            RoleSeeder::class,
        ]);

        Customer::factory(20)->create();
        Supplier::factory(5)->create();
        Product::factory(100)->create();
    }
}
