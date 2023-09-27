<?php

namespace App\Helpers\Bots\General\Buttons;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

class UserAddCategoryButton
{
    public function __invoke(): array
    {
        return ['text' => GetTextTranslations::getTextTranslation('user-add-category-button'), 'callback_data' => 'user-add-category-button'];
    }
}
