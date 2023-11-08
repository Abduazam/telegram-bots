<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Tasks;

class UserAddTaskButton
{
    public function __invoke(): array
    {
        return ['text' => __('taskable.sections.add-task.text'), 'callback_data' => 'add-task'];
    }
}
