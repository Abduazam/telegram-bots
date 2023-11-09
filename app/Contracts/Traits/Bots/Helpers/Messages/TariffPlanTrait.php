<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Helpers\Bots\General\Buttons\Inline\Actions\BackButton;

trait TariffPlanTrait
{
    public static function tariffPlanSectionMessage(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => __('telegram.response.empty', ['model' => __('taskable.sections.settings.tariff-plan')]),
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
}
