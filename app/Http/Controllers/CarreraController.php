<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carrera;
use App\Asignatura;
use DataTables;

class CarreraController extends Controller
{
    protected $gestion_actual = 'a';

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

    public function listado(Request $request)
    {
        if($request->has(['carrera_id', 'gestion']))
        {
            $gestion = $request->gestion;
            $carreras = Carrera::where("borrado", NULL)->get();
            $datos_carrera = Carrera::where("borrado", NULL)
                        ->where('id', $request->carrera_id)
                        ->first();
            $nombre_carrera = $datos_carrera->nombre;

            $asignaturas = Asignatura::where("borrado", NULL)
                        ->where('carrera_id', $datos_carrera->id)
                        ->where('anio_vigente', $request->gestion)
                        ->get();
        } else {
            // dd($request->session()->all());
            $gestion = date('Y');
            $datos_carrera = Carrera::where("id", 1)->first();
            $nombre_carrera = $datos_carrera->nombre;

            $carreras = Carrera::where("borrado", NULL)->get();
            $asignaturas = Asignatura::where("borrado", NULL)
                        ->where('carrera_id', 1)
                        ->where('anio_vigente', $gestion)
                        ->get();
        }
        // dd($nombre_carrera);

        return view('carrera.listado', compact('carreras', 'asignaturas', 'gestion', 'nombre_carrera'));
    }

    public function ajax_lista_asignaturas(Request $request)
    {
        // dd($request->carrera_id);
        $gestion = $request->gestion;
        $carreras = Carrera::where("borrado", NULL)->get();
        $datos_carrera = Carrera::where("borrado", NULL)
                    ->where('id', $request->carrera_id)
                    ->first();
        $nombre_carrera = $datos_carrera->nombre;

        $asignaturas = Asignatura::where("borrado", NULL)
                    ->where('carrera_id', $datos_carrera->id)
                    ->where('anio_vigente', $request->gestion)
                    ->get();
        // dd($request->input());
        return view('carrera.ajax_lista_asignaturas', compact('asignaturas', 'nombre_carrera', 'carreras'));
        // return response()->json(['mensaje'=>'Holas desde Ajax']);
    }

    public function guarda(Request $request)
    {
        
    }
}