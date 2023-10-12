<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Models\Bots\Users\BotUser;
use App\Models\Bots\Tasks\BotUserTask;
use App\Models\Bots\Categories\BotCategory;
use App\Helpers\Bots\General\Texts\GetTextTranslations;
use App\Helpers\Bots\General\Buttons\Inline\Actions\DenyButton;
use App\Helpers\Bots\General\Buttons\Inline\Actions\BackButton;
use App\Helpers\Bots\General\Buttons\Inline\Actions\ChangeButton;
use App\Services\Bots\Models\BotUserLogs\BotUserLogCreateService;
use App\Helpers\Bots\General\Buttons\Inline\Actions\ConfirmButton;
use App\Helpers\Bots\General\Buttons\Inline\Actions\NextStepButton;
use App\Helpers\Bots\General\Buttons\Inline\Categories\UserCategoriesButton;

trait TasksTrait
{
    public static function addTaskToCategoryMessage(BotUser $user, string $category_id): array
    {
        $category = BotCategory::find($category_id);

        (new BotUserLogCreateService($user, $category->id))();

        return [
            'chat_id' => $user->chat_id,
            'text' => "{$category->getTitle()} " . GetTextTranslations::getTextTranslation('add-task-to-category-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        (new BackButton())(),
                    ],
                ]
            ])
        ];
    }

    public static function addTaskAmountMessage(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('add-task-amount-text'),
            'parse_mode' => 'html',
        ];
    }

    public static function addTaskScheduleMessage(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('add-task-schedule-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        (new NextStepButton())(),
                    ],
                ]
            ])
        ];
    }

    public static function getTask(BotUser $user): array
    {
        $text = self::getTaskInfo($user->log->task);

        return [
            'chat_id' => $user->chat_id,
            'text' => $text,
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        (new ChangeButton())(),
                    ],
                    [
                        (new DenyButton())(),
                        (new ConfirmButton())(),
                    ],
                ],
            ])
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

    public static function taskDenied(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('denied-text'),
            'parse_mode' => 'html',
        ];
    }

    public static function taskSaved(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('saved-but-not-active-text'),
            'parse_mode' => 'html',
        ];
    }

    public static function getTaskChangeMessage(BotUser $user): array
    {
        $text = self::getTaskInfo($user->log->task);

        return [
            'chat_id' => $user->chat_id,
            'text' => "Ўзгартирмоқчи бўлган нарсангизни танланг\n\n$text",
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => 'Вирд номи', 'callback_data' => 'description'],
                        ['text' => 'Категорияси', 'callback_data' => 'category'],
                    ],
                    [
                        ['text' => 'Қиймати', 'callback_data' => 'amount'],
                        ['text' => 'Эслатиш вақти', 'callback_data' => 'schedule_time'],
                    ],
                    [
                        (new BackButton())()
                    ]
                ],
            ])
        ];
    }

    private static function getTaskInfo(BotUserTask $task): string
    {
        return "<b>Вирд:</b> {$task->getDescription()}\n<b>Категория:</b> {$task->category->getTitle()}\n<b>Кунлик қиймати:</b> {$task->amount}\n<b>Эслатиш вақти:</b> {$task->getScheduleTime()}";
    }

    public static function changeTaskDescription(BotUser $user): array
    {
        return [
            'chat_id' => $user->chat_id,
            'text' => GetTextTranslations::getTextTranslation('change-task-description-text'),
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

    public static function changeTaskAmount(BotUser $user): array
    {
        return [
            'chat_id' => $user->chat_id,
            'text' => GetTextTranslations::getTextTranslation('change-task-amount-text'),
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

    public static function changeTaskSchedule(BotUser $user): array
    {
        return [
            'chat_id' => $user->chat_id,
            'text' => GetTextTranslations::getTextTranslation('change-task-schedule-text'),
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

    public static function changeTaskCategory(BotUser $user): array
    {
        $additionalButtons = [
            [
                (new BackButton())(),
            ],
        ];

        return [
            'chat_id' => $user->chat_id,
            'text' => GetTextTranslations::getTextTranslation('change-task-category-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => (new UserCategoriesButton($user, $additionalButtons))()
            ])
        ];
    }

    public static function getTaskNotificationInfo(BotUserTask $task): string
    {
        return "<b>{$task->category->getTitle()}</b> вақти\n\n<b>{$task->getDescription()}\n</b><b>Бажаришингиз керак:</b> {$task->amount}";
    }
}
