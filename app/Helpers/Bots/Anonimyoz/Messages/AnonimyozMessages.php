<?php

namespace App\Helpers\Bots\Anonimyoz\Messages;

use App\Models\Bots\General\Users\BotUser;

class AnonimyozMessages
{
    public static function welcomeMessage(BotUser $user): array
    {
        $link = $user->id;
        if (!is_null($user->chat->sender_username)) {
            $link = $user->chat->sender_username;
        }

        return [
            'chat_id' => $user->chat_id,
            'text' => "Сизни ботдан фойдаланиш учун ҳаволангиз:\n\nt.me/anonimyozbot?start=" . $link,
            'parse_mode' => 'html',
            'disable_web_page_preview' => true,
        ];
    }

    public static function sendMessageToReceiver(BotUser $user): array
    {
        return [
            'chat_id' => $user->chat_id,
            'text' => "Хабарингизни юборинг (матн)",
            'parse_mode' => 'html',
        ];
    }

    public static function errorOccurred(BotUser $user): array
    {
        return [
            'chat_id' => $user->chat_id,
            'text' => "Хатолик юз берди ёки аноним фойдаланувчи топилмади 🤷🏻‍♂️\n\nҳаволангиз: t.me/anonimyozbot?start=" . $user->id,
            'parse_mode' => 'html',
            'disable_web_page_preview' => true,
        ];
    }

    public static function yourMessageSent(BotUser $user): array
    {
        return [
            'chat_id' => $user->chat_id,
            'text' => "Хабарингиз юборилди",
            'parse_mode' => 'html',
        ];
    }

    public static function messageToReceiver(BotUser $user, string $text): array
    {
        return [
            'chat_id' => $user->chat->receiver->chat_id,
            'text' => $text . "\n\n<a href='https://t.me/anonimyozbot?start=" . $user->id . "'>Жавоб бериш</a>",
            'parse_mode' => 'html',
            'disable_web_page_preview' => true,
        ];
    }

    public static function usernameMessage(BotUser $user): array
    {
        return [
            'chat_id' => $user->chat_id,
            'text' => "Ҳозирча бу хизмат йўлга қўйилмади",
            'parse_mode' => 'html',
            'disable_web_page_preview' => true,
        ];
    }
}
