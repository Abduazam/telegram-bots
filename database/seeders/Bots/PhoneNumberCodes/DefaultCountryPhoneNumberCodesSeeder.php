<?php

namespace Database\Seeders\Bots\PhoneNumberCodes;

use App\Models\Bots\PhoneNumberCodes\CountryPhoneNumberCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultCountryPhoneNumberCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country_codes = [
            'uz' => ['code' => 998, 'name' => 'Uzbekistan'],
            'kz' => ['code' => 997, 'name' => 'Kazakhstan'],
            'kg' => ['code' => 996, 'name' => 'Kyrgyzstan'],
        ];

        $countryNumbers = collect($country_codes)->map(function ($data, $slug) {
            return [
                'slug' => $slug,
                'code' => $data['code'],
                'name' => $data['name'],
            ];
        })->toArray();

        CountryPhoneNumberCode::insert($countryNumbers);
    }
}
