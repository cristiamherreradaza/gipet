<?php

namespace App\Http\Controllers;

use App\Nota;
use DataTables;
use App\Carrera;
use App\Asignatura;
use App\Resolucione;
use App\NotasPropuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarreraController extends Controller
{
    public function listado_nuevo()
    {
        $carreras = Carrera::get();
        return view('carrera.listado_nuevo')->with(compact('carreras'));
    }

    // Funcion que guarda una nueva carrera
    public function guardar(Request $request)
    {
        $resolucion = Resolucione::find($request->resolucion_carrera);
        $carrera = new Carrera();
        $carrera->user_id = Auth::user()->id;
        $carrera->resolucion_id = $resolucion->id;
        $carrera->nombre = $request->nombre_carrera;
        $carrera->nivel = $request->nivel_carrera;
        $carrera->duracion_anios = $request->duracion_carrera;
        $carrera->anio_vigente = $request->anio_vigente_carrera;
        $carrera->nota_aprobacion = $resolucion->nota_aprobacion;
        $carrera->save();
        return redirect('Carrera/listado');
    }

    public function ajaxEditaCarrera(Request $request)
    {
        $carrera = Carrera::find($request->carrera_id);
        $resoluciones = Resolucione::get();
        return view('carrera.ajaxEditaCarrera')->with(compact('carrera', 'resoluciones'));
    }

    public function actualizar(Request $request)
    {
        $carrera = Carrera::find($request->id_carrera_edicion);
        $resolucion = Resolucione::find($request->resolucion_carrera_edicion);
        $carrera->user_id = Auth::user()->id;
        $carrera->resolucion_id = $resolucion->id;
        $carrera->nombre = $request->nombre_carrera_edicion;
        $carrera->nivel = $request->nivel_carrera_edicion;
        $carrera->duracion_anios = $request->duracion_carrera_edicion;
        $carrera->anio_vigente = $request->anio_vigente_carrera_edicion;
        $carrera->nota_aprobacion = $resolucion->nota_aprobacion;
        $carrera->save();
        return redirect('Carrera/listado');
    }

    public function eliminar($id)
    {
        // Al eliminar la carrera, deben eliminarse tambien en tablas
        // asignaturas, asignaturas_equivalentes, notas_propuestas, notas, inscripciones
        $carrera = Carrera::find($id);
        $asignaturas = Asignatura::where('carrera_id', $carrera->id)
                                ->get();
        foreach($asignaturas as $asignatura){
            $asignatura->delete();
        }
        $carrera->delete();
        return redirect('Carrera/listado');
    }

    public function vista_impresion($id, $gestion)
    {
        $carrera = Carrera::find($id);
        $asignaturas = Asignatura::where('carrera_id', $carrera->id)
                                ->where('anio_vigente', $gestion)
                                ->get();
        return view('carrera.vista_impresion')->with(compact('carrera', 'asignaturas', 'gestion'));
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
        $carreras = Carrera::get();
        $resoluciones = Resolucione::get();
        return view('carrera.listado', compact('carreras', 'gestion', 'resoluciones'));
    }

    // Funcion que captura la informacion de la carrera seleccionada y busca sus asignaturas
    public function ajax_lista_asignaturas(Request $request)
    {
        $datos_carrera = Carrera::where('id', $request->c_carrera_id)
                                //->where('anio_vigente', $request->c_gestion)
                                ->first();
        $asignaturas = Asignatura::where('carrera_id', $request->c_carrera_id)
                                ->where('anio_vigente', $request->c_gestion)
                                //->orderBy('gestion', 'DESC')
                                ->get();
        return view('carrera.ajax_lista_asignaturas', compact('asignaturas', 'datos_carrera'));
    }

    // Funcion que devuelve un listado de materias para prerequisitos
    public function ajax_combo_materias(Request $request, $carrera_id, $anio_vigente)
    {
        $asignaturas = Asignatura::where('carrera_id', $carrera_id)
                                ->where('anio_vigente', $anio_vigente)
                                ->get();
        return view('carrera.ajax_combo_materias')->with(compact('asignaturas'));
    }

    public function cierraRegistroNotas(Request $request)
    {
        $anio_vigente = date('Y');
        $carrerasNotasPropuestas = Nota::where('anio_vigente', $anio_vigente)
                    ->groupBy('carrera_id')
                    ->groupBy('turno_id')
                    ->groupBy('gestion')
                    ->get();

        return view('carrera.cierraRegistroNotas')->with(compact('carrerasNotasPropuestas'));
    }

    public function actualizaCierraNotas(Request $request, $carrera_id, $anio_vigente, $turno, $estado, $bimestre)
    {
        if($estado == 'cerrado'){
            $modificaNotas = Nota::where('carrera_id', $carrera_id)
                    ->where('anio_vigente', $anio_vigente)
                    ->where('trimestre', $bimestre)
                    ->where('turno_id', $turno)
                    ->update(
                        ['finalizado' => 'Si']
                    );

        }else{
            $modificaNotas = Nota::where('carrera_id', $carrera_id)
                    ->where('anio_vigente', $anio_vigente)
                    ->where('trimestre', $bimestre)
                    ->where('turno_id', $turno)
                    ->update(
                        ['finalizado' => null]
                    );

        }

        return redirect('Carrera/cierraRegistroNotas');
    }

}