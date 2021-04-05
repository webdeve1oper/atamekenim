<?php

use Illuminate\Database\Seeder;

class OrganLegalFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\OrganLegalForm::create([
            'name' => 'учреждение'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'общественное объединение'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'государственный фонд'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'благотворительный фонд'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'частный благотворительный фонд'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'корпоративный благотворительный фонд'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'общественный фонд'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'общественный благотворительный фонд'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'социальный фонд'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'культурный фонд'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'образовательный фонд'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'религиозное объединение'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'партия'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'Ассамблея народа Казахстана'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'потребительский кооператив'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'некоммерческое акционерное общество'
        ]);
        \App\OrganLegalForm::create([
            'name' => 'ассоциация юридических лиц'
        ]);
    }
}
