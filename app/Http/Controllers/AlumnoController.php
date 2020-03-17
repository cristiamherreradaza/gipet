<?php

namespace App\Http\Controllers;

use App\Turno;
use App\Carrera;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    public function nuevo()
    {
        // $combo_carreras = DB::table('carreras');
        $carreras = Carrera::where('borrado', NULL)->get();
        $turnos = Turno::where('borrado', NULL)->get();
        // dd($carreras);
        return view('alumno/nuevo')->with(compact('carreras', 'turnos'));
    }

    public function guarda(Request $request)
    {
        // dd($request->all());
        $persona = new Persona();
        $persona->apellido_paterno = $request->apellido_paterno;
        $persona->apellido_materno = $request->apellido_materno;
        $persona->nombres          = $request->nombres;
        $persona->carnet           = $request->carnet;
        $persona->expedido         = $request->expedido;
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->sexo             = $request->sexo;
        $persona->telefono_celular = $request->telefono_celular;
        $persona->email            = $request->email;
        $persona->trabaja          = $request->trabaja;
        $persona->empresa          = $request->empresa;
        $persona->direcion_empresa = $request->direcion_empresa;
        $persona->telefono_empresa = $request->telefono_empresa;
        $persona->nombre_padre     = $request->nombre_padre;
        $persona->celular_padre    = $request->celular_padre;
        $persona->nombre_madre     = $request->nombre_madre;
        $persona->celular_madre    = $request->celular_madre;
        $persona->nombre_tutor     = $request->nombre_tutor;
        $persona->telefono_tutor   = $request->telefono_tutor;
        $persona->nombre_esposo    = $request->nombre_esposo;
        $persona->telefono_esposo  = $request->telefono_esposo;
        $persona->save();
    }
    public function ariel()
    {
        dd('prueba');
    }
    public function fernandez()
    {
        dd('prueba2');
    }   
    public function herrera()
    {
        
    }
}
