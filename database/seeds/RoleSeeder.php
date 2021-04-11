<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name_ru'=>'Администратор',
                'name_kz'=>'Администратор',
                'role_type'=>'superuser'
            ],
            [
                'name_ru'=>'Модератор',
                'name_kz'=>'Модератор',
                'role_type'=>'moderator'
            ],
        ];
        //
        foreach ($roles as $role){
            if(!DB::table('roles')->where('name_ru', $role['name_ru'])->first()) {
                DB::table('roles')->insert($role);
            }
        }
    }
}
