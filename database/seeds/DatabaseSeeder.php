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
        $this->call(ScenarioSeeder::class);
        $this->call(BaseHelpTypeSeeder::class);
        $this->call(AddHelpTypeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
//        $this->call(ProjectSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(DestinationSeeder::class);
        $this->call(CashSeeder::class);
//        $this->call(DestinationAttributeSeeder::class);
        $this->call(OrganLegalFormSeeder::class);
        $this->call(FondsSeeder::class);
//        $this->call(HelpSeeder::class);
    }
}
