<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Actions;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class ChangeButton
{
    public function __invoke(): array
    {
        return ['text' => GetTextTranslations::getTextTranslation('change-button'), 'callback_data' => 'change-button'];
    }
}
