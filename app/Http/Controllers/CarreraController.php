<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carrera;
use DataTables;

class CarreraController extends Controller
{
    public function tabla()
    {
        // $carreras = Carrera::all();
        // dd($carreras);
        return view('tabla');    
    }

    public function store(Request $request)
    {
        $carrera = new Carrera();
        $carrera->nom_carrera = $request->nom_carrera;
        $carrera->desc_niv = $request->desc_niv;
        $carrera->semes = $request->semes;
        $carrera->save();
        
        return response()->json(['mensaje'=>'Registrado Correctamente']);
    }
}
