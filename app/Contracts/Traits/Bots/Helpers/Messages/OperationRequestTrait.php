<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

trait OperationRequestTrait
{
    public static function operationCancelled(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('cancel-text'),
            'parse_mode' => 'html',
        ];
    }
}
