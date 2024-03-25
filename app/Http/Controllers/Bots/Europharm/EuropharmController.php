<?php

namespace App\Http\Controllers\Bots\Europharm;

use App\Http\Controllers\Bots\BotsController;
use App\Models\Bots\Telegram\Telegram;

class EuropharmController extends BotsController
{
    protected mixed $chat_id;

    public function __construct()
    {
        if (app()->runningInConsole()) {
            return;
        }

        $bot_token = config('telegram.bots.europharm.token');
        $this->telegram = new Telegram($bot_token);

        $this->text = $this->telegram->Text();
        $this->chat_id = $this->telegram->ChatID();
        $this->message_id = $this->telegram->MessageID();
    }

    public function index(): void
    {
        if ($this->text === '/start') {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => "Europharm – цифровая онлайн-аптека, с большой базой косметики, бадов, и лекарственных препаратов.\n\n📍 Г.Ташкент, М. Улугбекский р-н, кв-л Буюк Ипак Йули «Ц1», д 26 кв 13. Филиал Europharm +998 71 233 03 33\n📍 Г.Ташкент, М.Улугбекский р-н,Ц1,д.6/1. Филиал А5 +998 71 236 13 16 / 236 16 17",
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [
                            [
                                'text' => 'Доставка',
                            ],
                        ],
                    ],
                    'resize_keyboard' => true
                ])
            ]);
        } else if ($this->text === 'Доставка') {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => "Fargo УЗБ - 60.000сум (доставка в течении 3 суток в зависимости от региона)\n\nПри сумме заказа:\nДо 50.000 доставка 30.000сум\nОт 50.000 до 500.000 доставка 15.000сум\nСвыше 500.000 доставка бесплатная\n\nСамовывоз - Бесплатно (ваши товары в заказе будут забронированы)",
            ]);
        } else {
            $this->telegram->deleteMessage([
                'chat_id' => $this->chat_id,
                'message_id' => $this->message_id
            ]);
        }
    }
}
