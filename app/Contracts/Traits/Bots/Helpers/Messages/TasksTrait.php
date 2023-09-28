<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Models\Bots\Users\BotUser;
use App\Models\Bots\Tasks\BotUserTaskLog;
use App\Models\Bots\Categories\BotCategory;
use App\Models\Bots\Categories\BotUserCategory;
use App\Helpers\Bots\General\Texts\GetTextTranslations;
use App\Helpers\Bots\General\Buttons\Actions\BackButton;
use App\Helpers\Bots\General\Buttons\Actions\DenyButton;
use App\Helpers\Bots\General\Buttons\Actions\CancelButton;
use App\Helpers\Bots\General\Buttons\Actions\ConfirmButton;
use App\Contracts\Enums\Bots\General\BotCategoriesTypeEnum;
use App\Helpers\Bots\General\Buttons\Actions\NextStepButton;
use App\Helpers\Bots\General\Buttons\Categories\UserCategoriesButton;
use App\Helpers\Bots\General\Buttons\Categories\UserAddCategoryButton;
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

    public static function getTask(BotUser $user, ?int $task_id = null): array
    {
        if (is_null($task_id)) {
            $log = BotUserTaskLog::with(['task' => function ($query) {
                $query->with(['category.translation', 'user_category'])->first();
            }])->where('bot_user_id', $user->id)->first();


            if ($log->task->category) {
                $category = $log->task->category->translation->getTranslation();
            } else {
                $category = $log->task->user_category->getTranslation();
            }
        }

        $text = "<b>Вирд:</b> {$log->task->getDescription()}\n<b>Категория:</b> {$category}\n<b>Кунлик қиймати:</b> {$log->task->amount}\n<b>Эслатиш вақти:</b> {$log->task->getScheduleTime()}\n<b>Файллар:</b> {$log->task->files()->count()}";

        return [
            'chat_id' => $user->chat_id,
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
