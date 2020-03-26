<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Nota;
use Session;
use DB;

class NotaController extends Controller
{
    public function listado()
    {
        return view('nota.listado');
    }

    public function index()
    {

        $gestiones = DB::table('notas')
                ->select('usuario_id', 'gestion')
                ->where('usuario_id', 1)    // en vez de 1, ira el $usuario_id
                ->groupBy('usuario_id', 'gestion')
                ->get();

        $usuario = Usuario::find(1);
        //dd($usuario->id);
        //$notas = Nota::where('usuario_id', $usuario->id)->groupBy('gestion')->get();
        //dd($gestiones);
        return view('nota.index')->with(compact('usuario', 'gestiones'));
    }

    public function asignaturas($gestion)
    {
        
    }
}
