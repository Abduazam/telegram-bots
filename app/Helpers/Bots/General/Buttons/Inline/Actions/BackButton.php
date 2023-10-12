<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Actions;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class BackButton
{
    public function __invoke(): array
    {
        return ['text' => GetTextTranslations::getTextTranslation('back-button'), 'callback_data' => 'back-button'];
    }
}