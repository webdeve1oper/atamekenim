<?php

use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
                'title_ru' => 'Помощь обучающимся в перид карантина 2020 г.',
                'body_ru'=> 'При переходе на удаленное образование не все семьи имеют дома компьютер, ноутбук или планшет, необходимый
                                        для процесса обучения детей. В связи с этим целью проекта является привлечение',
                'public_date'=> date('Y-m-d', strtotime('12-01-2020')),
                'slug'=> 'pomosh-obuchyashimsya-v-period-karantina'
        ];

        if(!\Illuminate\Support\Facades\DB::table('news')->where('title_ru', $data['title_ru'])->first()){
            for ($i=0; $i<=9; $i++){
                $data['slug'] = $data['slug'].$i;
                \Illuminate\Support\Facades\DB::table('news')->insert($data);
            }
        }
    }
}
