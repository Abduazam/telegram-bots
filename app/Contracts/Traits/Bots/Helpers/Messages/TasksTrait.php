<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Models\Bots\Users\BotUser;
use App\Models\Bots\Tasks\BotUserTask;
use App\Models\Bots\Tasks\BotUserTaskLog;
use App\Models\Bots\Categories\BotCategory;
use App\Models\Bots\Categories\BotUserCategory;
use App\Helpers\Bots\General\Buttons\BackButton;
use App\Helpers\Bots\General\Buttons\DenyButton;
use App\Helpers\Bots\General\Buttons\CancelButton;
use App\Helpers\Bots\General\Buttons\ConfirmButton;
use App\Helpers\Bots\General\Buttons\NextStepButton;
use App\Helpers\Bots\General\Texts\GetTextTranslations;
use App\Contracts\Enums\Bots\General\BotCategoriesTypeEnum;
use App\Helpers\Bots\General\Buttons\UserAddCategoryButton;
use App\Helpers\Bots\General\Buttons\Categories\UserCategoriesButton;
use App\Services\Bots\Models\Tasks\BotUserTaskLogs\BotUserTaskLogCreateService;

trait TasksTrait
{
    public static function addTasksMessage(int $chat_id, ?BotUser $user = null): array
    {
        $additionalButtons = [
            [
                (new BackButton())(),
                (new UserAddCategoryButton())(),
            ],
        ];

        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('user-choose-category-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => (new UserCategoriesButton($additionalButtons, $user))()
            ])
        ];
    }

    public static function addTaskToCategory(int $chat_id, string $category_callback, BotUser $user): array
    {
        $data = explode('_', $category_callback);
        if (count($data) === 3) {
            $category = BotUserCategory::where('id', $data[2])->first();
            $class = BotCategoriesTypeEnum::BOT_USER_CATEGORY;
            $category_name = $category->getTranslation();
        } else {
            $category = BotCategory::where('id', $data[1])->first();
            $class = BotCategoriesTypeEnum::BOT_CATEGORY;
            $category_name = $category->translation->getTranslation();
        }

        (new BotUserTaskLogCreateService($category, $class, $user))();

        return [
            'chat_id' => $chat_id,
            'text' => "{$category_name} " . GetTextTranslations::getTextTranslation('add-task-to-category-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        (new BackButton())()
                    ],
                ],
            ])
        ];
    }

    public static function addTasksAmount(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('add-tasks-amount-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        (new CancelButton())()
                    ],
                ],
            ])
        ];
    }

    public static function addTasksSchedule(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('add-tasks-schedule-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        (new CancelButton())(),
                        (new NextStepButton())(),
                    ],
                ],
            ])
        ];
    }

    public static function addTasksFiles(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('add-tasks-files-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        (new CancelButton())(),
                        (new NextStepButton())(),
                    ],
                ],
            ])
        ];
    }

    public static function getTask(int $chat_id, BotUser $user, ?int $task_id = null): array
    {
        if (!isset($task_id)) {
            $log = BotUserTaskLog::where('bot_user_id', $user->id)->first();
            $task = BotUserTask::where('id', $log->bot_user_task_id)->where('bot_user_id', $user->id)->first();

            if ($task->category) {
                $category = $task->category->translation->getTranslation();
            } else {
                $category = $task->user_category->getTranslation();
            }
        }

        $text = "<b>Вирд:</b> {$task->getDescription()}\n<b>Категория:</b> {$category}\n<b>Кунлик қиймати:</b> {$task->amount}\n<b>Эслатиш вақти:</b> {$task->getScheduleTime()}\n<b>Файллар:</b> {$task->files()->count()}";

        return [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
               'inline_keyboard' => [
                   [
                       (new DenyButton())(),
                       (new ConfirmButton())(),
                   ],
               ],
            ])
        ];
    }

    public static function taskDenied(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('denied-text'),
            'parse_mode' => 'html',
        ];
    }

    public static function taskConfirmed(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('confirmed-text'),
            'parse_mode' => 'html',
        ];
    }

    public static function myTasksMessage(BotUser $user): array
    {
        return [
            'chat_id' => $user->chat_id,
            'text' => "Ҳозирда бу бўлим ишламаяпти",
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        (new BackButton())()
                    ],
                ],
            ])
        ];
    }
}
