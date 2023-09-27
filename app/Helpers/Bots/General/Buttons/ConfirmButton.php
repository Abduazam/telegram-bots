<?php

namespace App\Helpers\Bots\General\Buttons;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class ConfirmButton
{
    public function __invoke(): array
    {
        return ['text' => GetTextTranslations::getTextTranslation('confirm-button'), 'callback_data' => 'confirm-button'];
    }
}
