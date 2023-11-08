<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Actions;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class ChangeButton
{
    public function __invoke(): array
    {
        return ['text' => __('telegram.actions.change'), 'callback_data' => 'change-button'];
    }
}
