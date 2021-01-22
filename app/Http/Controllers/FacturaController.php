<?php

namespace App\Http\Controllers;

use App\Persona;
use DataTables;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function listadoPersonas()
    {
    	return view('factura.listadoPersonas');
    }

    public function ajaxListadoPersonas()
    {
        $estudiantes = Persona::get();
        //$estudiantes = Persona::select('id', 'apellido_paterno', 'apellido_materno', 'nombres', 'carnet', 'telefono_celular', 'razon_social_cliente', 'nit');
        return Datatables::of($estudiantes)
            ->addColumn('action', function ($estudiantes) {
                return '<button onclick="ver_persona('.$estudiantes->id.')"        type="button" class="btn btn-info"      title="Ver"><i class="fas fa-eye"></i></button>
                        <button onclick="eliminar_persona('.$estudiantes->id.', '.$estudiantes->cedula.')" type="button" class="btn btn-danger" title="Eliminar Estudiante"><i class="fas fa-trash"></i></button>
                        <button onclick="contrato(' .  $estudiantes->id . ')"        type="button" class="btn btn-dark"    title="Contrato" ><i class="fas fa-file-alt"></i></button>';
            })
            ->make(true);
    }
}
