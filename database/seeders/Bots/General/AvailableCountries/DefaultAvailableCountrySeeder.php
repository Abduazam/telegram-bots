<?php

namespace Database\Seeders\Bots\General\AvailableCountries;

use App\Models\Bots\General\AvailableCountries\AvailableCountry;
use Illuminate\Database\Seeder;

class DefaultAvailableCountrySeeder extends Seeder
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

        AvailableCountry::insert($countryNumbers);
    }
}
