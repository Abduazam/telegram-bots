<?php

namespace App\Listeners\Bots\Anonimyoz\Chat;

use App\Events\Bots\Anonimyoz\Chat\UpdateReceiverIdToNull;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateReceiverIdToNullListener
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
    public function handle(UpdateReceiverIdToNull $event): void
    {
        $event->user->chat->update([
            'receiver_id' => null,
        ]);
    }
}
