<?php

namespace App\Listeners\Bots\BotUserLog;

use App\Events\Bots\BotUserLog\UpdateBotUserLogToNull;

class UpdateBotUserLogToNullListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateBotUserLogToNull $event): void
    {
        $event->user->log->update([
            'bot_category_id' => null,
            'bot_user_task_id' => null,
        ]);
    }
}
