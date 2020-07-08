<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carrera;
use App\Asignatura;
use DataTables;

class CarreraController extends Controller
{
    public function listado_nuevo()
    {
        $carreras = Carrera::whereNull('borrado')
                            //->orderBy('nombre', 'asc')
                            ->get();
        return view('carrera.listado_nuevo')->with(compact('carreras'));
    }

    public function guardar(Request $request)
    {
        $carrera = new Carrera();
        $carrera->nombre = $request->nombre_carrera;
        $carrera->nivel = $request->nivel_carrera;
        $carrera->anio_vigente = $request->anio_vigente_carrera;
        $carrera->save();
        return redirect('Carrera/listado_nuevo');
    }

    public function actualizar(Request $request)
    {
        $carrera = Carrera::find($request->id);
        $carrera->nombre = $request->nombre;
        $carrera->nivel = $request->nivel;
        $carrera->anio_vigente = $request->anio_vigente;
        $carrera->save();
        return redirect('Carrera/listado_nuevo');
    }

    public function eliminar($id)
    {
        $carrera = Carrera::find($id);
        $carrera->borrado = date('Y-m-d H:i:s');
        $carrera->save();
        return redirect('Carrera/listado_nuevo');
    }

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
        $gestion = date('Y');

        $carreras = Carrera::where("borrado", NULL)
                    ->where('anio_vigente', $gestion)
                    ->get();

        return view('carrera.listado', compact('carreras', 'gestion'));
    }

    public function ajax_lista_asignaturas(Request $request)
    {
        $gestion = $request->c_gestion;

        $datos_carrera = Carrera::where("borrado", NULL)
                    ->where('id', $request->c_carrera_id)
                    ->where('anio_vigente', $gestion)
                    ->first();

        if ($datos_carrera != null) {
            $asignaturas = Asignatura::where("borrado", NULL)
                ->where('carrera_id', $datos_carrera->id)
                ->where('anio_vigente', $request->c_gestion)
                ->get();
        }

        return view('carrera.ajax_lista_asignaturas', compact('asignaturas', 'datos_carrera'));
    }

    public function ajax_combo_materias(Request $request, $carrera_id, $anio_vigente)
    {
        $asignaturas = Asignatura::where("borrado", NULL)
            ->where('carrera_id', $carrera_id)
            ->where('anio_vigente', $anio_vigente)
            ->get();

        return view('carrera.ajax_combo_materias', compact('asignaturas'));
    }

}