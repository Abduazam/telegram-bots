<?php

namespace Database\Seeders\Bots\Categories;

use App\Models\Bots\Categories\BotCategory;
use App\Models\Bots\Categories\BotCategoryTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultBotCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'sport' => "💪🏻 Спорт",
            'movie' => "🎥 Кино",
            'book' => "📚 Китоблар",
            'lesson' => "📝 Дарслар",
        ];

        foreach ($categories as $key => $value) {
            $category = BotCategory::create([
                'slug' => $key,
            ]);

            BotCategoryTranslation::create([
                'bot_category_id' => $category->id,
                'locale' => 'cy',
                'translation' => base64_encode($value)
            ]);
        }
    }
}
