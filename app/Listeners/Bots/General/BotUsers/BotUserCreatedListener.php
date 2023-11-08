<?php

namespace App\Listeners\Bots\General\BotUsers;

use App\Events\Bots\General\BotUsers\BotUserCreated;
use App\Models\Bots\General\Users\BotUserStep;

class BotUserCreatedListener
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
    public function handle(BotUserCreated $event): void
    {
        BotUserStep::create([
            'bot_user_id' => $event->user->id,
            'step_one' => 0,
            'step_two' => 0,
        ]);
    }
}
