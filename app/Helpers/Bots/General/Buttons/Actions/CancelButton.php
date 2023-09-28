<?php

namespace App\Helpers\Bots\General\Buttons\Actions;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class CancelButton
{
    public function __invoke(): array
    {
        return ['text' => GetTextTranslations::getTextTranslation('cancel-button'), 'callback_data' => 'cancel-button'];
    }
}
