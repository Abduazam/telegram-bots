<?php

namespace App\Helpers\Bots\Taskable\Buttons\Inline\Actions;

class TaskDoneButton
{
    public function __construct(protected int $task_id) { }

    public function __invoke(): array
    {
        return ['text' => __('taskable.main.buttons.task-done'), 'callback_data' => 'task-done-button@' . $this->task_id];
    }
}
