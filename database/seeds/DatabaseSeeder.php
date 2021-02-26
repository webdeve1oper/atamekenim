<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(BaseHelpTypeSeeder::class);
         $this->call(AddHelpTypeSeeder::class);
         $this->call(FondsSeeder::class);
         $this->call(UserSeeder::class);
         $this->call(ProjectSeeder::class);
         $this->call(NewsSeeder::class);
         $this->call(DestinationSeeder::class);
         $this->call(DestinationAttributeSeeder::class);
    }
}
