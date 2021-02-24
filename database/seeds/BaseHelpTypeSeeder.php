<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseHelpTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $types = ['Здоровье', 'Образование', 'Базовые потребности',
            'Исскуство и культура',
            'Трудоустройство',
        ];

        foreach ($types as $id => $type){
            if(!DB::table('base_help_types')->where('name_ru', $type)->first()){
                DB::table('base_help_types')->insert([
                    'name_ru'=>$type,
                    'name_kz'=>$type
                ]);
            }
        }
    }
}
