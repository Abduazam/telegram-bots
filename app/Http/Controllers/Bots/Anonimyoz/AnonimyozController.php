<?php

namespace App\Http\Controllers\Bots\Anonimyoz;

use App\Models\Bots\Telegram\Telegram;
use App\Http\Controllers\Bots\BotsController;
use App\Repository\Bots\Models\General\BotRepository;
use App\Repository\Bots\Models\General\BotUserRepository;
use App\Events\Bots\Anonimyoz\Chat\UpdateReceiverIdToNull;
use App\Helpers\Bots\Anonimyoz\Messages\AnonimyozMessages;
use App\Helpers\Bots\Anonimyoz\Rules\StartCommandCheckRule;
use App\Services\Bots\Models\BotUsers\BotUserCreateService;
use App\Services\Bots\General\BotUser\BotUserExistsCheckService;
use App\Services\Bots\Anonimyoz\Chats\Create\AnonimyozChatCreate;

class AnonimyozController extends BotsController
{
    public function __construct(
        BotRepository $botRepository,
        BotUserRepository $botUserRepository
    ) {
        if (app()->runningInConsole()) {
            return;
        }

        $bot_token = config('telegram.bots.anonimyoz.token');
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
        $result = (new StartCommandCheckRule($this->text))();
        if (!is_null($result)) {
            $result = (new AnonimyozChatCreate($this->user, $result))();
            if ($result) {
                $this->telegram->sendMessage(AnonimyozMessages::sendMessageToReceiver($this->user));
            } else {
                $this->telegram->sendMessage(AnonimyozMessages::errorOccurred($this->user));
            }
        } else {
            if ($this->text === '/start') {
                UpdateReceiverIdToNull::dispatch($this->user);
                $this->telegram->sendMessage(AnonimyozMessages::welcomeMessage($this->user));
            } else if ($this->text === '/username') {
                $this->telegram->sendMessage(AnonimyozMessages::usernameMessage($this->user));
            } else {
                if ($this->message_type == Telegram::MESSAGE) {
                    $response = $this->telegram->sendMessage(AnonimyozMessages::messageToReceiver($this->user, $this->text));

                    if ($response['ok']) {
                        $this->telegram->sendMessage(AnonimyozMessages::yourMessageSent($this->user));
                    }
                } else {
                    $this->telegram->deleteMessage([
                        'chat_id' => $this->user->chat_id,
                        'message_id' => $this->message_id
                    ]);
                }
            }
        }
    }
}
