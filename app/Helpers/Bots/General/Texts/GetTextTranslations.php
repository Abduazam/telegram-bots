<?php

namespace App\Helpers\Bots\General\Texts;

use App\Models\Bots\BotTexts\BotText;

class GetTextTranslations
{
    public static function getTextTranslation($key)
    {
        $translation = BotText::where('key', $key)->where('locale', 'cy')->first();

        if ($translation && $translation->translation !== null) {
            return base64_decode($translation->translation);
        }

        return $key;
    }
}
