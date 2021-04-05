<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScenarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $destinations = [
                'Я прошу помощь для своей семьи',
                'Я прошу помощь для себя',
                'Я прошу помощь члену моей семьи (например, ребенку, родителю, супругу/е)',
                'Я прошу помощь для сообщества (например, многоквартирному дому, улице, населенному пункту)',
                'Я прошу помощь для организации (например, государственной или частной организации/компании)',
                'Я прошу помощь для животных',
            ];
        //
        foreach ($destinations as $destination){
            if(!DB::table('scenarios')->where('name_ru', $destination)->first()) {
                \App\Scenario::create(
                    [
                        'name_ru' => $destination,
                        'name_kz' => $destination
                    ]
                );
            }
        }

    }
}
