<?php

namespace Database\Seeders;

use App\Models\BusinessType;
use Illuminate\Database\Seeder;

class BusinessTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Салон красоты',
                'icon' => 'fas fa-scissors',
                'color' => null,
            ],
            [
                'name' => 'Спорт',
                'icon' => 'fas fa-dumbbell',
                'color' => null,
            ],
            [
                'name' => 'Барбершоп',
                'icon' => 'fas fa-straight-razor',
                'color' => null,
            ],
            [
                'name' => 'Массажный салон',
                'icon' => 'fas fa-hand-sparkles',
                'color' => null,
            ],
            [
                'name' => 'Стоматология',
                'icon' => 'fas fa-tooth',
                'color' => null,
            ],
            [
                'name' => 'Косметология',
                'icon' => 'fas fa-wand-magic-sparkles',
                'color' => null,
            ],
            [
                'name' => 'Фитнес-клуб',
                'icon' => 'fas fa-person-running',
                'color' => null,
            ],
            [
                'name' => 'Йога-студия',
                'icon' => 'fas fa-person-hiking',
                'color' => null,
            ],
            [
                'name' => 'Медицинский центр',
                'icon' => 'fas fa-hospital',
                'color' => null,
            ],
            [
                'name' => 'Автосервис',
                'icon' => 'fas fa-car',
                'color' => null,
            ],
            [
                'name' => 'Ресторан',
                'icon' => 'fas fa-utensils',
                'color' => null,
            ],
            [
                'name' => 'Кафе',
                'icon' => 'fas fa-cup-hot',
                'color' => null,
            ],
            [
                'name' => 'Отель',
                'icon' => 'fas fa-hotel',
                'color' => null,
            ],
        ];

        foreach ($types as $type) {
            BusinessType::query()->updateOrCreate(
                ['name' => $type['name']],
                [
                    'icon' => $type['icon'],
                    'color' => $type['color'],
                ]
            );
        }
    }
}
