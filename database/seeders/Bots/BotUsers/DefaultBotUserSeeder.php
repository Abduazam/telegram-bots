<?php

namespace Database\Seeders\Bots\BotUsers;

use App\Events\Bots\BotUsers\BotUserCreated;
use App\Models\Bots\Users\BotUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultBotUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = BotUser::create([
            'chat_id' => 6618672397,
            'first_name' => 'QWJkdWF6YW0=',
            'username' => 'YWJkdWF6YW1kZXY=',
            'phone_number' => '+998900016234',
            'active' => true,
        ]);

        $user2 = BotUser::create([
            'chat_id' => 6482619203,
            'first_name' => '0JDQsdC00YPQsNC30LDQvA==',
            'phone_number' => '+998970006234',
            'active' => true,
        ]);

        event(new BotUserCreated($user));
        event(new BotUserCreated($user2));
    }
}
