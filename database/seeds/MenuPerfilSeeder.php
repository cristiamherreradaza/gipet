<?php

use App\MenusPerfile;
use Illuminate\Database\Seeder;

class MenuPerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenusPerfile::insert([
            //Perfil de Administrador
            [
                'perfil_id'=> 1,
                'menu_id'=> 1,
            ],
            [
                'perfil_id'=> 1,
                'menu_id'=> 2,
            ],
            // [
            //     'perfil_id'=> 1,
            //     'menu_id'=> 3,
            // ],
            // [
            //     'perfil_id'=> 1,
            //     'menu_id'=> 4,
            // ],
            // [
            //     'perfil_id'=> 1,
            //     'menu_id'=> 5,
            // ],
            // [
            //     'perfil_id'=> 1,
            //     'menu_id'=> 6,
            // ],
            // //Perfil de Docente
            // [
            //     'perfil_id'=> 2,
            //     'menu_id'=> 5,
            // ],
            // //Perfil de Secretaria
            // [
            //     'perfil_id'=> 3,
            //     'menu_id'=> 1,
            // ],
            // [
            //     'perfil_id'=> 3,
            //     'menu_id'=> 2,
            // ],
            // [
            //     'perfil_id'=> 3,
            //     'menu_id'=> 3,
            // ],
            // [
            //     'perfil_id'=> 3,
            //     'menu_id'=> 4,
            // ],
        ]);
    }
}
