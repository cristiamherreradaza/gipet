<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Turno;

class TurnoController extends Controller
{
    public function listado()
    {
        $turnos = Turno::get();
        return view('turno.listado')->with(compact('turnos'));
    }

    public function guardar(Request $request)
    {
        $turno = new Turno();
        $turno->user_id = Auth::user()->id;
        $turno->descripcion = $request->nombre_turno;
        $turno->save();
        return redirect('Turno/listado');
    }

    public function actualizar(Request $request)
    {
        $turno = Turno::find($request->id);
        $turno->user_id = Auth::user()->id;
        $turno->descripcion = $request->nombre;
        $turno->save();
        return redirect('Turno/listado');
    }

    public function eliminar($id)
    {
        $turno = Turno::find($id);
        $turno->delete();
        return redirect('Turno/listado');
    }
}
