<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Actions;

class NextStepButton
{
    public function __invoke(): array
    {
        return ['text' => __('telegram.actions.next'), 'callback_data' => 'next-step-button'];
    }
}
