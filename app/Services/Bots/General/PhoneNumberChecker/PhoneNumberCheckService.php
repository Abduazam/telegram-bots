<?php

namespace App\Services\Bots\General\PhoneNumberChecker;

use App\Models\Bots\General\AvailableCountries\AvailableCountry;

class PhoneNumberCheckService
{
    public function __construct(protected string $phone_number) { }

    public function __invoke(): bool
    {
        $phone_number = preg_replace('/\D/', '', $this->phone_number);
        $first_three_digits = substr($phone_number, 0, 3);

        return AvailableCountry::where('code', $first_three_digits)->exists();
    }
}
