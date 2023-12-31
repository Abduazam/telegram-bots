<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Helpers\Bots\General\File\MakeFileSendable;
use App\Helpers\Bots\General\Buttons\Inline\Actions\BackButton;

trait SettingsTrait
{
    public static function handbookSectionMessage(int $chat_id): array
    {
        $video = (new MakeFileSendable('http://abduazam.hilalarabic.uz/storage/media/handbook/video.MP4'))->makeWithPublicUrl();

        return [
            'chat_id' => $chat_id,
            // 'video' => $video,
            // 'caption' => __('taskable.sections.settings.handbook'),
            'text' => "Ushbu maqola orqali botdan foydalanish bo'yicha qo'llanma bilan tanishib chiqishingiz mumkin\n\nhttps://telegra.ph/Taskable-botidan-foydalanish-qollanmasi-11-11",
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        (new BackButton())(),
                    ],
                ]
            ])
        ];
    }
}
