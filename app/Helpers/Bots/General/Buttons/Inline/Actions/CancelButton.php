<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Actions;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class CancelButton
{
    public function __invoke(): array
    {
        return ['text' => GetTextTranslations::getTextTranslation('cancel-button'), 'callback_data' => 'cancel-button'];
    }
}
