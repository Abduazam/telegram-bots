<?php

return [

   /*
   |--------------------------------------------------------------------------
   | Taskable bot lines
   |--------------------------------------------------------------------------
   |
   | Given translations belongs to taskable bot. These translations should be used
   | only in specific telegram bot. Any other exceptions, like similarities to
   | other bots text, they will be created for their own.
   |
   */

    'main' => [
        'welcome' => "Xush kelibsiz",
        'menu' => "Bosh sahifa",

        'general' => [
            'saved' => "Qoʻshilayotgan maʼlumotlar saqlandi. Ammo faol emas.",
            'its-time' => "vaqti",
        ],

        'buttons' => [
            'task-done' => "🎯 Bajardim",
        ]
    ],

    'sections' => [
        'my-tasks' => [
            'text' => "📌 Mening vazifalarim",
        ],
        'add-task' => [
            'text' => "➕ Vazifa qo'shish",
            'add-category' => [
                'button' => "➕ Kategoriya qo'shish",
                'text' => "Kategoriya nomini kiriting",
            ],
            'adding-task' => [
                'description' => "kategoriyasi bo'yicha vazifa qo'shishingiz mumkin",
                'amount' => "Vazifa boʻyicha kunlik bajarish qiymatini kiriting\n(Faqat son qiymati)",
                'schedule' => "Vazifa boʻyicha kunning qaysi vaqtida eslatma qoʻymoqchisiz?\n(Misol uchun: 11:00 yoki 20:00)",
            ],
            'changing-task' => [
                'text' => "Oʻzgartirmoqchi boʻlgan narsangizni tanlang",
                'description' => "Vazifa nomini oʻzgartirishingiz mumkin",
                'category' => "Vazifa kategoriyasini oʻzgartirishingiz mumkin",
                'amount' => "Vazifa qiymatini oʻzgartirishingiz mumkin",
                'schedule' => "Vazifa eslatma vaqtini oʻzgartirishingiz mumkin",
            ],
            'notifying-task' => [
                'time-of' => "vaqti",
                'must-do' => "Bajarishingiz kerak",
            ],
            'choose-categories' => "Kategoriya tanlang",
        ],
        'settings' => [
            'text' => "Sozlamalar bo'limi",
            'tariff-plan' => "🆓 Tariflar",
            'handbook' => "Ushbu videoda botdan foydalanish bo'yicha qo'llanmaga ega bo'lishingiz mumkin",
        ],
        'my-categories' => [
            'text' => "🗂 Mening kategoriyalarim",
            'changing-category' => [
                'title' => "Kategoriya nomini o'zgartirishingiz mumkin",
            ],
        ],
        'task-done' => [
            'done-count' => "Bajargan qiymatingizni kiriting",
        ]
    ],

    'items' => [
        'task' => [
            'description' => "Vazifa nomi",
            'category' => "Kategoriyasi",
            'amount' => "Qiymati",
            'schedule' => "Eslatish vaqti",
        ],
        'category' => [
            'title' => "Kategoriya nomi",
            'tasks-count' => "Vazifalar soni",
        ]
    ],
];
