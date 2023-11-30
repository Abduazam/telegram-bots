<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Models\Bots\General\Users\BotUser;
use App\Models\Bots\Taskable\Tasks\TaskableTask;
use App\Services\Bots\Taskable\Logs\TaskableLogCreateService;
use App\Helpers\Bots\General\Buttons\Inline\Actions\DenyButton;
use App\Helpers\Bots\General\Buttons\Inline\Actions\BackButton;
use App\Helpers\Bots\General\Buttons\Inline\Actions\ChangeButton;
use App\Helpers\Bots\General\Buttons\Inline\Actions\ConfirmButton;
use App\Helpers\Bots\General\Buttons\Inline\Actions\NextStepButton;
use App\Helpers\Bots\General\Buttons\Inline\Tasks\ForceDeleteButton;
use App\Helpers\Bots\General\Buttons\Inline\Tasks\DeleteRestoreButton;
use App\Helpers\Bots\General\Buttons\Inline\Categories\UserCategoriesButton;
use App\Repository\Bots\Models\Taskable\Categories\TaskableCategoryRepository;

trait TasksTrait
{
    public static function addTaskToCategoryMessage(BotUser $user, string $category_id): array
    {
        $repository = new TaskableCategoryRepository();
        $category = $repository->find($category_id);

        (new TaskableLogCreateService($user, $category->id))->createByCategoryId();

        return [
            'chat_id' => $user->chat_id,
            'text' => "{$category->getTitle()} " . __('taskable.sections.add-task.adding-task.description'),
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
            'text' => __('taskable.sections.add-task.adding-task.amount'),
            'parse_mode' => 'html',
        ];
    }

    public static function addTaskScheduleMessage(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => __('taskable.sections.add-task.adding-task.schedule'),
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
        $text = self::getTaskInfo($user->taskable_log->task);

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

    public static function getActiveTask(int $chat_id, int $id): array
    {
        $task = TaskableTask::where('id', $id)->withTrashed()->first();
        $text = self::getTaskInfo($task);

        return [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        (new ChangeButton())(),
                        (new DeleteRestoreButton())($task),
                    ],
                    [
                        (new ForceDeleteButton())(),
                        (new BackButton())(),
                    ],
                ],
            ])
        ];
    }

    public static function taskConfirmed(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => __('telegram.request.confirm-text'),
            'parse_mode' => 'html',
        ];
    }

    public static function taskDenied(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => __('telegram.request.deny-text'),
            'parse_mode' => 'html',
        ];
    }

    public static function taskSaved(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => __('taskable.main.general.saved'),
            'parse_mode' => 'html',
        ];
    }

    public static function getTaskChangeMessage(BotUser $user): array
    {
        $text = self::getTaskInfo($user->taskable_log->task);

        return [
            'chat_id' => $user->chat_id,
            'text' => __('taskable.sections.add-task.changing-task.text') . "\n\n$text",
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => __('taskable.items.task.description'), 'callback_data' => 'description'],
                        ['text' => __('taskable.items.task.category'), 'callback_data' => 'category'],
                    ],
                    [
                        ['text' => __('taskable.items.task.amount'), 'callback_data' => 'amount'],
                        ['text' => __('taskable.items.task.schedule'), 'callback_data' => 'schedule_time'],
                    ],
                    [
                        (new BackButton())()
                    ]
                ],
            ])
        ];
    }

    private static function getTaskInfo(TaskableTask $task): string
    {
        return "<b>" . __('taskable.items.task.description') . ":</b> {$task->getDescription()}\n<b>" . __('taskable.items.task.category') . ":</b> {$task->category->getTitle()}\n<b>" . __('taskable.items.task.amount') . ":</b> {$task->amount}\n<b>" . __('taskable.items.task.schedule') . ":</b> {$task->getScheduleTime()}";
    }

    public static function changeTaskDescription(BotUser $user): array
    {
        return [
            'chat_id' => $user->chat_id,
            'text' => __('taskable.sections.add-task.changing-task.description'),
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
            'text' => __('taskable.sections.add-task.changing-task.amount'),
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
            'text' => __('taskable.sections.add-task.changing-task.schedule'),
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
            'text' => __('taskable.sections.add-task.changing-task.category'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => (new UserCategoriesButton($user, $additionalButtons))()
            ])
        ];
    }

    public static function getTaskNotificationInfo(TaskableTask $task, bool $category = true): string
    {
        $message = "<b>{$task->getDescription()}\n</b><b>" . __('taskable.sections.add-task.notifying-task.must-do') . ":</b> {$task->amount}";

        if ($category) {
            $message = "<b>{$task->category->getTitle()}</b> " . __('taskable.sections.add-task.notifying-task.time-of') . "\n\n" . $message;
        }

        return $message;
    }

    public static function confirmDeletingTask(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => __('telegram.request.force-delete-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        (new DenyButton())(),
                        (new ConfirmButton())(),
                    ],
                    [
                        (new BackButton())()
                    ],
                ],
            ])
        ];
    }

    public static function taskCompleteMessage(BotUser $user, int $task_id): array
    {
        $task = TaskableTask::findOrFail($task_id);

        return [
            'chat_id' => $user->chat_id,
            'text' => self::getTaskNotificationInfo($task, false) . "\n\n" . __('taskable.sections.task-done.done-count'),
            'parse_mode' => 'html',
        ];
    }

    public static function taskCountSaved(BotUser $user, int $done_amount): array
    {
        $emojis = [
            'equal' => ["🥳", "🤩", "⚡️", "😎", "🥇"],
            'less' => ["🤗", "🤓", "👏🏻", "🌞"],
            'greater' => ["🤯", "💥", "🔥", "🏆"]
        ];

        $taskAmount = $user->taskable_log->task->amount;

        if ($done_amount === $taskAmount) {
            $emoji = $emojis['equal'][array_rand($emojis['equal'])];
        } elseif ($done_amount < $taskAmount) {
            $emoji = $emojis['less'][array_rand($emojis['less'])];
        } else {
            $emoji = $emojis['greater'][array_rand($emojis['greater'])];
        }

        return [
            'chat_id' => $user->chat_id,
            'text' => $emoji,
            'parse_mode' => 'html',
        ];
    }
}
