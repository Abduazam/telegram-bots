<?php

namespace App\Http\Controllers\Bots\Virdlarim;

use App\Contracts\Enums\Bots\General\FileTypeEnum;
use App\Helpers\Bots\General\Rules\TaskScheduleTimeCheckRule;
use App\Models\Bots\Users\BotUser;
use App\Models\Bots\Telegram\Telegram;
use App\Http\Controllers\Bots\BotsController;
use App\Helpers\Bots\General\Messages\Message;
use App\Services\Bots\Models\BotUsers\BotUserFindService;
use App\Services\Bots\General\PhoneNumberChecker\PhoneNumberCheckService;
use App\Services\Bots\Models\Categories\BotUserCategories\BotUserCategoryCreateService;
use App\Services\Bots\Models\Tasks\BotUserTaskFiles\BotUserTaskFileCreateService;
use App\Services\Bots\Models\Tasks\BotUserTasks\BotUserTaskCreateService;
use App\Services\Bots\Models\Tasks\BotUserTasks\BotUserTaskDeleteService;
use App\Services\Bots\Models\Tasks\BotUserTasks\BotUserTaskUpdateService;

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
            $this->user = (new BotUserFindService($this->telegram))->find();
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
                $this->user->updateSteps(1, 0);
                $this->telegram->sendMessage(Message::mainMenu($this->user->chat_id));
                return;
            }

            /**
             * Back step.
             */
            if ($this->text === 'back-button') {
                $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                if ($this->step_one === 2 or $this->step_one === 3 or $this->step_one === 4) {
                    if ($this->step_two === 0) {
                        $this->user->updateSteps(1, 0);
                        $this->telegram->sendMessage(Message::mainMenu($this->user->chat_id));
                    }
                }

                if ($this->step_one === 3) {
                    if ($this->step_two === 1 or $this->step_two === 2) {
                        $this->user->updateSteps(3, 0);
                        $this->telegram->sendMessage(Message::addTasksMessage($this->user->chat_id, $this->user));
                    }
                }

                return;
            }

            /**
             * Cancel step.
             */
            if ($this->text === 'cancel-button') {
                $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                if ($this->step_one === 3) {
                    if ($this->step_two === 3 or $this->step_two === 4) {
                        (new BotUserTaskDeleteService($this->user))->forceDelete();
                        $this->telegram->sendMessage(Message::operationCancelled($this->user->chat_id));
                        $this->user->updateSteps(3, 0);
                        $this->telegram->sendMessage(Message::addTasksMessage($this->user->chat_id, $this->user));
                    }
                }

                return;
            }

            /**
             * Main menu.
             */
            if ($this->step_one === 1 and $this->step_two === 0) {
                $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                if ($this->text === 'handbook-button') {
                    $this->user->updateSteps(2, 0);
                    $this->telegram->sendMessage(Message::handbookMessage($this->user->chat_id));
                }

                if ($this->text === 'my-tasks-button') {
                    $this->user->updateSteps(4, 0);
                    $this->telegram->sendMessage(Message::myTasksMessage($this->user));
                }

                if ($this->text === 'add-tasks-button') {
                    $this->user->updateSteps(3, 0);
                    $this->telegram->sendMessage(Message::addTasksMessage($this->user->chat_id, $this->user));
                }
            }

            /**
             * Add tasks.
             */
            if ($this->step_one === 3) {
                if ($this->step_two === 0) {
                    $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                    if ($this->text === 'user-add-category-button') {
                        $this->user->updateSteps(3, 1);
                        $this->telegram->sendMessage(Message::addUserCategoryMessage($this->user->chat_id));
                    } else if ($this->message_type == $this->telegram::CALLBACK_QUERY) {
                        $this->user->updateSteps(3, 2);
                        $this->telegram->sendMessage(Message::addTaskToCategory($this->user->chat_id, $this->text, $this->user));
                    }
                }

                if ($this->step_two === 1) {
                    if (isset($this->text)) {
                        (new BotUserCategoryCreateService($this->user, $this->text))();
                        $this->user->updateSteps(3, 0);
                        $this->telegram->sendMessage(Message::addTasksMessage($this->user->chat_id, $this->user));
                    } else {
                        $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                    }
                }

                if ($this->step_two === 2) {
                    if (isset($this->text)) {
                        (new BotUserTaskCreateService($this->user, $this->text))->createTextTask();
                        $this->user->updateSteps(3, 3);
                        $this->telegram->sendMessage(Message::addTasksAmount($this->user->chat_id));
                    } else {
                        $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                    }
                }

                if ($this->step_two === 3) {
                    if (isset($this->text) and is_numeric($this->text)) {
                        (new BotUserTaskUpdateService($this->user, $this->text))->updateAmountTask();
                        $this->user->updateSteps(3, 4);
                        $this->telegram->sendMessage(Message::addTasksSchedule($this->user->chat_id));
                    } else {
                        $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                    }
                }

                if ($this->step_two === 4) {
                    if (isset($this->text) and (new TaskScheduleTimeCheckRule($this->text))()) {
                        (new BotUserTaskUpdateService($this->user, $this->text))->updateScheduleTask();
                        $this->user->updateSteps(3, 5);
                        $this->telegram->sendMessage(Message::addTasksFiles($this->user->chat_id));
                    } else if ($this->text === 'next-step-button') {
                        $this->user->updateSteps(3, 5);
                        $this->telegram->sendMessage(Message::addTasksFiles($this->user->chat_id));
                    } else {
                        $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                    }
                }

                if ($this->step_two === 5) {
                    if (!isset($this->text)) {
                        $data = $this->telegram->getData();

                        if (isset($data['message'][FileTypeEnum::PHOTO->value])) {
                            $photo = $data['message'][FileTypeEnum::PHOTO->value];

                            if (isset($photo[2]['file_id'])) {
                                $file_id = $photo[2]['file_id'];
                            } elseif (isset($photo[1]['file_id'])) {
                                $file_id = $photo[1]['file_id'];
                            } else {
                                $file_id = $photo[0]['file_id'];
                            }

                            (new BotUserTaskFileCreateService($this->user, $file_id))->createPhotoTask();
                        } else {
                            $fileTypeMap = [
                                FileTypeEnum::VIDEO->value => 'createVideoTask',
                                FileTypeEnum::VOICE->value => 'createVoiceTask',
                                FileTypeEnum::AUDIO->value => 'createAudioTask',
                                FileTypeEnum::FILE->value => 'createFileTask',
                            ];

                            foreach ($fileTypeMap as $fileType => $method) {
                                if (isset($data['message'][$fileType]) && isset($data['message'][$fileType]['file_id'])) {
                                    $file_id = $data['message'][$fileType]['file_id'];
                                    (new BotUserTaskFileCreateService($this->user, $file_id))->$method();
                                    break;
                                }
                            }
                        }

                        $this->telegram->sendMessage(Message::addTasksFiles($this->user->chat_id));
                    } else if ($this->text === 'next-step-button') {
                        $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                        $this->user->updateSteps(3, 6);
                        $this->telegram->sendMessage(Message::getTask($this->user));
                    } else {
                        $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);
                    }
                }

                if ($this->step_two === 6) {
                    $this->telegram->deleteMessage(['chat_id' => $this->user->chat_id, 'message_id' => $this->message_id]);

                    if ($this->text === 'deny-button') {
                        (new BotUserTaskDeleteService($this->user))->forceDelete();
                        $this->telegram->sendMessage(Message::taskDenied($this->user->chat_id));
                    }

                    if ($this->text === 'confirm-button') {
                        (new BotUserTaskUpdateService($this->user))->updateActiveTask(true);
                        $this->telegram->sendMessage(Message::taskConfirmed($this->user->chat_id));
                    }

                    $this->user->updateSteps(3, 0);
                    $this->telegram->sendMessage(Message::addTasksMessage($this->user->chat_id, $this->user));
                }
            }
        } else {
            if (!$this->user->isBlocked()) {
                if ($this->telegram->getContactPhoneNumber() !== '') {
                    $phoneNumberChecker = new PhoneNumberCheckService($this->telegram->getContactPhoneNumber(), $this->user);
                    if ($phoneNumberChecker()) {
                        $this->user->updateSteps(1, 0);
                        $this->telegram->sendMessage(Message::authenticatedSuccessfully($this->user->chat_id));
                        $this->telegram->sendMessage(Message::mainMenu($this->user->chat_id));
                    } else {
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
