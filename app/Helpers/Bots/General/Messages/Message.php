<?php

namespace App\Helpers\Bots\General\Messages;

use App\Contracts\Traits\Bots\Helpers\Messages\AuthenticationTrait;
use App\Contracts\Traits\Bots\Helpers\Messages\CategoriesTrait;
use App\Contracts\Traits\Bots\Helpers\Messages\HandbookTrait;
use App\Contracts\Traits\Bots\Helpers\Messages\ImmutableMessagesTrait;
use App\Contracts\Traits\Bots\Helpers\Messages\OperationRequestTrait;
use App\Contracts\Traits\Bots\Helpers\Messages\RequestButtonsTrait;
use App\Contracts\Traits\Bots\Helpers\Messages\TasksTrait;

class Message
{
    use TasksTrait;
    use CategoriesTrait;
    use RequestButtonsTrait;
    use AuthenticationTrait;
    use ImmutableMessagesTrait;

    public static function testMessage(int $chat_id, string $text): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
        ];
    }

    public static function somethingWentWrong(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => "Something went wrong!",
            'parse_mode' => 'html',
        ];
    }
}
