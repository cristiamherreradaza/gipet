<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Asignatura;
use App\Carrera;
use App\Certificado;
use App\EstudiantesCertificado;
use App\Persona;
use App\RequisitosCertificado;

class CertificadoController extends Controller
{
    public function listado()
    {
        $certificados = Certificado::get();
        $carreras = Carrera::get();
        return view('certificado.listado')->with(compact('certificados', 'carreras'));
    }

    public function guardar(Request $request)
    {
        $certificado = new Certificado();
        $certificado->user_id = Auth::user()->id;
        $certificado->nombre = $request->nombre_certificado;
        $certificado->anio_vigente = $request->anio_vigente_certificado;
        $certificado->save();
        return redirect('Certificado/listado');
    }

    public function actualizar(Request $request)
    {
        $certificado = Certificado::find($request->id);
        $certificado->user_id = Auth::user()->id;
        $certificado->nombre = $request->nombre;
        $certificado->anio_vigente = $request->anio_vigente;
        $certificado->save();
        return redirect('Certificado/listado');
    }

    public function eliminar($id)
    {
        $certificado = Certificado::find($id);
        // Tambien eliminar los requisitos de asignaturas para este certificado
        $asignaturas = RequisitosCertificado::where('certificado_id', $certificado->id)
                                            ->get();
        foreach($asignaturas as $asignatura){
            $asignatura->delete();
        }
        $certificado->delete();
        return redirect('Certificado/listado');
    }

    public function ajaxEditaRequisitos(Request $request)
    {
        $certificado = Certificado::find($request->certificado_id);
        $carrera = Carrera::find($request->requisito_carrera);
        $asignaturas = Asignatura::where('carrera_id', $carrera->id)
                                ->where('anio_vigente', '>=', '2020')
                                ->get();
        return view('certificado.ajaxEditaRequisitos')->with(compact('certificado', 'asignaturas', 'carrera'));
    }

    public function requisitos(Request $request)
    {
        $certificado = Certificado::find($request->certificado_id);
        // Eliminaremos los anteriores requisitos
        $requisitos = RequisitosCertificado::where('certificado_id', $certificado->id)
                                            ->get();
        if(count($requisitos) != 0){
            foreach($requisitos as $requisito){
                $requisito->delete();
            }
        }
        // Leeremos los que se enviaron y crearemos
        if($request->datosrequisitos)
        {
            foreach($request->datosrequisitos as $requisito)
            {
                $nuevo_requisito = new RequisitosCertificado();
                $nuevo_requisito->user_id = Auth::user()->id;
                $nuevo_requisito->certificado_id = $certificado->id;
                $nuevo_requisito->asignatura_id = $requisito;
                $nuevo_requisito->anio_vigente = $certificado->anio_vigente;
                $nuevo_requisito->save();
            }
        }
        return redirect('Certificado/listado');
    }

    public function emitir_certificado($persona_id, $certificado_id)
    {
        $certificado = Certificado::find($certificado_id);
        $persona = Persona::find($persona_id);
        // Buscaremos si ya existe un certificado para no llenar nuevamente en la base de datos
        $existe = EstudiantesCertificado::where('certificado_id', $certificado_id)
                                        ->where('persona_id', $persona_id)
                                        ->first();
        if($existe){
            // Solo crear PDF para imprimir y redirigir
            // dd('existe');
        }else{
            // crear en base de datos registro y despues crear PDF
            // dd('no existe');
            $certificacion = new EstudiantesCertificado();
            $certificacion->user_id = Auth::user()->id;
            $certificacion->certificado_id = $certificado_id;
            $certificacion->persona_id = $persona_id;
            $certificacion->fecha = date('Y-m-d');
            $certificacion->save();

            // Crear PDF
        }
        return redirect('Persona/ver_detalle/'.$persona_id);
    }

    public function eliminar_certificado($persona_id, $certificacion_id)
    {
        $certificado = EstudiantesCertificado::find($certificacion_id);
        // Si existe registro se lo elimina (validacion de multiples paginas para una operacion ya realizada)
        if($certificado){
            $certificado->delete();
        }
        return redirect('Persona/ver_detalle/'.$persona_id);
    }
}
