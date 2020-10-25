<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Predefinida;

class PredefinidaController extends Controller
{
    public function listado()
    {
        $predefinidas = Predefinida::get();
        return view('predefinida.listado')->with(compact('predefinidas'));
    }

    public function guardar(Request $request)
    {
        $predefinida = new Predefinida();
        $predefinida->user_id = Auth::user()->id;
        $predefinida->nota_asistencia = $request->nota_asistencia;
        $predefinida->nota_practicas = $request->nota_practicas;
        $predefinida->nota_puntos_ganados = $request->nota_puntos_ganados;
        $predefinida->nota_primer_parcial = $request->nota_primer_parcial;
        $predefinida->nota_examen_final = $request->nota_examen_final;
        $predefinida->fecha = date('Y-m-d');
        $predefinida->anio_vigente = $request->anio_vigente;
        $predefinida->activo = 'No';
        $predefinida->save();
        return redirect('Predefinida/listado');
    }

    public function actualizar(Request $request)
    {
        $predefinida = Predefinida::find($request->id);
        $predefinida->user_id = Auth::user()->id;
        $predefinida->nota_asistencia = $request->nota_asistencia_edicion;
        $predefinida->nota_practicas = $request->nota_practicas_edicion;
        $predefinida->nota_puntos_ganados = $request->nota_puntos_ganados_edicion;
        $predefinida->nota_primer_parcial = $request->nota_primer_parcial_edicion;
        $predefinida->nota_examen_final = $request->nota_examen_final_edicion;
        $predefinida->fecha = date('Y-m-d');
        $predefinida->anio_vigente = $request->anio_vigente_edicion;
        $predefinida->save();
        return redirect('Predefinida/listado');
    }

    public function eliminar($id)
    {
        $predefinida = Predefinida::find($id);
        $predefinida->delete();
        return redirect('Predefinida/listado');
    }
    
    public function cambiar($id)
    {
        // ANALIZAR PARA CUANDO YA SE HAYA DESIGNADO A LOS DOCENTES LAS MATERIAS Y POSTERIORMENTE SE HABILITO LAS NOTAS PREDEFINIDAS
        $predefinida = Predefinida::find($id);
        if($predefinida->activo == 'No'){
            // No esta activo, primero desactivar todos los demas registros y activar este
            $registros = Predefinida::get();
            foreach($registros as $registro){
                $registro->activo = 'No';
                $registro->save();
            }
            $predefinida->activo = 'Si';
        }else{
            // Si esta activo, desactivarlo
            $predefinida->activo = 'No';
        }
        // modificar valores
        $predefinida->save();
        return redirect('Predefinida/listado');
    }
}
