<?php

namespace App\Listeners\Bots\Taskable\Logs;

use App\Events\Bots\Taskable\Logs\UpdateTaskableLogToNull;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateTaskableLogToNullListener
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
    public function handle(UpdateTaskableLogToNull $event): void
    {
        $event->user->taskable_log->update([
            'taskable_category_id' => null,
            'taskable_task_id' => null,
            'section_name' => null,
        ]);
    }
}
