<?php

namespace App\Http\Controllers\Bots\Taskable;

use App\Models\Bots\Telegram\Telegram;
use App\Http\Controllers\Bots\BotsController;
use App\Helpers\Bots\General\Messages\Message;
use App\Repository\Bots\Models\General\BotRepository;
use App\Repository\Bots\Models\General\BotUserRepository;
use App\Events\Bots\Taskable\Logs\UpdateTaskableLogToNull;
use App\Services\Bots\Models\BotUsers\BotUserCreateService;
use App\Services\Bots\Models\BotUsers\BotUserUpdateService;
use App\Services\Bots\Taskable\Logs\TaskableLogCreateService;
use App\Helpers\Bots\General\Rules\TaskScheduleTimeCheckRule;
use App\Services\Bots\Taskable\Tasks\TaskableTaskDeleteService;
use App\Services\Bots\Taskable\Tasks\TaskableTaskUpdateService;
use App\Services\Bots\Taskable\Tasks\TaskableTaskCreateService;
use App\Contracts\Enums\Bots\Models\BotUsers\BotUserActiveEnum;
use App\Services\Bots\General\BotUser\BotUserExistsCheckService;
use App\Services\Bots\Taskable\Tasks\TaskableTaskRestoreService;
use App\Services\Bots\Taskable\Categories\TaskableCategoryCreateService;
use App\Services\Bots\General\PhoneNumberChecker\PhoneNumberCheckService;

class TaskableController extends BotsController
{
    public function __construct(
        BotRepository $botRepository,
        BotUserRepository $botUserRepository
    ) {
        parent::__construct();

        $bot_token = config('telegram.bots.taskable.token');
        $this->bot = $botRepository->findByToken($bot_token);
        $this->telegram = new Telegram($bot_token);

        $result = (new BotUserExistsCheckService($this->bot->id, $this->telegram->ChatID()))();
        if ($result) {
            $this->user = $botUserRepository->findByBotAndChatIds($this->bot->id, $this->telegram->ChatID());
        } else {
            $service = new BotUserCreateService($this->telegram->ChatID(), $this->telegram->FirstName(), $this->telegram->Username(), $this->bot->id);
            $this->user = $service->create();
        }

        $this->text = $this->telegram->Text();
        $this->message_id = $this->telegram->MessageID();
        $this->message_type = $this->telegram->getUpdateType();

        $this->step_one = $this->user->steps->step_one;
        $this->step_two = $this->user->steps->step_two;
    }

    public function index(): void
    {
        if ($this->user->isActive()) {
            if ($this->text === '/start') {
                if ($this->step_one === 2 and ($this->step_two >= 2 and $this->step_two <= 7)) {
                    UpdateTaskableLogToNull::dispatch($this->user);
                    $this->telegram->sendMessage(Message::taskSaved($this->user->chat_id));
                }

                $this->user->updateSteps(1, 0);
                $this->telegram->sendMessage(Message::mainMenuMessage($this->user->chat_id));

                return;
            }

            /**
             * Main menu stage actions.
             */
            if ($this->step_one === 1 and $this->step_two === 0) {
                $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                if ($this->message_type === $this->telegram::CALLBACK_QUERY) {
                    if ($this->text === 'add-task') {
                        $this->user->updateSteps(2, 0);
                        $this->telegram->sendMessage(Message::addTasksSectionMessage($this->user));
                    }

                    if ($this->text === 'my-tasks') {
                        $this->user->updateSteps(3, 0);
                        $this->telegram->sendMessage(Message::myTasksSectionMessage($this->user));
                    }

                    if ($this->text === 'settings') {
                        $this->user->updateSteps(4, 0);
                        $this->telegram->sendMessage(Message::settingsSectionMessage($this->user->chat_id));
                    }
                }
            }

            /**
             * Back step.
             */
            if ($this->text === 'back-button' and $this->message_type === $this->telegram::CALLBACK_QUERY) {
                $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                if ($this->step_one === 2) {
                    if ($this->step_two === 0) {
                        $this->user->updateSteps(1, 0);
                        $this->telegram->sendMessage(Message::mainMenuMessage($this->user->chat_id));
                    }

                    if ($this->step_two === 1) {
                        $this->user->updateSteps(2, 0);
                        $this->telegram->sendMessage(Message::addTasksSectionMessage($this->user));
                    }

                    if ($this->step_two === 2) {
                        if ($this->user->taskable_log?->task?->isChanging('description')) {
                            $this->user->updateSteps(2, 6);
                            $this->telegram->sendMessage(Message::getTaskChangeMessage($this->user));
                        } else {
                            $this->user->updateSteps(2, 0);
                            $this->telegram->sendMessage(Message::addTasksSectionMessage($this->user));
                        }
                    }

                    if (($this->step_two === 3 or $this->step_two === 4) and $this->user->taskable_log?->task?->isChanging('amount')) {
                        $this->user->updateSteps(2, 6);
                        $this->telegram->sendMessage(Message::getTaskChangeMessage($this->user));
                    }

                    if ($this->step_two === 6) {
                        if ($this->user->taskable_log->task->active) {
                            $this->user->updateSteps(3, 1);
                            $this->telegram->sendMessage(Message::getActiveTask($this->user->chat_id, $this->user->taskable_log->taskable_task_id));
                        } else {
                            $this->user->updateSteps(2, 5);
                            $this->telegram->sendMessage(Message::getTask($this->user));
                        }
                    }

                    if ($this->step_two === 7) {
                        $this->user->updateSteps(2, 6);
                        $this->telegram->sendMessage(Message::getTaskChangeMessage($this->user));
                    }
                }

                if ($this->step_one === 3) {
                    if ($this->step_two === 0) {
                        $this->user->updateSteps(1, 0);
                        $this->telegram->sendMessage(Message::mainMenuMessage($this->user->chat_id));
                    }

                    if ($this->step_two === 1) {
                        $this->user->updateSteps(3, 0);
                        $this->telegram->sendMessage(Message::myTasksSectionMessage($this->user));
                    }
                }

                if ($this->step_one === 4) {
                    if ($this->step_two === 0) {
                        $this->user->updateSteps(1, 0);
                        $this->telegram->sendMessage(Message::mainMenuMessage($this->user->chat_id));
                    }

                    if ($this->step_two === 1 or $this->step_two === 2 or $this->step_two === 3) {
                        $this->user->updateSteps(4, 0);
                        $this->telegram->sendMessage(Message::settingsSectionMessage($this->user->chat_id));
                    }
                }

                return;
            }

            /**
             * Adding tasks.
             */
            if ($this->step_one === 2) {
                if ($this->step_two === 0) {
                    $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                    if ($this->message_type == $this->telegram::CALLBACK_QUERY) {
                        if ($this->text === 'add-category-button') {
                            $this->user->updateSteps(2, 1);
                            $this->telegram->sendMessage(Message::addUserCategoryMessage($this->user->chat_id));
                        }

                        if (is_numeric($this->text)) {
                            $this->user->updateSteps(2, 2);
                            $this->telegram->sendMessage(Message::addTaskToCategoryMessage($this->user, $this->text));
                        }
                    }
                }

                /**
                 * New user's category
                 */
                if ($this->step_two === 1) {
                    if (isset($this->text)) {
                        $result = (new TaskableCategoryCreateService($this->user, $this->text));
                        if ($result()) {
                            $this->user->updateSteps(2, 0);
                            $this->telegram->sendMessage(Message::addTasksSectionMessage($this->user));
                        } else {
                            $this->telegram->sendMessage(Message::somethingWentWrong($this->user->chat_id));
                        }
                    } else {
                        $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                    }
                }

                /**
                 * Task description
                 */
                if ($this->step_two === 2) {
                    if ($this->user->taskable_log?->task?->isChanging('description')) {
                        $result = (new TaskableTaskUpdateService($this->user->taskable_log->task))->updateTaskDescription($this->text);
                        if ($result) {
                            $this->user->updateSteps(2, 6);
                            $this->telegram->sendMessage(Message::getTaskChangeMessage($this->user));
                        } else {
                            $this->telegram->sendMessage(Message::somethingWentWrong($this->user->chat_id));
                        }
                    } else {
                        $result = (new TaskableTaskCreateService($this->user))->createTaskDescription($this->text);
                        if ($result) {
                            $this->user->updateSteps(2, 3);
                            $this->telegram->sendMessage(Message::addTaskAmountMessage($this->user->chat_id));
                        } else {
                            $this->telegram->sendMessage(Message::somethingWentWrong($this->user->chat_id));
                        }
                    }
                }

                /**
                 * Task amount
                 */
                if ($this->step_two === 3) {
                    if (isset($this->text) and is_numeric($this->text)) {
                        if ($this->user->taskable_log->task->isChanging('amount')) {
                            $step = 6;
                        } else {
                            $step = 4;
                        }

                        $result = (new TaskableTaskUpdateService($this->user->taskable_log->task))->updateTaskAmount($this->text);
                        if ($result) {
                            $this->user->updateSteps(2, $step);
                            $message = $step === 6 ? Message::getTaskChangeMessage($this->user) : Message::addTaskScheduleMessage($this->user->chat_id);
                            $this->telegram->sendMessage($message);
                        } else {
                            $this->telegram->sendMessage(Message::somethingWentWrong($this->user->chat_id));
                        }
                    } else {
                        $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                    }
                }

                /**
                 * Task schedule time
                 */
                if ($this->step_two === 4) {
                    if (isset($this->text) and (new TaskScheduleTimeCheckRule($this->text))()) {
                        if ($this->user->taskable_log->task->isChanging('schedule_time')) {
                            $step = 6;
                        } else {
                            $step = 5;
                        }

                        $result = (new TaskableTaskUpdateService($this->user->taskable_log->task))->updateTaskSchedule($this->text);
                        if ($result) {
                            $this->user->updateSteps(2, $step);
                            $message = $step === 6 ? Message::getTaskChangeMessage($this->user) : Message::getTask($this->user);
                            $this->telegram->sendMessage($message);
                        } else {
                            $this->telegram->sendMessage(Message::somethingWentWrong($this->user->chat_id));
                        }
                    } else if ($this->message_type === $this->telegram::CALLBACK_QUERY) {
                        $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                        $result = (new TaskableTaskUpdateService($this->user->taskable_log->task))->updateTaskSchedule('00:00:01');
                        if ($result) {
                            $this->user->updateSteps(2, 5);
                            $this->telegram->sendMessage(Message::getTask($this->user));
                        } else {
                            $this->telegram->sendMessage(Message::somethingWentWrong($this->user->chat_id));
                        }
                    } else {
                        $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                    }
                }

                /**
                 * Task to deny or confirm or change
                 */
                if ($this->step_two === 5) {
                    $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                    if ($this->message_type == $this->telegram::CALLBACK_QUERY) {
                        if ($this->text == 'change-button') {
                            $this->user->updateSteps(2, 6);
                            $this->telegram->sendMessage(Message::getTaskChangeMessage($this->user));
                        } else {
                            if ($this->text === 'deny-button') {
                                $result = (new TaskableTaskDeleteService($this->user->taskable_log->task))->forceDelete();
                                if ($result) {
                                    UpdateTaskableLogToNull::dispatch($this->user);
                                    $this->telegram->sendMessage(Message::taskDenied($this->user->chat_id));
                                } else {
                                    $this->telegram->sendMessage(Message::somethingWentWrong($this->user->chat_id));
                                }
                            }

                            if ($this->text === 'confirm-button') {
                                $result = (new TaskableTaskUpdateService($this->user->taskable_log->task))->updateTaskActive(true);
                                if ($result) {
                                    UpdateTaskableLogToNull::dispatch($this->user);
                                    $this->telegram->sendMessage(Message::taskConfirmed($this->user->chat_id));
                                } else {
                                    $this->telegram->sendMessage(Message::somethingWentWrong($this->user->chat_id));
                                }
                            }

                            $this->user->updateSteps(2, 0);
                            $this->telegram->sendMessage(Message::addTasksSectionMessage($this->user));
                        }
                    }
                }

                /**
                 * Task changing
                 */
                if ($this->step_two === 6) {
                    $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                    if ($this->message_type == $this->telegram::CALLBACK_QUERY) {
                        switch ($this->text) {
                            case 'description':
                                $this->user->updateSteps(2, 2);
                                $this->telegram->sendMessage(Message::changeTaskDescription($this->user));
                                break;
                            case 'amount':
                                $this->user->updateSteps(2, 3);
                                $this->telegram->sendMessage(Message::changeTaskAmount($this->user));
                                break;
                            case 'schedule_time':
                                $this->user->updateSteps(2, 4);
                                $this->telegram->sendMessage(Message::changeTaskSchedule($this->user));
                                break;
                            case 'category':
                                $this->user->updateSteps(2, 7);
                                $this->telegram->sendMessage(Message::changeTaskCategory($this->user));
                                break;
                        }
                    }
                }

                /**
                 * Task category change
                 */
                if ($this->step_two === 7) {
                    $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                    if (is_numeric($this->text) and $this->message_type == $this->telegram::CALLBACK_QUERY) {
                        $result = (new TaskableTaskUpdateService($this->user->taskable_log->task))->updateTaskCategory($this->text);
                        if ($result) {
                            $this->user->updateSteps(2, 6);
                            $this->telegram->sendMessage(Message::getTaskChangeMessage($this->user));
                        } else {
                            $this->telegram->sendMessage(Message::somethingWentWrong($this->user->chat_id));
                        }
                    }
                }
            }

            /**
             * My tasks.
             */
            if ($this->step_one === 3) {
                if ($this->step_two === 0) {
                    $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                    if ($this->message_type == $this->telegram::CALLBACK_QUERY) {
                        if ($this->text === 'add-task') {
                            $this->user->updateSteps(2, 0);
                            $this->telegram->sendMessage(Message::addTasksSectionMessage($this->user));
                        }

                        if (is_numeric($this->text)) {
                            $this->user->updateSteps(3, 1);
                            (new TaskableLogCreateService($this->user, $this->text))->createByTaskId();
                            $this->telegram->sendMessage(Message::getActiveTask($this->user->chat_id, $this->text));
                        }
                    }
                }

                if ($this->step_two === 1) {
                    $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                    if ($this->message_type == $this->telegram::CALLBACK_QUERY) {
                        if ($this->text === 'delete-button') {
                            $result = (new TaskableTaskDeleteService($this->user->taskable_log->task))->delete();
                            if ($result) {
                                $this->telegram->sendMessage(Message::getActiveTask($this->user->chat_id, $this->user->taskable_log->taskable_task_id));
                            }
                        }

                        if ($this->text === 'restore-button') {
                            $result = (new TaskableTaskRestoreService($this->user->taskable_log->task))->restore();
                            if ($result) {
                                $this->telegram->sendMessage(Message::getActiveTask($this->user->chat_id, $this->user->taskable_log->taskable_task_id));
                            }
                        }

                        if ($this->text === 'force-delete-button') {
                            $result = (new TaskableTaskDeleteService($this->user->taskable_log->task))->forceDelete();
                            if ($result) {
                                $this->user->updateSteps(3, 0);
                                $this->telegram->sendMessage(Message::myTasksSectionMessage($this->user));
                            }
                        }

                        if ($this->text === 'change-button') {
                            $this->user->updateSteps(2, 6);
                            $this->telegram->sendMessage(Message::getTaskChangeMessage($this->user));
                        }
                    }
                }
            }

            /**
             * Settings
             */
            if ($this->step_one === 4) {
                if ($this->step_two === 0) {
                    $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                    if ($this->message_type == $this->telegram::CALLBACK_QUERY) {
                        if ($this->text === 'tariff-plan') {
                            $this->user->updateSteps($this->step_one, 2);
                            $this->telegram->sendMessage(Message::tariffPlanSectionMessage($this->user->chat_id));
                        }

                        if ($this->text === 'handbook') {
                            $this->user->updateSteps($this->step_one, 3);
                            $this->telegram->sendMessage(Message::handbookSectionMessage($this->user->chat_id));
                        }
                    }
                }
            }
        } else {
            if (!$this->user->isBlocked()) {
                if ($this->telegram->getContactPhoneNumber() !== '') {
                    $checkingPhoneNumber = new PhoneNumberCheckService($this->telegram->getContactPhoneNumber());
                    $service = new BotUserUpdateService($this->user);

                    if ($checkingPhoneNumber()) {
                        $service->updatePhoneNumber($this->telegram->getContactPhoneNumber());
                        $service->updateActive(BotUserActiveEnum::ACTIVE);

                        $this->user->updateSteps(1, 0);

                        $this->telegram->sendMessage(Message::authenticatedSuccessfully($this->user->chat_id));
                        $this->telegram->sendMessage(Message::mainMenuMessage($this->user->chat_id));
                    } else {
                        $service->updateActive(BotUserActiveEnum::BLOCKED);

                        $this->user->updateSteps(0, 0);

                        $this->telegram->sendMessage(Message::authenticatedFailed($this->user->chat_id));
                    }
                } else {
                    $this->user->updateSteps(0, 1);
                    $this->telegram->sendMessage(Message::phoneNumberRequest($this->user->chat_id));
                }
            }
        }
    }
}
