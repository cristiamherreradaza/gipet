<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\NotasPropuesta;

class NotasPropuestaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado()
    {
        $usuario = Auth::user();
        $asignaturas = $usuario->notaspropuestas;
        return view('notaspropuesta.listado')->with(compact('usuario', 'asignaturas'));
    }
}
