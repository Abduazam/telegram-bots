<?php

namespace Database\Seeders\Bots\BotTexts;

use App\Models\Bots\BotTexts\BotText;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultBotTextsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $texts = [
            'request-phone-number-text' => "Телефон рақамингизни киритинг",
            'request-phone-number-button' => "📞 Рақам жўнатиш",
            'request-location-text' => "Манзилингизни киритинг",
            'request-location-button' => "📍 Манзил жўнатиш",
            'auth-success-text' => "Рўйхатдан муваффақиятли ўтдингиз!",
            'auth-failed-text' => "Рўйхатдан ўтолмадингиз!",
            'welcome-text' => "Хуш келибсиз",
            'main-menu-text' => "Бош саҳифа",
            'my-tasks-text' => "Вирдларингиз рўйхати",
            'my-tasks-button' => "Вирдларим",
            'add-tasks-text' => "Вирд қўшишингиз мумкин",
            'add-tasks-button' => "Вирд қўшиш",
            'handbook-button' => "Қўлланма",
            'back-button' => "🔙 Орқага",
            'cancel-button' => "❌ Бекор қилиш",
            'confirm-button' => "Тасдиқлайман",
            'confirmed-text' => "Тасдиқланди. Муваффақиятли сақланди",
            'deny-button' => "Тасдиқламайман",
            'denied-text' => "Тасдиқланмади. Бекор қилинди",
            'confirm-deny-request-text' => "Амалиётни тўхтатишни истайсизми?",
            'cancel-text' => "Амалиёт бекор қилинди",
            'next-step-button' => "🔜 Кейингиси",
            'change-button' => "♻️ Ўзгартириш",
            'saved-but-not-active-text' => "Қўшилаётган маълумотлар сақланди. Аммо фаол эмас.",
            'user-choose-category-text' => "Категорияни танланг",
            'user-add-category-text' => "Категория номини киритинг",
            'user-add-category-button' => "Категория қўшиш",
            'add-task-to-category-text' => "категорияси бўйича вирд қўшишингиз мумкин",
            'add-task-amount-text' => "Вирд бўйича кунлик бажариш қийматини киритинг\n(Фақат сон қиймати)",
            'add-task-schedule-text' => "Вирд бўйича куннинг қайси куни эслатма қўймоқчисиз?\n(Мисол учун: 11:00 ёки 20:00)",
            'add-task-files-text' => "Вирд бўйича файлларингиз бўлса юкланг",
            'change-task-description-text' => "Вирд номини ўзгартиришингиз мумкин",
            'change-task-amount-text' => "Вирд қийматини ўзгартиришингиз мумкин",
            'change-task-schedule-text' => "Вирд эслатма вақтини ўзгартиришингиз мумкин",
            'change-task-category-text' => "Вирд категориясини ўзгартиришингиз мумкин",
        ];

        foreach ($texts as $key => $value) {
            BotText::create([
                'key' => $key,
                'locale' => "cy",
                'translation' => base64_encode($value),
            ]);
        }
    }
}
