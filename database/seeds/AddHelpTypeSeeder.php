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
            'Здоровье'=>[
                    'Лекарство',
                    'Лечение',
                    'Диагностика',
                    'Реабилитация',
                    'Услуги сиделки',
                ],
            'Образование'=>[
                    'Обучение',
                    'Доп.образование',
                    'Оборудование и инструменты',
                ],
            'Базовые потребности'=>[
                    'Продукты питания',
                    'Одежды',
                    'Предметы быта',
                ],
            'Исскуство и культура'=>[
                'Оборудование и инструменты',
                'материалы',
                'Организация мероприятий',
                'Объекты культуры',
            ],
            'Трудоустройство'=>[],
            'Наука'=>[
                'Исследования',
                'Оборудование и инструменты',
                'Научные мероприятия'
            ],
            'Жилье'=>[
                'Аренда',
                'Покупка',
                'Временное жилье',
            ],
            'Спорт'=>[
                'Инвентарь',
                'Организация мероприятий',
                'Спортивные объекты'
            ],
            'Жилищные условия'=>[
                'Ремонт',
                'Ком. услуги',
                'Отопление',
                'Водоснабжение',
                'Газификация',
            ],
            'Гражданские права'=>[
                'Имущественные',
                'Наследственные',
                'Коммерческие',
            ],
            'Урбанизация'=>[
                'Инфраструктурные объекты',
                'Организация пространства',
            ],
            'Экология'=>[
                'Флора и фауна',
            ],
            'Развитие сельских территорий'=>[
                'Инфраструктурные объекты',
                'Организация пространства',
            ],
            'Помощь бизнесу'=>[
                'Проекты социального предпринимательства',
                'Поддержка инициатив',
            ],
            'Забота о животных'=>[
                'Содержание',
                'Ветиринарные услуги',
            ],
            'Помещение в питомник'=>[],
        ];

        foreach ($types as $parent => $description){
            $typesParent = \App\AddHelpType::where('name_ru', $parent)->first();
            if(!$typesParent){
                \App\AddHelpType::create([
                    'name_ru'=>$parent,
                    'name_kz'=>$parent,
                    'description_ru'=> implode(',', $description),
                    'description_kz'=> implode(',', $description),
                ]);
            }
        }
    }
}
