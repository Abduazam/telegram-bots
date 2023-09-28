<?php

namespace App\Helpers\Bots\General\Buttons\Actions;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class DenyButton
{
    public function __invoke(): array
    {
        return ['text' => GetTextTranslations::getTextTranslation('deny-button'), 'callback_data' => 'deny-button'];
    }
}
