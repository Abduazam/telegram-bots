<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Tasks;

class ForceDeleteButton
{
    public function __invoke(): array
    {
        return ['text' => __('telegram.crud.force-delete'), 'callback_data' => 'force-delete-button'];
    }
}
