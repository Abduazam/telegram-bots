<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // DASHBOARD
            Dashboard\Users\AdminSeeder::class,

            // BOTS
            Bots\General\Bot\DefaultBotSeeder::class,
            Bots\General\AvailableCountries\DefaultAvailableCountrySeeder::class,
            Bots\Taskable\DefaultCategoriesSeeder::class,
        ]);
    }
}
