<?php

namespace App\Repository\Bots\Models\General;

use App\Models\Bots\General\Bots\Bot;
use Illuminate\Database\Eloquent\Collection;

class BotRepository
{
    public function findByToken(string $bot_token): Bot
    {
        return Bot::where('token', $bot_token)->first();
    }

    public function getAll(): Collection
    {
        return Bot::all();
    }
}
