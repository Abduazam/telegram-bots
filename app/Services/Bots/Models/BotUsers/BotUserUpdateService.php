<?php

namespace App\Services\Bots\Models\BotUsers;

use App\Contracts\Enums\Bots\General\BotUserActiveEnum;
use App\Models\Bots\Users\BotUser;

class BotUserUpdateService
{
    public function __construct(protected BotUser $user) { }

    public function updatePhoneNumber($phone_number): void
    {
        $this->user->update([
            'phone_number' => $phone_number,
        ]);
    }

    public function updateActive(BotUserActiveEnum $active): void
    {
        $this->user->update([
            'active' => $active,
        ]);
    }
}
