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
                [
                    'Лекарство',
                    'Лечение',
                    'Диагностика',
                    'Реабилитация',
                    'Услуги сиделки',
                ],
                [
                    'Обучение',
                    'Доп.образование',
                    'Оборудование и инструменты',
                ],
                [
                    'Продукты питания',
                    'Одежды',
                    'Предметы быта',
                ],
            [
                'Оборудование и инструменты',
                'материалы',
                'Организация мероприятий',
                'Объекты культуры',
            ],

        ];

        foreach ($types as $id => $type){
            foreach($type as $addtype){
                if(!DB::table('add_help_types')->where('name_ru', $addtype)->first()){
                    DB::table('add_help_types')->insert([
                        'base_help_types_id'=>$id+1,
                        'name_ru'=>$addtype,
                        'name_kz'=>$addtype
                    ]);
                }
            }
        }
    }
}
