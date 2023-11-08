<?php

namespace App\Http\Controllers\Bots;

use App\Http\Controllers\Controller;
use App\Models\Bots\General\Bots\Bot;
use App\Models\Bots\Telegram\Telegram;
use App\Models\Bots\General\Users\BotUser;

class BotsController extends Controller
{
    protected Telegram $telegram;
    protected BotUser $user;
    protected Bot $bot;
    protected ?string $text;
    protected int $message_id;
    protected string|bool $message_type;
    protected int $step_one;
    protected int $step_two;

    protected function __construct()
    {
        if (app()->runningInConsole()) {
            return;
        }
    }
}
