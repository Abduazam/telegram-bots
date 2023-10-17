<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Tasks;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class UserAddTaskButton
{
    public function __invoke(): array
    {
        return ['text' => GetTextTranslations::getTextTranslation('add-tasks-button'), 'callback_data' => 'add-tasks-button'];
    }
}
