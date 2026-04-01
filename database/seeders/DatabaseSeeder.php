<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingsSeeder::class,
            ServicesSeeder::class,
            TeamSeeder::class,
            BlogSeeder::class,
            PortfolioSeeder::class,
            TestimonialSeeder::class,
            StatsSeeder::class,
            FaqSeeder::class,
            PricingSeeder::class,
        ]);
    }
}
