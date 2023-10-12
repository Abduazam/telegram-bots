<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Actions;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class NextStepButton
{
    public function __invoke(): array
    {
        return ['text' => GetTextTranslations::getTextTranslation('next-step-button'), 'callback_data' => 'next-step-button'];
    }
}
