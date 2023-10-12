<?php

namespace App\Helpers\Bots\General\Buttons\Simple\Actions;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class NextStepButton
{
    public function __invoke(): array
    {
        return ['text' => GetTextTranslations::getTextTranslation('next-step-button')];
    }
}
