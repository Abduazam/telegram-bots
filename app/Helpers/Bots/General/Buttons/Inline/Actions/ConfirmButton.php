<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Actions;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class ConfirmButton
{
    public function __invoke(): array
    {
        return ['text' => __('telegram.request.confirm-button'), 'callback_data' => 'confirm-button'];
    }
}
