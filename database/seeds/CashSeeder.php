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
            'Финансовая разовая'=>['name_kz' => 'Қаржылық бір реттік'],
            'Финансовая на постоянной основе'=>['name_kz' => 'Қаржылық тұрақты негізде'],
            'Финансовая погашение кредитов'=>['name_kz' => 'Қаржылық кредиттерді өтеу'],
            'Волонтерство'=>['name_kz' => 'Материалдық'],
            'Материальная'=>['name_kz' => 'Кеңес беру'],
            'Консультация'=>['name_kz' => 'Логистика'],
            'Сопровождение'=>['name_kz' => 'Еріктілік'],
            'Логистика'=>['name_kz' => 'Сүйемелдеу'],
            'Предоставление жилья, кризисные центры'=>['name_kz' => 'Тұрғын үй беру, дағдарыс орталықтары'],
        ];

        foreach ($types as $title_ru => $cashHelpType) {
            if(!\App\CashHelpType::where('name_ru', $cashHelpType)->first()){
                $data = [
                  'name_ru'=>$title_ru,
                  'name_kz' => $cashHelpType['name_kz'],
                ];
                $destination = \App\CashHelpType::create($data);
            }
        }

        $sizes = [
            'до 5 000 тг' => ['name_kz' => '5000 теңге'],
            '5 000 - 10 000 тг' => ['name_kz' => '5000 – 10000 тг'],
            '10 000 - 50 000 тг' => ['name_kz' => '10000 – 50000 теңге'],
            '50 000 - 150 000 тг' => ['name_kz' => '50000 – 150000 тг'],
            '150 000 - 300 000 тг' => ['name_kz' => '150000 – 300000 тг'],
            '300 000 - 1 млн тг' => ['name_kz' => '300000 – 1 млн. тг'],
            '1 млн - 5 млн тг' => ['name_kz' => '1 млн – 5 млн тг'],
            '5 млн - 10 млн тг' => ['name_kz' => '5 млн – 10 млн тг бастап'],
            '10 млн - 50 млн тг' => ['name_kz' => '10 млн – 50 млн тг'],
            '50 млн - 100 млн тг' => ['name_kz' => '50 млн – 100 млн тг'],
            '100 млн - 300 млн тг' => ['name_kz' => '100 млн – 300 млн. тг'],
            '300 млн тг и выше' => ['name_kz' => '300 млн теңге және одан жоғары'],
        ];

        foreach ($sizes as $title_ru => $size) {
            if(!\App\CashHelpSize::where('name_ru', $size)->first()){
                $data = [
                    'name_ru'=>$title_ru,
                    'name_kz'=>$size['name_kz'],
                ];
                \App\CashHelpSize::create($data);
            }
        }
    }
}
