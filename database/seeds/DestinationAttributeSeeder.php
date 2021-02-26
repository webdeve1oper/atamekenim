<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
class DestinationAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(config('destinations_attribute') as $item){
            if(!DB::table('destinations_attribute')->where('name_ru', $item['name_ru'])->first()){
                \App\DestinationAttribute::create($item);
            }
        }
    }
}
