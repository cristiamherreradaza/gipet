<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function nuevo()
    {
        return view('alumno/nuevo');
    }

    public function guarda(Request $request)
    {
        dd($request->all());
    }
    public function ariel()
    {
        dd('prueba');
    }
    public function fernandez()
    {
        dd('prueba2');
    }
}
