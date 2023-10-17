<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Tasks;

use App\Models\Bots\Tasks\BotUserTask;
use App\Helpers\Bots\General\Texts\GetTextTranslations;

class DeleteRestoreButton
{
    public function __invoke(BotUserTask $task): array
    {
        if ($task->trashed()) {
            return ['text' => GetTextTranslations::getTextTranslation('restore-button'), 'callback_data' => 'restore-button'];
        }

        return ['text' => GetTextTranslations::getTextTranslation('delete-button'), 'callback_data' => 'delete-button'];
    }
}
