<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Servicio;
use App\TiposMensualidade;
use App\Carrera;
use App\Asignatura;
use App\ServiciosAsignatura;
use DB;

class ServicioController extends Controller
{
    public function periodo($id)
    {
        //dd($id);
        $servicio   = Servicio::find($id);
        $periodos   = TiposMensualidade::where('servicio_id', $servicio->id)->get();
        return view('tipos_mensualidades.listado')->with(compact('servicio', 'periodos'));
    }

    // Linea de comando
    public function guardar_periodo(Request $request)
    {
        $tipos_mensualidad = new TiposMensualidade();
        $tipos_mensualidad->user_id = Auth::user()->id;
        $tipos_mensualidad->servicio_id  = $request->id_servicio;
        $tipos_mensualidad->nombre = $request->nombre_servicio;
        $tipos_mensualidad->numero_maximo = $request->numero_mensualidad_servicio;
        $tipos_mensualidad->anio_vigente = $request->anio_vigente_servicio;
        $tipos_mensualidad->save();
        return redirect('Servicio/periodo/'.$request->id_servicio);
    }

    public function actualizar_periodo(Request $request)
    {
        $tipos_mensualidad = TiposMensualidade::find($request->id);
        $tipos_mensualidad->user_id = Auth::user()->id;
        $tipos_mensualidad->servicio_id  = $request->id_servicio_actualizar;
        $tipos_mensualidad->nombre = $request->nombre;
        $tipos_mensualidad->numero_maximo = $request->sigla;
        $tipos_mensualidad->anio_vigente = $request->precio;
        $tipos_mensualidad->save();
        return redirect('Servicio/periodo/'.$request->id_servicio_actualizar);
    }

    public function eliminar_periodo($id)
    {
        $periodo = TiposMensualidade::find($id);
        $servicio   = $periodo->servicio_id;
        $periodo->delete();
        return redirect('Servicio/periodo/'.$servicio);
    }

    public function listado()
    {
        $servicios = Servicio::get();
        return view('servicio.listado')->with(compact('servicios'));
    }

    public function guardar(Request $request)
    {
        $servicio = new Servicio();
        $servicio->user_id = Auth::user()->id;
        $servicio->sigla = $request->sigla_servicio;
        $servicio->nombre = $request->nombre_servicio;
        $servicio->precio = $request->precio_servicio;
        $servicio->save();
        return redirect('Servicio/listado');
    }

    public function actualizar(Request $request)
    {
        $servicio = Servicio::find($request->id);
        $servicio->user_id = Auth::user()->id;
        $servicio->sigla = $request->sigla;
        $servicio->nombre = $request->nombre;
        $servicio->precio = $request->precio;
        $servicio->save();
        return redirect('Servicio/listado');
    }

    public function eliminar($id)
    {
        $servicio = Servicio::find($id);
        $servicio->delete();
        return redirect('Servicio/listado');
    }

    public function listar()
    {
        $gestion = date('Y');

        $carreras = Carrera::get();

        $servicios = Servicio::where('gestion', $gestion)
                    ->where('id', '!=' ,'1')
                    ->where('id', '!=' ,'2')
                    ->get();
        return view('servicio.listar', compact('servicios', 'gestion', 'carreras'));
    }

    public function ajax_lista_cursos(Request $request)
    {
        $gestion = $request->c_gestion;

        // $datos_carrera = Carrera::where('id', $request->c_servicio_id)
        //             ->where('anio_vigente', $gestion)
        //             ->first();
        $servicios = Servicio::find($request->c_servicio_id);

        $servicios_asignaturas = DB::table('servicios_asignaturas')
             ->where('servicios_asignaturas.servicio_id', '=', $request->c_servicio_id)
             ->join('asignaturas', 'servicios_asignaturas.asignatura_id', '=', 'asignaturas.id')
             ->join('servicios', 'servicios_asignaturas.servicio_id', '=', 'servicios.id')
             ->select('asignaturas.id as asignatura_id', 'asignaturas.nombre_asignatura', 'asignaturas.carga_horaria', 'asignaturas.anio_vigente', 'servicios.id as servicio_id', 'servicios.nombre as nombre_servicio')
             ->get();
        // dd($servicios_asignaturas);

        // if ($datos_carrera != null) {
        //     $asignaturas = Asignatura::where('carrera_id', $datos_carrera->id)
        //         ->where('anio_vigente', $request->c_gestion)
        //         ->get();
        // }

        return view('servicio.ajax_lista_cursos', compact('servicios', 'servicios_asignaturas'));
    }

    public function ajax_guardar_servicio_asignatura(Request $request)
    {
        if (!empty($request->asignatura_id)) {

            $servicio = new ServiciosAsignatura();
            $servicio->asignatura_id = $request->asignatura_id;
            $servicio->servicio_id = $request->servicio_id;
            $servicio->save();

        } else {
            $asig= Asignatura::all();

            $servicio = new ServiciosAsignatura();
            $servicio->asignatura_id = $asig->last()->id;
            $servicio->servicio_id = $request->servicio_id;
            $servicio->save();
        }
        
        $servicios = Servicio::find($request->servicio_id);

        $servicios_asignaturas = DB::table('servicios_asignaturas')
             ->where('servicios_asignaturas.servicio_id', '=', $request->servicio_id)
             ->join('asignaturas', 'servicios_asignaturas.asignatura_id', '=', 'asignaturas.id')
             ->join('servicios', 'servicios_asignaturas.servicio_id', '=', 'servicios.id')
             ->select('asignaturas.id as asignatura_id', 'asignaturas.nombre_asignatura', 'asignaturas.carga_horaria', 'asignaturas.anio_vigente', 'servicios.id as servicio_id', 'servicios.nombre as nombre_servicio')
             ->get();

        return view('servicio.ajax_lista_cursos', compact('servicios', 'servicios_asignaturas'));
    }

    public function ajax_verifica_codigo_asignatura(Request $request)
    {
        $codigo = $request->codigo_asignatura;
        $cod = '%'.$codigo.'%';
        // $asignatura = Asignatura::where('codigo_asignatura', $request->codigo_asignatura)
        //                 ->where('anio_vigente', $request->gestion)
        //                 ->first();
        $asignatura = Asignatura::where('codigo_asignatura', 'like', $cod)
                        ->where('anio_vigente', $request->gestion)
                        ->get();
        // dd($asignatura);
        // exit();
        if (!empty($asignatura[0])) {
            return response()->json(['mensaje'=>'Si', 'asignatura'=>$asignatura]);
        } else {
            return response()->json(['mensaje'=>'No']);
        }
        // dd($asignatura);
        // exit();

        // return response()->json(['mensaje'=>'Registrado Correctamente']);
    }

    public function ajax_verifica_nombre_asignatura(Request $request)
    {
        $nombre = $request->nombre_asignatura;
        $servicio = Servicio::find($id);
        $servicio->delete();
        
        return response()->json(['mensaje'=>'Registrado Correctamente']);
    }

    
}
