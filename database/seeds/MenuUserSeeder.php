<?php

use App\MenusUser;
use Illuminate\Database\Seeder;

class MenuUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenusUser::insert([
            //Permisos para el usuario con id 1
            [
                'user_id'=> 1,
                'menu_id'=> 1,
            ],
            [
                'user_id'=> 1,
                'menu_id'=> 2,
            ],
            [
                'user_id'=> 1,
                'menu_id'=> 3,
            ],
            [
                'user_id'=> 1,
                'menu_id'=> 4,
            ],
            [
                'user_id'=> 1,
                'menu_id'=> 5,
            ],
            [
                'user_id'=> 1,
                'menu_id'=> 6,
            ],
            [
                'user_id'=> 1,
                'menu_id'=> 7,
            ],
            // [
            //     'user_id'=> 1,
            //     'menu_id'=> 3,
            // ],
            // [
            //     'user_id'=> 1,
            //     'menu_id'=> 4,
            // ],
            // [
            //     'user_id'=> 1,
            //     'menu_id'=> 5,
            // ],
            // [
            //     'user_id'=> 1,
            //     'menu_id'=> 6,
            // ],
        ]);
    }
}
