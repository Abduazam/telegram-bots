<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Actions;

class BackButton
{
    public function __invoke(): array
    {
        return ['text' => __('telegram.actions.back'), 'callback_data' => 'back-button'];
    }
}
