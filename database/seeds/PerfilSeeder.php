<?php

use App\Perfile;
use Illuminate\Database\Seeder;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perfile::insert([
            [
                'nombre'=>'Administrador',
                'descripcion'=>'Acceso a todas las funcionalidades del sistema.',
            ],
            [
                'nombre'=>'Docente',
                'descripcion'=>'Acceso al area de  asignaturas, ponderación y notas.',
            ],
            [
                'nombre'=>'Secretaria',
                'descripcion'=>'Acceso a la parte de inscripciones y listado de estudiantes.',
            ],
            [
                'nombre'=>'Alumno',
                'descripcion'=>'Acceso a la informacion de sus notas.',
            ],
        ]);
    }
}
