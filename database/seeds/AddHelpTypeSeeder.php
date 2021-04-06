<?php

use Illuminate\Database\Seeder;

class AddHelpTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $types = [
            'Здоровье' => [
                'description' => [
                    'Лекарство',
                    'Лечение',
                    'Диагностика',
                    'Реабилитация',
                    'Услуги сиделки',],
                'scenario_id' => [1, 2, 3, 5]
            ],
            'Образование' => [
                'description' => [
                    'Обучение',
                    'Доп.образование',
                    'Оборудование и инструменты',
                ],
                'scenario_id' => [1, 2, 3, 5]
            ],
            'Базовые потребности' => [
                'description' => [
                    'Продукты питания',
                    'Одежды',
                    'Предметы быта',
                ],
                'scenario_id' => [1, 2, 3, 5]
            ],
            'Исскуство и культура' => [
                'description' => [
                    'Оборудование и инструменты',
                    'материалы',
                    'Организация мероприятий',
                    'Объекты культуры'
                ],
                'scenario_id' => [1, 2, 3, 5]
            ],
            'Трудоустройство' => ['description'=>[],'scenario_id' => [1, 2, 3]],
            'Наука' => [
                'description' => [
                    'Исследования',
                    'Оборудование и инструменты',
                    'Научные мероприятия'
                ],
                'scenario_id' => [1, 2, 3, 5]
            ],
            'Жилье' => [
                'description' => [
                    'Аренда',
                    'Покупка',
                    'Временное жилье'
                ],
                'scenario_id' => [1, 2, 3]
            ],
            'Спорт' => [
                'description' => [
                    'Инвентарь',
                    'Организация мероприятий',
                    'Спортивные объекты'
                ],
                'scenario_id' => [1, 2, 3, 5]
            ],
            'Жилищные условия' => [
                'description' => [
                    'Ремонт',
                    'Ком. услуги',
                    'Отопление',
                    'Водоснабжение',
                    'Газификация'
                ],
                'scenario_id' => [1, 2, 3, 5]
            ],
            'Гражданские права' => [
                'description' => [
                    'Имущественные',
                    'Наследственные',
                    'Коммерческие'
                ],
                'scenario_id' => [1, 2, 3, 5]
            ],
            'Урбанизация' => [
                'description' => [
                    'Инфраструктурные объекты',
                    'Организация пространства'
                ],
                'scenario_id' => [4]
            ],
            'Экология' => [
                'description' => [
                    'Флора и фауна',
                ],
                'scenario_id' => [4]
            ],
            'Развитие сельских территорий' => [
                'description' => [
                    'Инфраструктурные объекты',
                    'Организация пространства'
                ],
                'scenario_id' => [4]
            ],
            'Помощь бизнесу' => [
                'description' => [
                    'Проекты социального предпринимательства',
                    'Поддержка инициатив'
                ],
                'scenario_id' => [1, 2, 3, 4, 5]
            ],
            'Забота о животных' => [
                'description' => [
                    'Содержание',
                    'Ветиринарные услуги'
                ],
                'scenario_id' => [5,6]
            ],
            'Помещение в питомник' => ['description'=>[],'scenario_id' => [6]],
        ];

        foreach ($types as $parent => $description) {
            $typesParent = \App\AddHelpType::where('name_ru', $parent)->first();
            if (!$typesParent) {
                $addHelpType = \App\AddHelpType::create([
                    'name_ru' => $parent,
                    'name_kz' => $parent,
                    'description_ru' => implode(',', $description['description']),
                    'description_kz' => implode(',', $description['description']),
                ]);
                $addHelpType->scenarios()->attach($description['scenario_id']);
            }
        }
    }
}
