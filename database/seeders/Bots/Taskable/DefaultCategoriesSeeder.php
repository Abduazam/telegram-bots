<?php

namespace Database\Seeders\Bots\Taskable;

use App\Models\Bots\Taskable\Categories\TaskableCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'sport' => "💪🏻 Sport",
            'movie' => "🎥 Kino",
            'book' => "📚 Kitoblar",
            'lesson' => "📝 Darslar",
        ];

        foreach ($categories as $key => $value) {
            TaskableCategory::create([
                'slug' => $key,
                'title' => base64_encode($value)
            ]);
        }
    }
}
