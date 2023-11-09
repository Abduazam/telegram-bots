<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Helpers\Bots\General\File\MakeFileSendable;
use App\Helpers\Bots\General\Buttons\Inline\Actions\BackButton;

trait SettingsTrait
{
    public static function handbookSectionMessage(int $chat_id): array
    {
        $video = (new MakeFileSendable('http://hilalarabic.uz/storage/lessons/bKNTYLZiXPq89LyJrpYzGdj2GBPiuH6L6b8FWpTD.mp4'))->makeWithPublicUrl();

        return [
            'chat_id' => $chat_id,
            'video' => $video,
            'caption' => __('taskable.sections.settings.handbook'),
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
