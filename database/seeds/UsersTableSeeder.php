<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // se adiciono al administrador     
        User::insert([
          [
          	'apellido_paterno'=>'Administrador',
          	'apellido_materno'=>'Administrador',
          	'nombres'=>'Administrador',
          	'password'=> bcrypt('123456789'),
          	'tipo_usuario'=>'Director',
          	'nombre_usuario'=>'Administrador',
            'vigente'=>'Si',
            'name'=>'admin@gipet.net'
          ],
        ]);
    }
}
