<?php

use Illuminate\Database\Seeder;

class CashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        $types = [
            'Финансовая разовая',
            'Финансовая на постоянной основе',
            'Финансовая погашение кредитов',
            'Волонтерство',
            'Материальная',
            'Консультация',
            'Сопровождение',
            'Логистика',
            'Предоставление жилья, кризисные центры',
        ];

        foreach ($types as $cashHelpType) {
            if(!\App\CashHelpType::where('name_ru', $cashHelpType)->first()){
                $data = [
                  'name_ru'=>$cashHelpType,
                  'name_kz'=>$cashHelpType,
                ];
                $destination = \App\CashHelpType::create($data);
            }
        }

        $sizes = [
            'до 5 000',
            '5 000 - 10 000 тг',
            '10 000 - 50 000 тг',
            '50 000 - 150 000 тг',
            '150 000 - 300 000 тг',
            '300 000 - 1 млн тг',
            '1 млн - 5 млн тг',
            '5 млн - 10 млн тг',
            '10 млн - 50 млн тг',
            '50 млн - 100 млн тг',
            '100 млн - 300 млн тг',
            '300 млн тг и выше',
        ];

        foreach ($sizes as $size) {
            if(!\App\CashHelpSize::where('name_ru', $size)->first()){
                $data = [
                    'name_ru'=>$size,
                    'name_kz'=>$size,
                ];
                \App\CashHelpSize::create($data);
            }
        }
    }
}
