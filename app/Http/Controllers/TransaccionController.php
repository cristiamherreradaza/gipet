<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\CobrosTemporada;
use App\DescuentoPersona;
use App\Transaccion;
use App\Servicio;
use App\Carrera;
use App\Descuento;
use App\Asignatura;
use App\Empresa;
use App\DosificacionesFactura;
use App\Factura;
use App\DetallesFactura;
use Illuminate\Support\Facades\Auth;
use DB;
use CodigoControlV7;

class TransaccionController extends Controller
{
   	public function pagos()
    {
        $servicios = Servicio::get();
        return view('transaccion.pagos', compact('servicios'));  
    }

    public function verifica_ci(Request $request)
    {
    	$carnet = $request->ci;
        $persona = Persona::where('carnet', $carnet)
                    ->first();

        $servicios = Servicio::get();
        
        $servicios_persona = CobrosTemporada::where('persona_id', $persona->id)
        		   ->where('estado', 'Debe')
        		   ->select('servicio_id')
        		   ->groupBy('servicio_id')
                   ->get();
        return response()->json([
            'id' => $persona->id,
            'nombres' => $persona->nombres,
            'apellido_paterno' => $persona->apellido_paterno,
            'apellido_materno' => $persona->apellido_materno,
            'nit' => $persona->nit,
            'razon_social_cliente' => $persona->razon_social_cliente,
            'consulta' => $servicios_persona
        ]);
    }

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

    public function verifica_cobros_temporada_carrera(Request $request)
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

        $descuentos = Descuento::find(1);

        if (count($transacciones) > 0) {
            return response()->json([
                'cantidad' => 1,
                'precio_servicio' => $transacciones->last()->estimado,
                'descuento_id' => $descuentos,
                'descuento_bs' => 0,
                'total' => $transacciones->last()->saldo,
                'total_pagado' => $transacciones->last()->saldo,
                'verifica' => 'si'
            ]);
        } else {
            $servicio = Servicio::find($servicio_id);
            $des_per = DB::table('descuentos_personas')
                        ->where('descuentos_personas.servicio_id', $servicio_id)
                        ->where('descuentos_personas.persona_id', $persona_id)
                        ->join('descuentos', 'descuentos_personas.descuento_id', '=', 'descuentos.id')
                        ->select('descuentos.id', 'descuentos.nombre', 'descuentos.porcentaje')
                        ->get();
            if (count($des_per) > 0) {
                $num = "0.";
                $des_por = $num . $des_per[0]->porcentaje;
                $des_bs = ($servicio->precio * $des_por);
                $total = $servicio->precio - ($servicio->precio * $des_por);
                $num_sin_dec = round($total);
                // dd(round($servicio->precio * $des_por));
                // exit();

                return response()->json([
                        'cantidad' => 1,
                        'precio_servicio' => $servicio->precio,
                        'descuento_id' => $des_per,
                        'descuento_bs' => $des_bs,
                        'total' => $num_sin_dec,
                        'total_pagado' => $num_sin_dec,
                        'verifica' => 'no'
                ]);

            } else {
                $descuentos = Descuento::where('id', 1)
                                        ->get();

                return response()->json([
                'cantidad' => 1,
                'precio_servicio' => $servicio->precio,
                'descuento_id' => $descuentos,
                'descuento_bs' => 0,
                'total' => $servicio->precio,
                'total_pagado' => $servicio->precio,
                'verifica' => 'no'
            ]);
            }

            
        }
        
    }

    public function verifica_cobros_temporada_asignatura(Request $request)
    {
        $asignatura_id = $request->tipo_asignatura_id;
        $servicio_id = $request->tipo_servicio_id;
        $persona_id = $request->tipo_persona_id;

        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
        $gestion = $fecha->format('Y');//obtenes solo el año actual

        $cobros_tem = CobrosTemporada::where('servicio_id', $servicio_id)
                                    ->where('persona_id', $persona_id)
                                    ->where('asignatura_id', $asignatura_id)
                                    ->where('gestion', $gestion)
                                    ->where('estado', 'Debe')
                                    ->first();

        $transacciones = Transaccion::where('cobros_temporadas_id', $cobros_tem->id)
                                    ->get();

        $descuentos = Descuento::find(1);

        if (count($transacciones) > 0) {
            return response()->json([
                'cantidad' => 1,
                'precio_servicio' => $transacciones->last()->estimado,
                'descuento_id' => $descuentos,
                'descuento_bs' => 0,
                'total' => $transacciones->last()->saldo,
                'total_pagado' => $transacciones->last()->saldo,
                'verifica' => 'si'
            ]);
        } else {
            $servicio = Servicio::find($servicio_id);
            $des_per = DB::table('descuentos_personas')
                        ->where('descuentos_personas.servicio_id', $servicio_id)
                        ->where('descuentos_personas.persona_id', $persona_id)
                        ->join('descuentos', 'descuentos_personas.descuento_id', '=', 'descuentos.id')
                        ->select('descuentos.id', 'descuentos.nombre', 'descuentos.porcentaje')
                        ->get();
            if (count($des_per) > 0) {
                $num = "0.";
                $des_por = $num . $des_per[0]->porcentaje;
                $des_bs = ($servicio->precio * $des_por);
                $total = $servicio->precio - ($servicio->precio * $des_por);
                $num_sin_dec = round($total);
                // dd(round($servicio->precio * $des_por));
                // exit();

                return response()->json([
                        'cantidad' => 1,
                        'precio_servicio' => $servicio->precio,
                        'descuento_id' => $des_per,
                        'descuento_bs' => $des_bs,
                        'total' => $num_sin_dec,
                        'total_pagado' => $num_sin_dec,
                        'verifica' => 'no'
                ]);

            } else {
                $descuentos = Descuento::where('id', 1)
                                        ->get();

                return response()->json([
                'cantidad' => 1,
                'precio_servicio' => $servicio->precio,
                'descuento_id' => $descuentos,
                'descuento_bs' => 0,
                'total' => $servicio->precio,
                'total_pagado' => $servicio->precio,
                'verifica' => 'no'
            ]);
            }

            
        }
        
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
        $descuento_id = $request->tipo_descuento_id;
        $persona_id = $request->tipo_persona_id;
        $cantidad = $request->tipo_cantidad;

        $servicio = Servicio::find($servicio_id);
        $carrera = Carrera::find($carrera_id);
        $asignatura = Asignatura::find($asignatura_id);
        $descuento = Descuento::find($descuento_id);

        $meses = '';

        $cobros_temp = CobrosTemporada::where('servicio_id', $servicio_id)
                                        ->where('persona_id', $persona_id)
                                        ->where('carrera_id', $carrera_id)
                                        ->where('estado', 'Debe')
                                        ->skip(0)
                                        ->take($cantidad)
                                        ->get();

        if ($servicio_id == 2) {

            $meses = $this->mes($cobros_temp);
            return response()->json([
            'servicio' => $servicio,
            'carrera' => $carrera,
            'asignatura' => $asignatura,
            'descuento' => $descuento,
            'meses' => $meses,
            'mensu' => 'si'
        ]);
        } else {
            return response()->json([
            'servicio' => $servicio,
            'carrera' => $carrera,
            'asignatura' => $asignatura,
            'descuento' => $descuento,
            'mensu' => 'no'
        ]);
        }

    }

    public function mes($cobros_temp){
        $meses = '';
        foreach ($cobros_temp as $cobros) {
            $mes_num = $cobros->mensualidad;
            if($mes_num == 1){
                $meses = $meses . 'Ene, ';
            }

            if($mes_num == 2){
                $meses = $meses . 'Feb, ';
            }

            if($mes_num == 3){
                $meses = $meses . 'Mar, ';
            }

            if($mes_num == 4){
                $meses = $meses . 'Abr, ';
            }

            if($mes_num == 5){
                $meses = $meses . 'May, ';
            }

            if($mes_num == 6){
                $meses = $meses . 'Jun, ';
            }

            if($mes_num == 7){
                $meses = $meses . 'Jul, ';
            }

            if($mes_num == 8){
                $meses = $meses . 'Ago, ';
            }

            if($mes_num == 9){
                $meses = $meses . 'Sep, ';
            }

            if($mes_num == 10){
                $meses = $meses . 'Oct, ';
            }

            if($mes_num == 11){
                $meses = $meses . 'Nov, ';
            }

            if($mes_num == 12){
                $meses = $meses . 'Dic, ';
            }
        }
        $mes = trim($meses, ', ');
        return $mes;
        
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

    public function guardar_todo(Request $request)
    {

        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual

        $gestion = $fecha->format('Y');//obtenes solo el año actual

        $servicios = Servicio::where('nombre', $request->servicio)
                            ->where('gestion', $gestion)
                            ->first();

        $descuento = Descuento::where('nombre', $request->descuento)
                            ->first();
        $total = $request->total;
        
        if (!empty($request->carrera)) {
            $carrera = Carrera::where('nombre', $request->carrera)
                            ->where('gestion', $gestion)
                            ->first();
            for ($i=0; $i < $request->cantidad; $i++) { 
                $cobros_temporada = CobrosTemporada::where('servicio_id', $servicios->id)
                                ->where('persona_id', $request->persona_id)
                                ->where('carrera_id', $carrera->id)
                                ->where('gestion', $gestion)
                                ->where('estado', 'Debe')
                                ->first();

                $transacciones = Transaccion::where('cobros_temporadas_id', $cobros_temporada->id)
                                            ->get();
                if (count($transacciones) > 0) {
                    $estimado = $transacciones->last()->estimado;
                    $a_pagar = $transacciones->last()->saldo;

                    if ($a_pagar < $total) {

                        $total = $total - $a_pagar;
                        $pagado = $a_pagar;
                        $saldo = 0;
                        $observacion = 'Pagado';

                        //GUARDAR TRANSACCION
                        $transacciones_guarda = new Transaccion();
                        $transacciones_guarda->servicio_id          = $servicios->id;
                        $transacciones_guarda->descuento_id         = $descuento->id;
                        $transacciones_guarda->persona_id           = $request->persona_id;
                        $transacciones_guarda->cobros_temporadas_id = $cobros_temporada->id;
                        $transacciones_guarda->fecha_pago           = $fecha;
                        $transacciones_guarda->estimado             = $estimado;
                        $transacciones_guarda->a_pagar              = $a_pagar;
                        $transacciones_guarda->pagado               = $pagado;
                        $transacciones_guarda->saldo                = $saldo;
                        $transacciones_guarda->observacion          = $observacion;
                        $transacciones_guarda->save();


                        //GUARDAR DETALLE FACTURA
                        $detalle_factura = new DetallesFactura();
                        $detalle_factura->factura_id = $request->factura_id;
                        $detalle_factura->transaccion_id = $transacciones_guarda->id;
                        $detalle_factura->save();

                        //GUARDAR COBROS TEMPORADAS
                        $cobros_tempo = CobrosTemporada::find($cobros_temporada->id);
                        $cobros_tempo->estado = 'Pagado';
                        $cobros_tempo->save();

                    } else {

                        $pagado_1 = $total;
                        $saldo_1 = $a_pagar - $pagado_1;

                        if ($saldo_1 == 0) {

                            //GUARDAR TRANSACCION
                            $transacciones_guarda_1 = new Transaccion();
                            $transacciones_guarda_1->servicio_id          = $servicios->id;
                            $transacciones_guarda_1->descuento_id         = $descuento->id;
                            $transacciones_guarda_1->persona_id           = $request->persona_id;
                            $transacciones_guarda_1->cobros_temporadas_id = $cobros_temporada->id;
                            $transacciones_guarda_1->fecha_pago           = $fecha;
                            $transacciones_guarda_1->estimado             = $estimado;
                            $transacciones_guarda_1->a_pagar              = $a_pagar;
                            $transacciones_guarda_1->pagado               = $pagado_1;
                            $transacciones_guarda_1->saldo                = $saldo_1;
                            $transacciones_guarda_1->observacion          = 'Pagado';
                            $transacciones_guarda_1->save();

                            //GUARDAR DETALLE FACTURA
                            $detalle_factura = new DetallesFactura();
                            $detalle_factura->factura_id = $request->factura_id;
                            $detalle_factura->transaccion_id = $transacciones_guarda_1->id;
                            $detalle_factura->save();

                            //GUARDAR COBROS TEMPORADAS
                            $cobros_tempo_1 = CobrosTemporada::find($cobros_temporada->id);
                            $cobros_tempo_1->estado = 'Pagado';
                            $cobros_tempo_1->save();

                        } else {

                            //GUARDAR TRANSACCION
                            $transacciones_guarda_1 = new Transaccion();
                            $transacciones_guarda_1->servicio_id          = $servicios->id;
                            $transacciones_guarda_1->descuento_id         = $descuento->id;
                            $transacciones_guarda_1->persona_id           = $request->persona_id;
                            $transacciones_guarda_1->cobros_temporadas_id = $cobros_temporada->id;
                            $transacciones_guarda_1->fecha_pago           = $fecha;
                            $transacciones_guarda_1->estimado             = $estimado;
                            $transacciones_guarda_1->a_pagar              = $a_pagar;
                            $transacciones_guarda_1->pagado               = $pagado_1;
                            $transacciones_guarda_1->saldo                = $saldo_1;
                            $transacciones_guarda_1->observacion          = 'Pendiente';
                            $transacciones_guarda_1->save();

                           //GUARDAR DETALLE FACTURA
                            $detalle_factura = new DetallesFactura();
                            $detalle_factura->factura_id = $request->factura_id;
                            $detalle_factura->transaccion_id = $transacciones_guarda_1->id;
                            $detalle_factura->save();
                        }

                    }
                } else {

                    $estimado_sin = $servicios->precio;
                    $num = "0.";
                    $des_por = $num . $descuento->porcentaje;
                    $a_pagar_sin = $estimado_sin - ($estimado_sin * $des_por);

                    if ($a_pagar_sin < $total) {

                        $total = $total - $a_pagar_sin;
                        $pagado = $a_pagar_sin;
                        $saldo = 0;
                        $observacion = 'Pagado';

                        //GUARDAR TRANSACCION
                        $transacciones_guarda = new Transaccion();
                        $transacciones_guarda->servicio_id          = $servicios->id;
                        $transacciones_guarda->descuento_id         = $descuento->id;
                        $transacciones_guarda->persona_id           = $request->persona_id;
                        $transacciones_guarda->cobros_temporadas_id = $cobros_temporada->id;
                        $transacciones_guarda->fecha_pago           = $fecha;
                        $transacciones_guarda->estimado             = $estimado_sin;
                        $transacciones_guarda->a_pagar              = $a_pagar_sin;
                        $transacciones_guarda->pagado               = $pagado;
                        $transacciones_guarda->saldo                = $saldo;
                        $transacciones_guarda->observacion          = $observacion;
                        $transacciones_guarda->save();

                        //GUARDAR DETALLE FACTURA
                        $detalle_factura = new DetallesFactura();
                        $detalle_factura->factura_id = $request->factura_id;
                        $detalle_factura->transaccion_id = $transacciones_guarda->id;
                        $detalle_factura->save();

                        //GUARDAR COBROS TEMPORADAS
                        $cobros_tempo = CobrosTemporada::find($cobros_temporada->id);
                        $cobros_tempo->estado = 'Pagado';
                        $cobros_tempo->save();

                    } else {

                        $pagado_1 = $total;
                        $saldo_1 = $a_pagar_sin - $pagado_1;

                        if ($saldo_1 == 0) {

                            //GUARDAR TRANSACCION
                            $transacciones_guarda_1 = new Transaccion();
                            $transacciones_guarda_1->servicio_id          = $servicios->id;
                            $transacciones_guarda_1->descuento_id         = $descuento->id;
                            $transacciones_guarda_1->persona_id           = $request->persona_id;
                            $transacciones_guarda_1->cobros_temporadas_id = $cobros_temporada->id;
                            $transacciones_guarda_1->fecha_pago           = $fecha;
                            $transacciones_guarda_1->estimado             = $estimado_sin;
                            $transacciones_guarda_1->a_pagar              = $a_pagar_sin;
                            $transacciones_guarda_1->pagado               = $pagado_1;
                            $transacciones_guarda_1->saldo                = $saldo_1;
                            $transacciones_guarda_1->observacion          = 'Pagado';
                            $transacciones_guarda_1->save();

                            //GUARDAR DETALLE FACTURA
                            $detalle_factura = new DetallesFactura();
                            $detalle_factura->factura_id = $request->factura_id;
                            $detalle_factura->transaccion_id = $transacciones_guarda_1->id;
                            $detalle_factura->save();

                            //GUARDAR COBROS TEMPORADAS
                            $cobros_tempo_1 = CobrosTemporada::find($cobros_temporada->id);
                            $cobros_tempo_1->estado = 'Pagado';
                            $cobros_tempo_1->save();

                        } else {

                            //GUARDAR TRANSACCION
                            $transacciones_guarda_1 = new Transaccion();
                            $transacciones_guarda_1->servicio_id          = $servicios->id;
                            $transacciones_guarda_1->descuento_id         = $descuento->id;
                            $transacciones_guarda_1->persona_id           = $request->persona_id;
                            $transacciones_guarda_1->cobros_temporadas_id = $cobros_temporada->id;
                            $transacciones_guarda_1->fecha_pago           = $fecha;
                            $transacciones_guarda_1->estimado             = $estimado_sin;
                            $transacciones_guarda_1->a_pagar              = $a_pagar_sin;
                            $transacciones_guarda_1->pagado               = $pagado_1;
                            $transacciones_guarda_1->saldo                = $saldo_1;
                            $transacciones_guarda_1->observacion          = 'Pendiente';
                            $transacciones_guarda_1->save();

                            //GUARDAR DETALLE FACTURA
                            $detalle_factura = new DetallesFactura();
                            $detalle_factura->factura_id = $request->factura_id;
                            $detalle_factura->transaccion_id = $transacciones_guarda_1->id;
                            $detalle_factura->save();
                        }

                    }

                }
            }

        } else {

            $asignatura = Asignatura::where('nombre_asignatura', $request->asignatura)
                            ->where('anio_vigente', $gestion)
                            ->first();

            for ($i=0; $i < $request->cantidad; $i++) {    
                         
                $cobros_temporada = CobrosTemporada::where('servicio_id', $servicios->id)
                            ->where('persona_id', $request->persona_id)
                            ->where('asignatura_id', $asignatura->id)
                            ->where('gestion', $gestion)
                            ->where('estado', 'Debe')
                            ->first();

                $transacciones = Transaccion::where('cobros_temporadas_id', $cobros_temporada->id)
                                        ->get();
                if (count($transacciones) > 0) {
                    $estimado = $transacciones->last()->estimado;
                    $a_pagar = $transacciones->last()->saldo;

                    if ($a_pagar < $total) {

                        $total = $total - $a_pagar;
                        $pagado = $a_pagar;
                        $saldo = 0;
                        $observacion = 'Pagado';

                        //GUARDAR TRANSACCION
                        $transacciones_guarda = new Transaccion();
                        $transacciones_guarda->servicio_id          = $servicios->id;
                        $transacciones_guarda->descuento_id         = $descuento->id;
                        $transacciones_guarda->persona_id           = $request->persona_id;
                        $transacciones_guarda->cobros_temporadas_id = $cobros_temporada->id;
                        $transacciones_guarda->fecha_pago           = $fecha;
                        $transacciones_guarda->estimado             = $estimado;
                        $transacciones_guarda->a_pagar              = $a_pagar;
                        $transacciones_guarda->pagado               = $pagado;
                        $transacciones_guarda->saldo                = $saldo;
                        $transacciones_guarda->observacion          = $observacion;
                        $transacciones_guarda->save();

                        //GUARDAR DETALLE FACTURA
                        $detalle_factura = new DetallesFactura();
                        $detalle_factura->factura_id = $request->factura_id;
                        $detalle_factura->transaccion_id = $transacciones_guarda->id;
                        $detalle_factura->save();

                        //GUARDAR COBROS TEMPORADAS
                        $cobros_tempo = CobrosTemporada::find($cobros_temporada->id);
                        $cobros_tempo->estado = 'Pagado';
                        $cobros_tempo->save();

                    } else {

                        $pagado_1 = $total;
                        $saldo_1 = $a_pagar - $pagado_1;

                        if ($saldo_1 == 0) {

                            //GUARDAR TRANSACCION
                            $transacciones_guarda_1 = new Transaccion();
                            $transacciones_guarda_1->servicio_id          = $servicios->id;
                            $transacciones_guarda_1->descuento_id         = $descuento->id;
                            $transacciones_guarda_1->persona_id           = $request->persona_id;
                            $transacciones_guarda_1->cobros_temporadas_id = $cobros_temporada->id;
                            $transacciones_guarda_1->fecha_pago           = $fecha;
                            $transacciones_guarda_1->estimado             = $estimado;
                            $transacciones_guarda_1->a_pagar              = $a_pagar;
                            $transacciones_guarda_1->pagado               = $pagado_1;
                            $transacciones_guarda_1->saldo                = $saldo_1;
                            $transacciones_guarda_1->observacion          = 'Pagado';
                            $transacciones_guarda_1->save();

                            //GUARDAR DETALLE FACTURA
                            $detalle_factura = new DetallesFactura();
                            $detalle_factura->factura_id = $request->factura_id;
                            $detalle_factura->transaccion_id = $transacciones_guarda_1->id;
                            $detalle_factura->save();

                            //GUARDAR COBROS TEMPORADAS
                            $cobros_tempo_1 = CobrosTemporada::find($cobros_temporada->id);
                            $cobros_tempo_1->estado = 'Pagado';
                            $cobros_tempo_1->save();

                        } else {

                            //GUARDAR TRANSACCION
                            $transacciones_guarda_1 = new Transaccion();
                            $transacciones_guarda_1->servicio_id          = $servicios->id;
                            $transacciones_guarda_1->descuento_id         = $descuento->id;
                            $transacciones_guarda_1->persona_id           = $request->persona_id;
                            $transacciones_guarda_1->cobros_temporadas_id = $cobros_temporada->id;
                            $transacciones_guarda_1->fecha_pago           = $fecha;
                            $transacciones_guarda_1->estimado             = $estimado;
                            $transacciones_guarda_1->a_pagar              = $a_pagar;
                            $transacciones_guarda_1->pagado               = $pagado_1;
                            $transacciones_guarda_1->saldo                = $saldo_1;
                            $transacciones_guarda_1->observacion          = 'Pendiente';
                            $transacciones_guarda_1->save();

                            //GUARDAR DETALLE FACTURA
                            $detalle_factura = new DetallesFactura();
                            $detalle_factura->factura_id = $request->factura_id;
                            $detalle_factura->transaccion_id = $transacciones_guarda_1->id;
                            $detalle_factura->save();

                        }

                    }
                } else {

                    $estimado_sin = $servicios->precio;
                    $num = "0.";
                    $des_por = $num . $descuento_id->porcentaje;
                    $a_pagar_sin = $estimado_sin - ($estimado_sin * $des_por);

                    if ($a_pagar_sin < $total) {

                        $total = $total - $a_pagar;
                        $pagado = $a_pagar;
                        $saldo = 0;
                        $observacion = 'Pagado';

                        //GUARDAR TRANSACCION
                        $transacciones_guarda = new Transaccion();
                        $transacciones_guarda->servicio_id          = $servicios->id;
                        $transacciones_guarda->descuento_id         = $descuento->id;
                        $transacciones_guarda->persona_id           = $request->persona_id;
                        $transacciones_guarda->cobros_temporadas_id = $cobros_temporada->id;
                        $transacciones_guarda->fecha_pago           = $fecha;
                        $transacciones_guarda->estimado             = $estimado_sin;
                        $transacciones_guarda->a_pagar              = $a_pagar_sin;
                        $transacciones_guarda->pagado               = $pagado;
                        $transacciones_guarda->saldo                = $saldo;
                        $transacciones_guarda->observacion          = $observacion;
                        $transacciones_guarda->save();

                        //GUARDAR DETALLE FACTURA
                        $detalle_factura = new DetallesFactura();
                        $detalle_factura->factura_id = $request->factura_id;
                        $detalle_factura->transaccion_id = $transacciones_guarda->id;
                        $detalle_factura->save();


                        //GUARDAR COBROS TEMPORADAS
                        $cobros_tempo = CobrosTemporada::find($cobros_temporada->id);
                        $cobros_tempo->estado = 'Pagado';
                        $cobros_tempo->save();

                    } else {

                        $pagado_1 = $total;
                        $saldo_1 = $a_pagar - $pagado_1;

                        if ($saldo_1 == 0) {

                            //GUARDAR TRANSACCION
                            $transacciones_guarda_1 = new Transaccion();
                            $transacciones_guarda_1->servicio_id          = $servicios->id;
                            $transacciones_guarda_1->descuento_id         = $descuento->id;
                            $transacciones_guarda_1->persona_id           = $request->persona_id;
                            $transacciones_guarda_1->cobros_temporadas_id = $cobros_temporada->id;
                            $transacciones_guarda_1->fecha_pago           = $fecha;
                            $transacciones_guarda_1->estimado             = $estimado_sin;
                            $transacciones_guarda_1->a_pagar              = $a_pagar_sin;
                            $transacciones_guarda_1->pagado               = $pagado_1;
                            $transacciones_guarda_1->saldo                = $saldo_1;
                            $transacciones_guarda_1->observacion          = 'Pagado';
                            $transacciones_guarda_1->save();

                            //GUARDAR DETALLE FACTURA
                            $detalle_factura = new DetallesFactura();
                            $detalle_factura->factura_id = $request->factura_id;
                            $detalle_factura->transaccion_id = $transacciones_guarda_1->id;
                            $detalle_factura->save();

                            //GUARDAR COBROS TEMPORADAS
                            $cobros_tempo_1 = CobrosTemporada::find($cobros_temporada->id);
                            $cobros_tempo_1->estado = 'Pagado';
                            $cobros_tempo_1->save();

                        } else {

                            //GUARDAR TRANSACCION
                            $transacciones_guarda_1 = new Transaccion();
                            $transacciones_guarda_1->servicio_id          = $servicios->id;
                            $transacciones_guarda_1->descuento_id         = $descuento->id;
                            $transacciones_guarda_1->persona_id           = $request->persona_id;
                            $transacciones_guarda_1->cobros_temporadas_id = $cobros_temporada->id;
                            $transacciones_guarda_1->fecha_pago           = $fecha;
                            $transacciones_guarda_1->estimado             = $estimado_sin;
                            $transacciones_guarda_1->a_pagar              = $a_pagar_sin;
                            $transacciones_guarda_1->pagado               = $pagado_1;
                            $transacciones_guarda_1->saldo                = $saldo_1;
                            $transacciones_guarda_1->observacion          = 'Pendiente';
                            $transacciones_guarda_1->save();

                            //GUARDAR DETALLE FACTURA
                            $detalle_factura = new DetallesFactura();
                            $detalle_factura->factura_id = $request->factura_id;
                            $detalle_factura->transaccion_id = $transacciones_guarda_1->id;
                            $detalle_factura->save();
                        }

                    }

                }
            }
        }

        return response()->json([
            'guardado' => 'si'
        ]);
    }

    public function guardar_factura(Request $request)
    {
        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
        $gestion = $fecha->format('Y');//obtenes solo el año actual
        $fecha_factura = $fecha->format('Ymd');

        $persona_id = $request->persona_id;
        $razon_social_cliente = $request->razon_social_cliente;
        $nit = $request->nit;
        $total = $request->resultadoTotales;

        //Datos de la Empresa
        $empresa = Empresa::where('estado', 'Vigente')
                    ->first();

        //Datos de dosificacion
        $dosificacion = DosificacionesFactura::where('estado', 'Vigente')
                    ->first();

        //Datos del usuario logueado
        $user_id = Auth::user()->id;

        //Obtener Codigo de Control
        $facturador = new CodigoControlV7();
        $numero_autorizacion = $dosificacion->autorizacion_empresa;
        $numero_factura = $dosificacion->nit_empresa;
        $nit_cliente = $nit;
        $fecha_compra = $fecha_factura;
        $monto_compra = $total;
        $clave = $dosificacion->llave_dosificacion;
        $codigo_control = (CodigoControlV7::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, $monto_compra, $clave));

         //GUARDAR FACTURA
        $factura = new Factura();
        $factura->empresa_id        = $empresa->id;
        $factura->dosificacion_id   = $dosificacion->id;
        $factura->persona_id        = $persona_id;
        $factura->user_id           = $user_id;
        $factura->razon_social      = $razon_social_cliente;
        $factura->nit               = $nit;
        $factura->fecha             = $fecha;
        $factura->total             = $total;
        $factura->gestion           = $gestion;
        $factura->codigo_control    = $codigo_control;
        $factura->save();

        $factura_id = $factura->id;

        return response()->json([
            'factura_id' => $factura_id
        ]);


    }

    
}
