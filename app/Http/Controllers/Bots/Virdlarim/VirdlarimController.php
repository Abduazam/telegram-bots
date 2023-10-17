<?php

namespace App\Http\Controllers\Bots\Virdlarim;

use App\Contracts\Enums\Bots\Models\BotUsers\BotUserActiveEnum;
use App\Events\Bots\BotUserLog\UpdateBotUserLogToNull;
use App\Helpers\Bots\General\Messages\Message;
use App\Helpers\Bots\General\Rules\TaskScheduleTimeCheckRule;
use App\Http\Controllers\Bots\BotsController;
use App\Models\Bots\Telegram\Telegram;
use App\Models\Bots\Users\BotUser;
use App\Services\Bots\Models\BotUserLogs\BotUserLogCreateService;
use App\Services\Bots\Models\BotUsers\BotUserCreateService;
use App\Services\Bots\Models\BotUsers\BotUserFindService;
use App\Services\Bots\Models\BotUsers\BotUserUpdateService;
use App\Services\Bots\General\PhoneNumberChecker\PhoneNumberCheckService;
use App\Services\Bots\Models\Tasks\BotUserTasks\BotUserTaskCreateService;
use App\Services\Bots\Models\Tasks\BotUserTasks\BotUserTaskDeleteService;
use App\Services\Bots\Models\Tasks\BotUserTasks\BotUserTaskRestoreService;
use App\Services\Bots\Models\Tasks\BotUserTasks\BotUserTaskUpdateService;
use App\Services\Bots\Models\Categories\BotUserCategories\BotUserCategoryCreateService;

class VirdlarimController extends BotsController
{
    protected Telegram $telegram;
    protected BotUser $user;
    protected ?string $text = null;
    protected int $message_id;
    protected string|bool $message_type;
    protected int $step_one;
    protected int $step_two;

    public function __construct()
    {
        if (app()->runningInConsole()) {
            return;
        } else {
            $this->telegram = new Telegram(config('telegram.tokens.virdlarim'));

            $findingUser = new BotUserFindService($this->telegram->ChatID());
            if ($findingUser()) {
                $this->user = $findingUser();
            } else {
                $service = new BotUserCreateService($this->telegram->ChatID(), $this->telegram->FirstName(), $this->telegram->Username());
                $this->user = $service->create();
            }

            $this->text = $this->telegram->Text();
            $this->message_id = $this->telegram->MessageID();
            $this->message_type = $this->telegram->getUpdateType();

            $this->step_one = $this->user->steps->step_one;
            $this->step_two = $this->user->steps->step_two;
        }
    }

    public function index(): void
    {
        if ($this->user->isActive()) {
            if ($this->text === '/start') {
                if ($this->step_one === 2 and $this->step_two > 3) {
                    UpdateBotUserLogToNull::dispatch($this->user);
                    $this->telegram->sendMessage(Message::taskSaved($this->user->chat_id));
                }

                $this->user->updateSteps(1, 0);
                $this->telegram->sendMessage(Message::mainMenuMessage($this->user->chat_id));

                return;
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
                        if ($this->user->log?->task?->isChanging('description')) {
                            $this->user->updateSteps(2, 6);
                            $this->telegram->sendMessage(Message::getTaskChangeMessage($this->user));
                        } else {
                            $this->user->updateSteps(2, 0);
                            $this->telegram->sendMessage(Message::addTasksSectionMessage($this->user));
                        }
                    }

                    if (($this->step_two === 3 or $this->step_two === 4) and $this->user->log?->task?->isChanging('amount')) {
                        $this->user->updateSteps(2, 6);
                        $this->telegram->sendMessage(Message::getTaskChangeMessage($this->user));
                    }

                    if ($this->step_two === 6) {
                        if ($this->user->log->task->active) {
                            $this->user->updateSteps(3, 1);
                            $this->telegram->sendMessage(Message::getActiveTask($this->user->chat_id, $this->user->log->bot_user_task_id));
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
                        UpdateBotUserLogToNull::dispatch($this->user);
                        $this->telegram->sendMessage(Message::myTasksSectionMessage($this->user));
                    }
                }

                return;
            }

            /**
             * The main menu.
             */
            if ($this->step_one === 1 and $this->step_two === 0) {
                $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                if ($this->message_type === $this->telegram::CALLBACK_QUERY) {
                    if ($this->text === 'add-tasks-button') {
                        $this->user->updateSteps(2, 0);
                        $this->telegram->sendMessage(Message::addTasksSectionMessage($this->user));
                    }

                    if ($this->text === 'my-tasks-button') {
                        $this->user->updateSteps(3, 0);
                        $this->telegram->sendMessage(Message::myTasksSectionMessage($this->user));
                    }
                }
            }

            /**
             * Adding tasks.
             */
            if ($this->step_one === 2) {
                if ($this->step_two === 0) {
                    $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                    if ($this->message_type == $this->telegram::CALLBACK_QUERY) {
                        if ($this->text === 'user-add-category-button') {
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
                 * New user own category
                 */
                if ($this->step_two === 1) {
                    if (isset($this->text)) {
                        $result = (new BotUserCategoryCreateService($this->user, $this->text));
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
                    if ($this->user->log?->task?->isChanging('description')) {
                        $result = (new BotUserTaskUpdateService($this->user->log->task))->updateTaskDescription($this->text);
                        if ($result) {
                            $this->user->updateSteps(2, 6);
                            $this->telegram->sendMessage(Message::getTaskChangeMessage($this->user));
                        } else {
                            $this->telegram->sendMessage(Message::somethingWentWrong($this->user->chat_id));
                        }
                    } else {
                        $result = (new BotUserTaskCreateService($this->user))->createTaskDescription($this->text);
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
                        if ($this->user->log->task->isChanging('amount')) {
                            $step = 6;
                        } else {
                            $step = 4;
                        }

                        $result = (new BotUserTaskUpdateService($this->user->log->task))->updateTaskAmount($this->text);
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
                        if ($this->user->log->task->isChanging('schedule_time')) {
                            $step = 6;
                        } else {
                            $step = 5;
                        }

                        $result = (new BotUserTaskUpdateService($this->user->log->task))->updateTaskSchedule($this->text);
                        if ($result) {
                            $this->user->updateSteps(2, $step);
                            $message = $step === 6 ? Message::getTaskChangeMessage($this->user) : Message::getTask($this->user);
                            $this->telegram->sendMessage($message);
                        } else {
                            $this->telegram->sendMessage(Message::somethingWentWrong($this->user->chat_id));
                        }
                    } else if ($this->message_type === $this->telegram::CALLBACK_QUERY) {
                        $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                        $result = (new BotUserTaskUpdateService($this->user->log->task))->updateTaskSchedule('00:00:01');
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
                                $result = (new BotUserTaskDeleteService($this->user->log->task))->forceDelete();
                                if ($result) {
                                    UpdateBotUserLogToNull::dispatch($this->user);
                                    $this->telegram->sendMessage(Message::taskDenied($this->user->chat_id));
                                } else {
                                    $this->telegram->sendMessage(Message::somethingWentWrong($this->user->chat_id));
                                }
                            }

                            if ($this->text === 'confirm-button') {
                                $result = (new BotUserTaskUpdateService($this->user->log->task))->updateTaskActive(true);
                                if ($result) {
                                    UpdateBotUserLogToNull::dispatch($this->user);
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
                            case 'description': // done
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
                            case 'category': // done
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
                        $result = (new BotUserTaskUpdateService($this->user->log->task))->updateTaskCategory($this->text);
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
                        if ($this->text === 'add-tasks-button') {
                            $this->user->updateSteps(2, 0);
                            $this->telegram->sendMessage(Message::addTasksSectionMessage($this->user));
                        }

                        if (is_numeric($this->text)) {
                            $this->user->updateSteps(3, 1);
                            (new BotUserLogCreateService($this->user, $this->text))->createByTaskId();
                            $this->telegram->sendMessage(Message::getActiveTask($this->user->chat_id, $this->text));
                        }
                    }
                }

                if ($this->step_two === 1) {
                     $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                    if ($this->message_type == $this->telegram::CALLBACK_QUERY) {
                        if ($this->text === 'delete-button') {
                             $result = (new BotUserTaskDeleteService($this->user->log->task))->delete();
                             if ($result) {
                                $this->telegram->sendMessage(Message::getActiveTask($this->user->chat_id, $this->user->log->bot_user_task_id));
                             }
                        }

                        if ($this->text === 'restore-button') {
                             $result = (new BotUserTaskRestoreService($this->user->log->task))->restore();
                             if ($result) {
                                $this->telegram->sendMessage(Message::getActiveTask($this->user->chat_id, $this->user->log->bot_user_task_id));
                             }
                        }

                        if ($this->text === 'force-delete-button') {
                            $result = (new BotUserTaskDeleteService($this->user->log->task))->forceDelete();
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
                    if ($this->text !== '/start') {
                        $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                    }

                    $this->user->updateSteps(0, 1);
                    $this->telegram->sendMessage(Message::phoneNumberRequest($this->user->chat_id));
                }
            }
        }
    }
}
