<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(config('destinations') as $item){
            if(!DB::table('destinations')->where('name_ru', $item['name_ru'])->first()){
                $destination = \App\Destination::create($item);
            }
        }
    }
}
