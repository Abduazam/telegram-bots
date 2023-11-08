<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Tasks;

use App\Models\Bots\Taskable\Tasks\TaskableTask;

class DeleteRestoreButton
{
    public function __invoke(TaskableTask $task): array
    {
        if ($task->trashed()) {
            return ['text' => __('telegram.crud.restore'), 'callback_data' => 'restore-button'];
        }

        return ['text' => __('telegram.crud.delete'), 'callback_data' => 'delete-button'];
    }
}
