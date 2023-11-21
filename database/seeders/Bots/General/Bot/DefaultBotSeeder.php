<?php

namespace Database\Seeders\Bots\General\Bot;

use Illuminate\Database\Seeder;
use App\Models\Bots\General\Bots\Bot;

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
                'token' => config('telegram.bots.taskable.token'),
            ],
            [
                'name' => "Anonimyoz",
                'username' => "anonimyozbot",
                'token' => config('telegram.bots.anonimyoz.token'),
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
