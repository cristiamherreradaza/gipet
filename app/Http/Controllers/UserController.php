<?php

namespace App\Http\Controllers;

use App\User;
use DataTables;
use App\Asignatura;
use App\NotasPropuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function asignar()
    {
        $users = User::where('vigente', 'si')->get();
        return view('user.asignar')->with(compact('users'));
    }

    public function listado()
    {
    	return view('user.listado');
    }

    public function ajax_listado()
    {
    	$lista_personal = User::all();
    	return Datatables::of($lista_personal)
            ->addColumn('action', function ($lista_personal) {
                return '<button onclick="asigna_materias('.$lista_personal->id.')" class="btn btn-info"><i class="fas fa-eye"></i></a>';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function asigna_materias($usuario_id = null)
    {
        $gestion_vigente = date('Y');

        $datos_persona = User::find($usuario_id);

        $asignaturas = Asignatura::where('borrado', NULL)
                    ->where('anio_vigente', $gestion_vigente)
                    ->get();

        $asignaturas_docente = NotasPropuesta::where('borrado', NULL)
                            ->where('user_id', $usuario_id)
                            ->where('anio_vigente', $gestion_vigente)
                            ->get();

    	return view('user.asigna_materias')->with(compact('asignaturas', 'asignaturas_docente', 'datos_persona'));
    }
}
