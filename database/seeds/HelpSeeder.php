<?php

use Illuminate\Database\Seeder;

class HelpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $helps = [
            'title'=>'Требуется помощь!',
            'body'=>'Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев более менее осмысленного текста рыбы на русском языке, а начинающему оратору отточить навык публичных выступлений в домашних условиях. При создании генератора мы использовали небезизвестный универсальный код речей. Текст генерируется абзацами случайным образом от двух до десяти предложений в абзаце, что позволяет сделать текст более привлекательным и живым для визуально-слухового восприятия.',
        ];

        $users = \App\User::all();
        foreach ($users as $user){
            $region = rand(720, 738);
            $data = [
                'title' =>$helps['title'],
                'body'=>$helps['body'],
                'region_id'=>$region,
                'user_id'=>$user->id,
            ];
            $city = \App\City::whereRegionId($region)->inRandomOrder()->limit(1)->pluck('city_id')->toArray();
            if(count($city)>0){
                $data['city_id'] = $city[0];
            }

            $fonds = \App\Fond::inRandomOrder()->limit(1)->pluck('id')->toArray()[0];

            $help = \App\Help::create($data);
            $help->fonds()->attach([$fonds]);
            $help->baseHelpTypes()->attach([rand(1,2), rand(3,4)]);
            $help->destinations()->attach([rand(1,2), rand(3,4)]);
        }

        $types = ['Финансовая розовая', 'Финансовая на постоянной основе', 'Финансовая на постоянной кредитов', 'Материальная'];

        foreach($types as $type){
            
        }
    }
}
