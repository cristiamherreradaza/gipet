<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\CobrosTemporada;
use App\Transaccion;
use App\Servicio;
use App\Carrera;
use App\Descuento;
use App\Asignatura;
use DB;
use CodigoControlV7;

class TransaccionController extends Controller
{
   	public function pagos()
    {
        // $almacenes = Almacene::get();
        // $grupos = Grupo::all();
        // $clientes = User::where('rol', 'Cliente')
        //             ->get();
        // return view('transaccion.pagos')->with(compact('almacenes', 'clientes', 'grupos'));
        $servicios = Servicio::get();
        return view('transaccion.pagos', compact('servicios'));  
    }

    public function verifica_ci(Request $request)
    {
    	$carnet = $request->ci;
        // $almacenes = Almacene::get();
        // $grupos = Grupo::all();
        $persona = Persona::where('carnet', $carnet)
                    ->first();

        $servicios = Servicio::get();
        
        // $consulta = $this->consultar($persona->id);

        $servicios_persona = CobrosTemporada::where('persona_id', $persona->id)
        		   ->where('estado', 'Debe')
        		   ->select('servicio_id')
        		   ->groupBy('servicio_id')
                   ->get();
        // foreach ($servicios as $valor) {
        //     echo $valor->servicio_id;
        //     echo ', ';
        // }
        // return view('transaccion.pagos')->with(compact('almacenes', 'clientes', 'grupos'));
        return response()->json([
            'id' => $persona->id,
            'nombres' => $persona->nombres,
            'apellido_paterno' => $persona->apellido_paterno,
            'apellido_materno' => $persona->apellido_materno,
            'nit' => $persona->nit,
            'razon_social_cliente' => $persona->razon_social_cliente,
            'consulta' => $servicios_persona
        ]);
        // return view('transaccion.datos_carreras')->with(compact('servicios', 'servicios_persona', 'persona'));
    }

    // public function consultar($persona_id)
    // {

    //     $servicios = Servicio::get();

    //     $servicios_persona = CobrosTemporada::where('persona_id', $persona_id)
    //                ->where('estado', 'Debe')
    //                ->select('servicio_id')
    //                ->groupBy('servicio_id')
    //                ->get();

    //     return view('transaccion.datos_carreras')->with(compact('servicios', 'servicios_persona'));
    // }

    public function consulta(Request $request)
    {

        $servicios = Servicio::get();

        $servicios_persona = $request->termino;

        return view('transaccion.datos_carreras')->with(compact('servicios', 'servicios_persona'));
    }

    public function verifica_descuento(Request $request)
    {

        $descuento = Descuento::find($request->tipo);

        return response()->json([
            'descuento' => $descuento
        ]);
    }

    public function verifica_cobros_temporada(Request $request)
    {
        $carrera_id = $request->tipo_carrera_id;
        $servicio_id = $request->tipo_servicio_id;
        $persona_id = $request->tipo_persona_id;

        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
        $gestion = $fecha->format('Y');//obtenes solo el año actual

        $cobros_tem = CobrosTemporada::where('servicio_id', $servicio_id)
                                    ->where('persona_id', $persona_id)
                                    ->where('carrera_id', $carrera_id)
                                    ->where('gestion', $gestion)
                                    ->where('estado', 'Debe')
                                    ->first();
        $transacciones = Transaccion::where('cobros_temporadas_id', $cobros_tem->id)
                                    ->get();

        if (count($transacciones) > 0) {
            // foreach ($transacciones as $trans) {
            //     # code...
            // }
            dd($transacciones->last()->saldo);
        } else {
            dd('no');
        }

        

        return response()->json([
            'cobros_tem' => $cobros_tem
        ]);
    }

    public function carreras(Request $request)
    {
        $servicio_id = $request->tipo1;
        $carnet = $request->tipo2;

        $persona = Persona::where('carnet', $carnet)
                        ->first();
        $servicio = Servicio::find($servicio_id);
        
        $servicios_carreras = DB::table('cobros_temporadas')
             ->where('cobros_temporadas.persona_id', '=', $persona->id)
             ->where('cobros_temporadas.servicio_id', '=', $servicio_id)
             ->where('cobros_temporadas.estado', '=', 'Debe')
             ->join('carreras', 'cobros_temporadas.carrera_id', '=', 'carreras.id')
             ->select('carreras.id', 'carreras.nombre')
             ->orderBy('carreras.id')
             ->distinct('carreras.id')
             ->get();

        $descuentos = DB::table('descuentos_personas')
             ->where('descuentos_personas.servicio_id', '=', $servicio_id)
             ->where('descuentos_personas.persona_id', '=', $persona->id)
             ->join('descuentos', 'descuentos_personas.descuento_id', '=', 'descuentos.id')
             ->select('descuentos.id', 'descuentos.nombre', 'descuentos.porcentaje')
             ->distinct('descuentos.id')
             ->get();

        return response()->json([
            'carreras' => $servicios_carreras,
            'servicio' => $servicio,
            'descuento' => $descuentos
        ]);
    }

     public function asignaturas(Request $request)
    {
        $servicio_id = $request->tipo1;
        $carnet = $request->tipo2;

        $persona = Persona::where('carnet', $carnet)
                        ->first();

        $servicios_asignaturas = DB::table('cobros_temporadas')
             ->where('cobros_temporadas.persona_id', '=', $persona->id)
             ->where('cobros_temporadas.servicio_id', '=', $servicio_id)
             ->where('cobros_temporadas.estado', '=', 'Debe')
             ->join('asignaturas', 'cobros_temporadas.asignatura_id', '=', 'asignaturas.id')
             ->select('asignaturas.id', 'asignaturas.nombre_asignatura')
             ->orderBy('asignaturas.id')
             ->distinct('asignaturas.id')
             ->get();

        return response()->json($servicios_asignaturas);
    }

    public function verifica_datos(Request $request)
    {
        $servicio_id = $request->tipo_servicio_id;
        $carrera_id = $request->tipo_carrera_id;
        $asignatura_id = $request->tipo_asignatura_id;

        $servicio = Servicio::find($servicio_id);
        $carrera = Carrera::find($carrera_id);
        $asignatura = Asignatura::find($asignatura_id);

        return response()->json([
            'servicio' => $servicio,
            'carrera' => $carrera,
            'asignatura' => $asignatura
        ]);
    }

    public function formulario()
    {
        $facturador = new CodigoControlV7();
        $numero_autorizacion = '29040011007';
        $numero_factura = '1503';
        $nit_cliente = '4189179011';
        $fecha_compra = '20070702';
        $monto_compra = '2500';
        $clave = '9rCB7Sv4X29d)5k7N%3ab89p-3(5[A';
        dd(CodigoControlV7::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, $monto_compra, $clave));
        // dd($facturador::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, $monto_compra, $clave));

        // return view('empresa.formulario');
    }

    
}
