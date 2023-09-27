<?php

namespace App\Helpers\Bots\General\Buttons;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class BackButton
{
    public function __invoke(): array
    {
        return ['text' => GetTextTranslations::getTextTranslation('back-button'), 'callback_data' => 'back-button'];
    }
}
