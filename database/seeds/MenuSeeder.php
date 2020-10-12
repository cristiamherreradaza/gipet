<?php

use App\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::insert([
            [
                'nombre'=>'Configuracion',
                'direccion'=>NULL,
                'icono'=>'settings',
                'padre'=> NULL,
                'orden'=> 1,
            ],
            [
                'nombre'=>'Malla Curricular',
                'direccion'=>'Carrera/listado',
                'icono'=>'clipboard',
                'padre'=> 1,
                'orden'=> 1,
            ],
            // [
            //     'nombre'=>'Inscripciones',
            //     'direccion'=>'Inscripcion/inscripcion',
            //     'icono'=>'file-text',
            //     'padre'=> NULL,
            //     'orden'=> 2,
            // ],
            // [
            //     'nombre'=>'Alumnos',
            //     'direccion'=>'Persona/listado',
            //     'icono'=>'users',
            //     'padre'=> NULL,
            //     'orden'=> 3,
            // ],
            // [
            //     'nombre'=>'Personal',
            //     'direccion'=>'User/listado',
            //     'icono'=>'user',
            //     'padre'=> NULL,
            //     'orden'=> 4,
            // ],
            // [
            //     'nombre'=>'Asignaturas',
            //     'direccion'=>'Nota/listado',
            //     'icono'=>'book-open',
            //     'padre'=> NULL,
            //     'orden'=> 5,
            // ],
            // [
            //     'nombre'=>'Configuracion',
            //     'direccion'=>NULL,
            //     'icono'=>'settings',
            //     'padre'=> NULL,
            //     'orden'=> 6,
            // ],
            // [
            //     'nombre'=>'Carreras',
            //     'direccion'=>'Carrera/listado_nuevo',
            //     'icono'=>'clipboard',
            //     'padre'=> 6,
            //     'orden'=> 1,
            // ],
            // [
            //     'nombre'=>'Asignaturas',
            //     'direccion'=>'Asignatura/listado',
            //     'icono'=>'clipboard',
            //     'padre'=> 6,
            //     'orden'=> 2,
            // ],
            // [
            //     'nombre'=>'Descuentos',
            //     'direccion'=>'Descuento/listado',
            //     'icono'=>'clipboard',
            //     'padre'=> 6,
            //     'orden'=> 3,
            // ],
            // [
            //     'nombre'=>'Perfiles',
            //     'direccion'=>'Perfil/listado',
            //     'icono'=>'clipboard',
            //     'padre'=> 6,
            //     'orden'=> 4,
            // ],
            // [
            //     'nombre'=>'Servicios',
            //     'direccion'=>'Servicio/listado',
            //     'icono'=>'clipboard',
            //     'padre'=> 6,
            //     'orden'=> 5,
            // ],
            // [
            //     'nombre'=>'Turnos',
            //     'direccion'=>'Turno/listado',
            //     'icono'=>'clipboard',
            //     'padre'=> 6,
            //     'orden'=> 6,
            // ],
            // [
            //     'nombre'=>'Asignaturas Equivalentes',
            //     'direccion'=>'Asignatura/asignaturas_equivalentes',
            //     'icono'=>'clipboard',
            //     'padre'=> 6,
            //     'orden'=> 7,
            // ],
            // [
            //     'nombre'=>'Nuevo',
            //     'direccion'=>'User/nuevo',
            //     'icono'=>'plus-circle',
            //     'padre'=> 4,
            //     'orden'=> 1,
            // ],
            // [
            //     'nombre'=>'Listado',
            //     'direccion'=>'User/listado',
            //     'icono'=>'list',
            //     'padre'=> 4,
            //     'orden'=> 2,
            // ],
            // [
            //     'nombre'=>'Ponderacion',
            //     'direccion'=>'notaspropuesta/listado',
            //     'icono'=>'file-plus',
            //     'padre'=> 5,
            //     'orden'=> 1,
            // ],
            // [
            //     'nombre'=>'Notas',
            //     'direccion'=>'nota/listado',
            //     'icono'=>'file-minus',
            //     'padre'=> 5,
            //     'orden'=> 2,
            // ],
        ]);
    }
}
