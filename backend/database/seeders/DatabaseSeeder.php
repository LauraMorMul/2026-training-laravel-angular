<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $restaurants = app(RestaurantSeeder::class)->run();
        $families = app(FamilySeeder::class)->run($restaurants);
        $users = app(UserSeeder::class)->run($restaurants);
        $taxes = app(TaxSeeder::class)->run($restaurants);
        $zones = app(ZoneSeeder::class)->run($restaurants);
        $tables = app(TableSeeder::class)->run($restaurants, $zones);
        $orders = app(OrderSeeder::class)->run($restaurants, $tables, $users, $users);
        $products = app(ProductSeeder::class)->run($restaurants, $families, $taxes);
        $orderLines = app(OrderLineSeeder::class)->run($restaurants, $orders, $products, $users);
        $sales = app(SaleSeeder::class)->run($restaurants, $orders, $users);
        $saleLines = app(SaleLineSeeder::class)->run($restaurants, $sales, $orderLines, $users);
    }
}
