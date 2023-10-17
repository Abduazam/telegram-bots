<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Tasks;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class ForceDeleteButton
{
    public function __invoke(): array
    {
        return ['text' => GetTextTranslations::getTextTranslation('force-delete-button'), 'callback_data' => 'force-delete-button'];
    }
}
