<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\Bots\BotUserTasks\BotUserTaskFactory;
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
            Bots\BotUsers\DefaultBotUserSeeder::class,
            Bots\PhoneNumberCodes\DefaultCountryPhoneNumberCodesSeeder::class,
            Bots\BotTexts\DefaultBotTextsSeeder::class,
            Bots\Categories\DefaultBotCategoriesSeeder::class,
        ]);

        BotUserTaskFactory::times(50)->create();
    }
}
