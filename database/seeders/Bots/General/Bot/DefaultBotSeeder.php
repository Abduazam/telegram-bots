<?php

namespace Database\Seeders\Bots\General\Bot;

use App\Models\Bots\General\Bots\Bot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultBotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bots = [
            [
                'name' => "Taskable",
                'username' => "taskablebot",
                'token' => "6439359275:AAE-5Lf_JlYFGVNdGn1PsTHPbpUxbIjNhHU",
            ],
        ];

        foreach ($bots as $bot) {
            Bot::create([
                'name' => $bot['name'],
                'username' => $bot['username'],
                'token' => $bot['token'],
            ]);
        }
    }
}
