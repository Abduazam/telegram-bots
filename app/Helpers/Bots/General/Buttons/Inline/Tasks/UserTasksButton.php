<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Tasks;

use App\Models\Bots\Users\BotUser;
use App\Helpers\Bots\General\Texts\GetTextTranslations;

class UserTasksButton
{
    public function __construct(
        protected BotUser $user,
        protected array $additionalButtons,
    ) { }

    public function __invoke(): array
    {
        $tasks = $this->user->tasks->toArray();

        if (empty($tasks)) {
            $inlineKeyboard = [];

            foreach ($this->additionalButtons as $additionalButton) {
                $inlineKeyboard[] = $additionalButton;
            }

            return [
                'text' => GetTextTranslations::getTextTranslation('my-tasks-empty-text'),
                'keyboard' => $inlineKeyboard,
            ];
        }

        $index = 1;
        $textTasks = '';
        $inlineKeyboard = [];

        foreach (array_chunk($tasks, 4) as $taskGroup) {
            $inlineButtons = [];

            foreach ($taskGroup as $task) {
                $taskDescription = base64_decode($task['description']);
                if (! is_null($task['deleted_at'])) {
                    $textTasks .= "{$index}. $taskDescription ❌\n";
                } else {
                    $textTasks .= "{$index}. $taskDescription\n";
                }

                $inlineButtons[] = [
                    'text' => $index,
                    'callback_data' => $task['id'],
                ];

                $index++;
            }

            $inlineKeyboard[] = $inlineButtons;
        }

        $textTasks = "<b>" . GetTextTranslations::getTextTranslation('my-tasks-text') . "</b>\n\n". $textTasks;

        foreach ($this->additionalButtons as $additionalButton) {
            $inlineKeyboard[] = $additionalButton;
        }

        return [
            'text' => $textTasks,
            'keyboard' => $inlineKeyboard,
        ];
    }
}
