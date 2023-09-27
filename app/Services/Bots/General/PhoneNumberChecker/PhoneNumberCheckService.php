<?php

namespace App\Services\Bots\General\PhoneNumberChecker;

use App\Models\Bots\Users\BotUser;
use App\Contracts\Enums\Bots\General\BotUserActiveEnum;
use App\Models\Bots\PhoneNumberCodes\CountryPhoneNumberCode;

class PhoneNumberCheckService
{
    public function __construct(
        protected string $phone_number,
        protected BotUser $user,
    ) { }

    public function __invoke(): bool
    {
        $phone_number = preg_replace('/\D/', '', $this->phone_number);
        $first_three_digits = substr($phone_number, 0, 3);
        $country_number = CountryPhoneNumberCode::where('code', $first_three_digits)->first();

        if ($country_number) {
            $this->user->update([
                'phone_number' => $this->phone_number,
                'active' => BotUserActiveEnum::ACTIVE,
            ]);

            return true;
        }

        $this->user->update([
            'active' => BotUserActiveEnum::BLOCKED
        ]);

        return false;
    }
}
