<?php

namespace App\Http\Controllers;

use App\Pago;
use App\User;
use DataTables;
use App\Factura;
use App\Persona;
use App\Servicio;
use App\Parametro;
use CodigoControlV7;
use App\CarrerasPersona;
use App\DescuentosPersona;
use App\Mail\EnvioFactura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use DOMDocument;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PharData;
// use Maatwebsite\Excel\Writer;
use SimpleXMLElement;
use SoapClient;


use SimpleSoftwareIO\QrCode\Facades\QrCode;

class FacturaController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function listadoPersonas()
    {
    	return view('factura.listadoPersonas');
    }

    public function ajaxListadoPersonas()
    {
        $estudiantes = Persona::get();
        //$estudiantes = Persona::select('id', 'apellido_paterno', 'apellido_materno', 'nombres', 'carnet', 'telefono_celular', 'razon_social_cliente', 'nit');
        return Datatables::of($estudiantes)
            ->addColumn('action', function ($estudiantes) {
                return '<button onclick="facturar('.$estudiantes->id.')" type="button" class="btn btn-info" title="Facturar"><i class="fas fa-eye"></i></button>';
            })
            ->make(true);
    }

    public function formularioFacturacion(Request $request)
    {
        $personas = Persona::limit(100)
                            ->orderBy('id', 'desc')
                            ->get();

        return view('factura.formularioFacturacion')->with(compact('personas'));
    }

    public function imprimeFactura()
    {
        return view('factura.imprimeFactura');
    }

    public function ajaxBuscaPersona(Request $request)
    {
        $buscaPersonas = Persona::limit(10);
        $cedula = $request->input('cedula');
        $apellido_paterno = $request->input('apellido_paterno');
        $apellido_materno = $request->input('apellido_materno');
        $nombres = $request->input('nombres');

        if($request->input('cedula') != null){
            $buscaPersonas->where('cedula', 'like', "%$cedula%" );
        }

        if($request->input('apellido_paterno') != null){
            $buscaPersonas->where('apellido_paterno', 'like', "%$apellido_paterno%");
        }

        if($request->input('apellido_materno') != null){
            $buscaPersonas->where('apellido_materno', 'like', "%$apellido_materno%");
        }

        if($request->input('nombres') != null){
            $buscaPersonas->where('nombres', 'like', "%$nombres%");
        }

        $personas = $buscaPersonas->get();

        return view('factura.ajaxBuscaPersona')->with(compact('personas'));

    }

    public function ajaxPersona(Request $request)
    {

        // session()->start();

        // dd(env(
        //     'SCUIS',
        //     'SFECHAVIGENCIACUIS',
        //     'SCUFD',
        //     'SCODIGOCONTROL',
        //     'SDIRECCION',
        //     'SFECHAVIGENCIACUFD'));


        $gestionActual = date('Y');

        $servicios = Servicio::get();

        $datosPersona = Persona::find($request->personaId);

        $inscripciones = CarrerasPersona::where('persona_id', $request->personaId)
                                        ->where('anio_vigente', $gestionActual)
                                        ->orderBy('id', 'asc')
                                        ->get();

        $descuentos = DescuentosPersona::where('persona_id', $request->personaId)
                                    ->where('anio_vigente', $gestionActual)
                                    ->get();

        $pagos = Pago::where('persona_id', $request->personaId)
                        // ->where('anio_vigente', $gestionActual)
                        ->get();

        $siguienteCuota = Pago::where('persona_id', $request->personaId)
                            ->where('anio_vigente', $gestionActual)
                            ->whereNull('estado')
                            ->orderBy('mensualidad', 'asc')
                            ->first();

        // para el siat LA CONECCION
        $siat = app(SiatController::class);
        $verificacionSiat = json_decode($siat->verificarComunicacion());

        // if($verificacionSiat->estado === "success"){

        //     $codigoCuis = json_decode($siat->cuis());
        //     if($codigoCuis->estado === "success"){
        //         $ser = $codigoCuis->resultado->RespuestaCuis->codigo;

        //         session(['scuis' => $codigoCuis->resultado->RespuestaCuis->codigo]);
        //         session(['sfechaVigenciaCuis' => $codigoCuis->resultado->RespuestaCuis->fechaVigencia]);

        //         // session()->put('scuis', $codigoCuis->resultado->RespuestaCuis->codigo);
        //         // session()->put('sfechaVigenciaCuis', $codigoCuis->resultado->RespuestaCuis->fechaVigencia);
        //     }

        //     // dd(session('scuis'));

        //     $arrayCufd =  array();

        //     // dd(session('scufd'));

        //     if(!session()->has('scufd')){

        //         $cufd = json_decode($siat->cufd());

        //         if($cufd->estado === "success"){
        //             if($cufd->resultado->RespuestaCufd->transaccion){

        //                 // session()->put('scufd', $cufd->resultado->RespuestaCufd->codigo);
        //                 // session()->put('scodigoControl', $cufd->resultado->RespuestaCufd->codigoControl);
        //                 // session()->put('sdireccion', $cufd->resultado->RespuestaCufd->direccion);
        //                 // session()->put('sfechaVigenciaCufd', $cufd->resultado->RespuestaCufd->fechaVigencia);

        //                 session(['scufd' => $cufd->resultado->RespuestaCufd->codigo]);
        //                 session(['scodigoControl' => $cufd->resultado->RespuestaCufd->codigoControl]);
        //                 session(['sdireccion' => $cufd->resultado->RespuestaCufd->direccion]);
        //                 session(['sfechaVigenciaCufd' => $cufd->resultado->RespuestaCufd->fechaVigencia]);

        //                 $arrayCufd['scufd']                 = $cufd->resultado->RespuestaCufd->codigo;
        //                 $arrayCufd['scodigoControl']        = $cufd->resultado->RespuestaCufd->codigoControl;
        //                 $arrayCufd['sdireccion']            = $cufd->resultado->RespuestaCufd->direccion;
        //                 $arrayCufd['sfechaVigenciaCufd']    = $cufd->resultado->RespuestaCufd->fechaVigencia;
        //                 $arrayCufd['estado'] = 'success1';
        //                 // $arrayCufd['estado'] = 'success1';

        //             }else{
        //                 $arrayCufd['estado'] = 'error1';
        //             }
        //         }else{
        //             $arrayCufd['estado'] = 'error2';
        //         }
        //     }else{
        //         $fechaVigencia = str_replace("T"," ",substr(session('sfechaVigenciaCufd'),0,16));

        //         if($fechaVigencia < date('Y-m-d H:i')){
        //             $cufd = json_decode($siat->cufd());

        //             if($cufd->estado === "success"){
        //                 if($cufd->resultado->RespuestaCufd->transaccion){

        //                     session(['scufd' => $cufd->resultado->RespuestaCufd->codigo]);
        //                     session(['scodigoControl' => $cufd->resultado->RespuestaCufd->codigoControl]);
        //                     session(['sdireccion' => $cufd->resultado->RespuestaCufd->direccion]);
        //                     session(['sfechaVigenciaCufd' => $cufd->resultado->RespuestaCufd->fechaVigencia]);

        //                     // session()->put('scufd', $cufd->resultado->RespuestaCufd->codigo);
        //                     // session()->put('scodigoControl', $cufd->resultado->RespuestaCufd->codigoControl);
        //                     // session()->put('sdireccion', $cufd->resultado->RespuestaCufd->direccion);
        //                     // session()->put('sfechaVigenciaCufd', $cufd->resultado->RespuestaCufd->fechaVigencia);

        //                     $arrayCufd['scufd']                 = $cufd->resultado->RespuestaCufd->codigo;
        //                     $arrayCufd['scodigoControl']        = $cufd->resultado->RespuestaCufd->codigoControl;
        //                     $arrayCufd['sdireccion']            = $cufd->resultado->RespuestaCufd->direccion;
        //                     $arrayCufd['sfechaVigenciaCufd']    = $cufd->resultado->RespuestaCufd->fechaVigencia;
        //                     $arrayCufd['estado']                = 'success2';

        //                 }else{
        //                     $arrayCufd['estado'] = 'error3';
        //                 }
        //             }else{
        //                 $arrayCufd['estado'] = 'error4';
        //             }
        //         }else{
        //             $arrayCufd['estado'] = 'success2';
        //             // $arrayCufd['estado'] = 'success3';
        //         }
        //     }


        // }

        // dd($arrayCufd);

        // session()->save();

        // dd(session()->all());

        // dd(!session()->has('scufd'), session('scufd'), $cufd);
        // echo $siat->verificarComunicacion();

        // return view('factura.ajaxPersona')->with(compact('datosPersona', 'inscripciones', 'descuentos', 'servicios', 'siguienteCuota', 'verificacionSiat', 'codigoCuis', 'arrayCufd'));
        return view('factura.ajaxPersona')->with(compact('datosPersona', 'inscripciones', 'descuentos', 'servicios', 'siguienteCuota', 'verificacionSiat'));
    }

    public function ajaxMuestraCuotasPagar(Request $request)
    {
        // dd($request->all());
        $gestionActual = date('Y');

        $paraPagar = Pago::where('persona_id', $request->persona_id)
                    ->where('carrera_id', 1)
                    ->where('anio_vigente', $gestionActual)
                    ->orderBy('mensualidad')
                    ->whereNull('estado')
                    ->limit($request->mensualidades_a_pagar)
                    ->get();

        // $jsonPagos = $paraPagar->toJson();

        $arrayPagos = [];

        foreach ($paraPagar as $key => $pp) {

            if($pp->descuento_persona_id == null){
                $descuento = 'NINGUNO';
            }else{
                $descuento = $pp->descuento->descuento->nombre;
            }

            $arrayPagos[] = [
                'id'         => $pp->id,
                'carrera_id' => $pp->carrera_id,
                'persona_id' => $pp->persona_id,
                'carrera'    => $pp->carrera->nombre,
                'pagar'      => $pp->a_pagar,
                'cuota'      => $pp->mensualidad,
                'descuento'  => $descuento,
            ];
        }

        $jsonPagos = json_encode($arrayPagos);

        return response()->json([
            'paraPagar' => $jsonPagos,
        ]);
    }

    public function guardaFactura(Request $request)
    {
        $fechaPago = date('Y-m-d');
        for ($i=0; $i < count($request->carrera_id); $i++) {
            // echo $request->carrera_id[$i]." - ".$request->cuota[$i]."<br />";
            $pago = Pago::find($request->pago_id[$i]);
            $pago->fecha = $fechaPago;
            $pago->estado = 'Pagado';
            $pago->save();
        }
        dd($request->all());
    }

    public function ajaxMuestraCuotaAPagar(Request $request)
    {
        $siguienteCuota = Pago::where('persona_id', $request->persona_id)
                        ->where('carrera_id', 1)
                        ->whereNull('estado')
                        ->orderBy('mensualidad', 'asc')
                        ->first();

        return view('factura.ajaxMuestraCuotaAPagar')->with(compact('siguienteCuota'));
    }

    public function ajaxAdicionaItem(Request $request)
    {
        $datosPago = Pago::find($request->pago_id);

        if($request->pago_parcial == 'parcial'){
            $faltante = $datosPago->a_pagar - $request->importe_pago;
            $estado = 'Parcial';
        }else{
            $faltante = 0;
            $estado = 'paraPagar';
        }
        // actualizamos los datos para mostrar en la tabla pagos
        $cuotaAPagar = Pago::find($request->pago_id);
        $cuotaAPagar->importe  = $request->importe_pago;
        $cuotaAPagar->faltante = $faltante;
        $cuotaAPagar->estado   = $estado;
        $cuotaAPagar->save();
    }

    public function generaRecibo(Request $request, $persona_id, $tipo)
    {
        // dd($tipo);
        $hoy = date('Y-m-d');
        // $reciboId = "";
        $persona = Persona::find($persona_id);

        $cuotasParaPagar = Pago::where('persona_id', $persona_id)
            ->where('estado', 'paraPagar')
            ->orWhere('estado', 'Parcial')
            ->get();

        // dd($cuotasParaPagar);
        // calculamos el monto total
        $total = 0;

        foreach ($cuotasParaPagar as $cp) {
            $total += $cp->importe;
            $anio = $cp->anio_vigente;
        }
        // fin de calcular el monto total

        // preguntamos si solo quieren recibo
        if($tipo == 'recibo'){

            $gestionNumero = date('Y');

            $ultimoRecibo = Factura::where('facturado', 'no')
                    ->where('anio_vigente', $gestionNumero)
                    ->orderBy('id', 'desc')
                    ->first();

            if ($ultimoRecibo) {
                $contadorRecibo = $ultimoRecibo->numero+1;
            } else {
                $contadorRecibo = 1;
            }

            $numeroRecibo = $contadorRecibo."/".$gestionNumero;

            // creamos el recibo en la tabla de facturas
            $recibo                = new Factura();
            $recibo->user_id       = Auth::user()->id;
            $recibo->persona_id    = $persona_id;
            $recibo->carnet        = $persona->cedula;
            $recibo->fecha         = $hoy;
            $recibo->total         = $total;
            $recibo->numero        = $contadorRecibo;
            $recibo->numero_recibo = $numeroRecibo;
            $recibo->anio_vigente  = date('Y');
            $recibo->facturado     = "No";
            $recibo->save();

            $reciboId = $recibo->id;

        // de lo contrario se generara factura
        }else{

            $ultimoParametro = Parametro::latest()
                                        ->first();

            if($ultimoParametro != null && $ultimoParametro->estado == 'Activo')
            {
                // tramemos los parametros de la facturacion
                $parametrosFactura = Parametro::where('estado', 'Activo')
                                    ->first();

                // obtenemos el ultimo numero de factura
                $ultimoNumeroFactura = Factura::latest()
                                        ->where('facturado', 'Si')
                                        ->first();

                // preguntamos si el numero de fatura sera
                // de la tabla facturas
                if($ultimoNumeroFactura == null){
                    $nuevoNumeroFactura = $parametrosFactura->numero_factura;
                }else{
                    $nuevoNumeroFactura = $ultimoNumeroFactura->numero+1;
                }

                // traemos datos del cliente
                $datosPersona = Persona::find($persona_id);

                // enviamos los datos para generar el codigo controller
                $fechaParaCodigo = str_replace("-", "", $hoy);

                // generamos el codigo de control
                $facturador          = new CodigoControlV7();
                $numero_autorizacion = $parametrosFactura->numero_autorizacion;
                $numero_factura      = $nuevoNumeroFactura;
                $nit_cliente         = $datosPersona->nit;
                $fecha_compra        = $fechaParaCodigo;
                $monto_compra        = round($total, 0, PHP_ROUND_HALF_UP);
                $clave               = $parametrosFactura->llave_dosificacion;
                $codigoControl       = $facturador::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, $monto_compra, $clave);

                // creamos la factura en la tabla de facturas
                $factura                 = new Factura();
                $factura->user_id        = Auth::user()->id;
                $factura->persona_id     = $persona_id;
                $factura->parametro_id   = $ultimoParametro->id;
                $factura->carnet         = $persona->cedula;
                $factura->fecha          = $hoy;
                $factura->total          = $total;
                $factura->numero         = $nuevoNumeroFactura;
                $factura->nit            = $datosPersona->nit;
                $factura->razon_social   = $datosPersona->razon_social_cliente;
                $factura->anio_vigente   = date('Y');
                $factura->codigo_control = $codigoControl;
                $factura->facturado      = "Si";
                $factura->save();

                $reciboId = $factura->id;

            }

        }

        $cuotasParaModificar = Pago::where('persona_id', $persona_id)
            ->where('estado', 'paraPagar')
            ->orWhere('estado', 'Parcial')
            ->get();


        foreach ($cuotasParaModificar as $cm)
        {
            if($cm->estado == 'paraPagar'){
                $estado = 'Pagado';
            }else{
                $estado = null;
            }
            $cuotasPagadas             = Pago::find($cm->id);
            $cuotasPagadas->user_id    = Auth::user()->id;
            $cuotasPagadas->estado     = $estado;
            $cuotasPagadas->fecha      = $hoy;
            $cuotasPagadas->factura_id = $reciboId;
            $cuotasPagadas->save();
        }

        if($tipo == 'recibo'){
            return redirect("Factura/muestraRecibo/$reciboId");
        }else{
            return redirect("Factura/muestraFactura/$reciboId");
        }
    }

    public function ajaxEliminaItemPago(Request $request)
    {
        // actualizamos el estado del item a pagar
        $cuotaEliminar = Pago::find($request->pago_id);
        $cuotaEliminar->descuento = 0;
        $cuotaEliminar->subTotal = 0;
        $cuotaEliminar->estado = null;
        $cuotaEliminar->save();
    }

    public function muestraRecibo(Request $request, $recibo_id)
    {
        $cuotasPagadas = Pago::where('factura_id', $recibo_id)
                            ->get();
                            // dd($recibo_id);
        // $cuotasPagadas = Factura::find($recibo_id);

        return view('factura.generaRecibo')->with(compact('cuotasPagadas'));
    }

    public function muestraFactura(Request $request, $recibo_id)
    {
        $cuotasPagadas = Pago::where('factura_id', $recibo_id)
                            ->get();

        $factura = Factura::find($cuotasPagadas[0]->factura_id);

        $parametros = Parametro::find($factura->parametro_id);

        return view('factura.generaFactura')->with(compact('cuotasPagadas', 'factura', 'parametros'));
        // return view('factura.generaFactura')->with(compact('cuotasPagadas', 'factura'));
    }

    public function ajaxMuestraTablaPagos(Request $request)
    {
        $persona_id = $request->persona_id;
        $persona = Persona::find($request->persona_id);
        // mostramos las cuotas para pagar
        // $cuotasParaPagar = Pago::where('persona_id', $request->persona_id)
        //                         ->where('estado', 'paraPagar')
        //                         ->orWhere('estado', 'Parcial')
        //                         ->orderBy('carrera_id', 'asc')
        //                         ->get();

        $cuotasParaPagar = Pago::select('pagos.*', 'servicios.codigoActividad', 'servicios.codigoProducto', 'servicios.unidadMedida', 'servicios.nombre')
                                ->join('servicios', 'pagos.servicio_id', '=','servicios.id')
                                ->where('pagos.persona_id', $request->persona_id)
                                ->where('pagos.estado', 'paraPagar')
                                ->orWhere('pagos.estado', 'Parcial')
                                ->orderBy('pagos.carrera_id', 'asc')
                                ->get();

        // extraemos la ultima cuota para eliminar de la tabla
        $ultimaCuota = Pago::where('persona_id', $request->persona_id)
                        ->where('estado', 'paraPagar')
                        ->orWhere('estado', 'Parcial')
                        ->orderBy('id', 'desc')
                        ->first();

        // SACAMOS LA ULTIMA FACTURA
        $ultimaFactura = $this->getUltimoFactura();

        // dd($ultimaFactura);

        return view('factura.ajaxMuestraTablaPagos')->with(compact('persona_id', 'cuotasParaPagar', 'ultimaCuota', 'persona', 'ultimaFactura'));
    }

    public function ajaxPreciosServicios(Request $request)
    {
        $preciosServicios = Servicio::find($request->servicio_id);
        $persona = Persona::find($request->persona_id);

        return view('factura.ajaxPreciosServicios')->with(compact('preciosServicios', 'persona'));
    }

    public function ajaxAdicionaItemServicio(Request $request)
    {
        // actualizamos los datos para mostrar en la tabla pagos
        $cuotaAPagar               = new Pago();
        $cuotaAPagar->user_id      = Auth::user()->id;
        $cuotaAPagar->persona_id   = $request->persona_id;
        $cuotaAPagar->servicio_id  = $request->servicio_id;
        $cuotaAPagar->importe      = $request->importe;
        $cuotaAPagar->anio_vigente = date('Y');
        $cuotaAPagar->estado       = 'paraPagar';

        $cuotaAPagar->save();
    }

    public function ajaxEliminaItemPagoServicio(Request $request)
    {

        // dd($request->pago_id);

        Pago::destroy($request->pago_id);
    }

    public function guardaNitCliente(Request $request)
    {
        $persona                       = Persona::find($request->persona_id);
        $persona->nit                  = $request->nit_factura;
        $persona->razon_social_cliente = $request->razon_factura;
        $persona->save();

        return redirect("Factura/generaRecibo/$request->persona_id/factura");

    }

    // esta es la funcion para hacer el listado de los
    // pagos para el listado de pagos
    public function listadoPagos(Request $request)
    {
        $facturas = Factura::limit(100)
                    ->orderBy('id', 'desc')
                    ->get();

        $personal = array();

        $usuarios = Factura::groupBy('user_id')
                            ->get();

        return view('factura.listadoPagos')->with(compact('facturas', 'usuarios'));
    }

    // esta funcion es para el listado de
    //
    public function ajaxBuscaPago(Request $request)
    {
        // dd($request->all());
        $pagos = Factura::orderBy('id', 'desc');

        if($request->input('numero') != null){
            $pagos->where('numero', $request->input('numero'));
        }

        if($request->input('numero_recibo') != null){
            $pagos->where('numero_recibo', $request->input('numero_recibo'));
        }

        if($request->input('ci') != null){
            $pagos->where('carnet', $request->input('ci'));
        }

        if($request->input('nit') != null){
            $pagos->where('nit', $request->input('nit'));
        }

        if($request->input('user_id') != null){
            $pagos->where('user_id', $request->input('user_id'));
        }

        if($request->input('fecha_inicio') != null){
            // $pagos->whereBetween('fecha', [$request->input('fecha_inicio'), $request->input('fecha_final')]);
            $pagos->whereDate('fecha', '>=',  $request->input('fecha_inicio'));
        }

        if($request->input('fecha_final') != null){
            $pagos->whereDate('fecha', '<=',  $request->input('fecha_final'));
        }

        if($request->input('numero') == null && $request->input('ci') == null && $request->input('nit') == null && $request->input('user_id') == null && $request->input('fecha_inicio') == null && $request->input('fecha_final') == null){
            $pagos->limit(100);
        }

        $cobros = $pagos->get();
        // dd($cobros);
        return view('factura.ajaxBuscaPago')->with(compact('cobros'));
    }

    public function anulaFactura(Request $request, $factura_id)
    {
        // dd($);
        $factura = Factura::find($factura_id);
        $factura->estado = 'Anulado';
        $factura->save();

        $pagos = Pago::where('factura_id', $factura_id)
                    ->get();

        foreach($pagos as $p)
        {
            if($p->servicio_id == 2){
                $ePago           = Pago::find($p->id);
                $ePago->factura_id  = null;
                $ePago->importe  = 0;
                $ePago->faltante = 0;
                $ePago->fecha    = null;
                $ePago->estado   = null;
                $ePago->save();
            }else{
                Pago::destroy($p->id);
            }
        }

        return redirect("Factura/listadoPagos");
    }

    public function generaPdfPagos(Request $request)
    {
        $pagos = Factura::orderBy('id', 'desc');

        $numero = $request->input('numero');
        $numero_recibo = $request->input('numero_recibo');
        $ci = $request->input('ci');
        $nit = $request->input('nit');
        $user_id = $request->input('user_id');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_final = $request->input('fecha_final');

        if($request->input('numero') != null){
            $pagos->where('numero', $request->input('numero'));
        }

        if($request->input('numero_recibo') != null){
            $pagos->where('numero_recibo', $request->input('numero_recibo'));
        }

        if($request->input('ci') != null){
            $pagos->where('carnet', $request->input('ci'));
        }

        if($request->input('nit') != null){
            $pagos->where('nit', $request->input('nit'));
        }

        if($request->input('user_id') != null){
            $pagos->where('user_id', $request->input('user_id'));
        }

        if($request->input('fecha_inicio') != null){
            // $pagos->whereBetween('fecha', [$request->input('fecha_inicio'), $request->input('fecha_final')]);
            $pagos->whereDate('fecha', '>=',  $request->input('fecha_inicio'));
        }

        if($request->input('fecha_final') != null){
            $pagos->whereDate('fecha', '<=',  $request->input('fecha_final'));
        }

        $pagos->whereNull('estado');

        if($request->input('numero') == null && $request->input('ci') == null && $request->input('nit') == null && $request->input('user_id') == null && $request->input('fecha_inicio') == null && $request->input('fecha_final') == null){
            $pagos->limit(100);
        }

        $cobros = $pagos->get();

        // return view('factura.ajaxBuscaPago')->with(compact('cobros'));
        $pdf = PDF::loadView('pdf.generaPagos', compact('cobros', 'numero', 'numero_recibo', 'ci', 'nit', 'user_id', 'fecha_inicio', 'fecha_final'))->setPaper('letter');
        return $pdf->stream('pagos.pdf');

    }

    // listamos los pagos con respectivos Servicios
    public function listadoPagosServicio(){

        $pagos = Pago::limit(100)
                    ->orderBy('id', 'desc')
                    ->get();

        $personal = array();

        $usuarios = Factura::groupBy('user_id')
                            ->get();

        return view('factura.listadoPagosServicio')->with(compact('pagos', 'usuarios'));
    }

    protected function getUltimoFactura(){

        $ultimoNumeroFactura = Factura::latest()
                                    ->where('facturado', 'Si')
                                    ->first();

        return $ultimoNumeroFactura;

    }

    // FACTURACION EN LINEA
    public function emitirFactura(Request $request){

        // dd("este chee");

        $datos              = $request->input('datos');
        $datosPersona       = $request->input('datosPersona');
        $valoresCabecera    = $datos['factura'][0]['cabecera'];

        $nitEmisor          = str_pad($valoresCabecera['nitEmisor'],13,"0",STR_PAD_LEFT);
        $fechaEmision       = str_replace(".","",str_replace(":","",str_replace("-","",str_replace("T", "",$valoresCabecera['fechaEmision']))));
        $sucursal           = str_pad(0,4,"0",STR_PAD_LEFT);
        $modalidad          = 2;
        $tipoEmision        = 1;
        $tipoFactura        = 1;
        $tipoFacturaSector  = 11;
        $numeroFactura      = str_pad($valoresCabecera['numeroFactura'],10,"0",STR_PAD_LEFT);
        $puntoVenta         = str_pad(0,4,"0",STR_PAD_LEFT);
        // $puntoVenta         = str_pad(1,4,"0",STR_PAD_LEFT);
        // $puntoVenta         = str_pad(3,4,"0",STR_PAD_LEFT);

        // dd($puntoVenta, $datos);

        $cadena = $nitEmisor.$fechaEmision.$sucursal.$modalidad.$tipoEmision.$tipoFactura.$tipoFacturaSector.$numeroFactura.$puntoVenta;

        $tipo_factura = $request->input('modalidad');

        // CODIGO DEL VIDEO PARACE QUE SIRVE NOMAS
        // ini_set('soap.wsdl_cache_enable',0);
        // $wdls = "https://indexingenieria.com/webservices/wssiatcuf.php?wsdl";
        // $client = new SoapClient($wdls);
        // $client->__getFunctions();
        // $params = array(
        //     'factura_numero' => $numeroFactura,
        //     'nit_emisor' => $nitEmisor,
        //     'fechaEmision' => $valoresCabecera['fechaEmision'],
        //     'codigoControl' => session('scodigoControl')
        // );
        // $cuf = $client->__soapCall('generaCuf', $params);
        // $datos['factura'][0]['cabecera']['cuf'] = $cuf;

        // CODIGO DE JOEL ESETE LO HIZMOMOS NOSOTROS
        $cadenaConM11 = $cadena.$this->calculaDigitoMod11($cadena, 1, 9, false);
        if($tipo_factura === "online"){
            if(!session()->has('scufd')){
                $siat = app(SiatController::class);
                $siat->verificarConeccion();
            }
            $scufd                  = session('scufd');
            $scodigoControl         = session('scodigoControl');
            $sdireccion             = session('sdireccion');
            $sfechaVigenciaCufd     = session('sfechaVigenciaCufd');
        }else{
            $cufdController             = app(CufdController::class);
            $datosCufdOffLine           = $cufdController->sacarCufdVigenteFueraLinea();
            if($datosCufdOffLine['estado'] === "success"){
                $scufd                  = $datosCufdOffLine['scufd'];
                $scodigoControl         = $datosCufdOffLine['scodigoControl'];
                $sdireccion             = $datosCufdOffLine['sdireccion'];
                $sfechaVigenciaCufd     = $datosCufdOffLine['sfechaVigenciaCufd'];
            }else{

            }
        }

        $cufPro                                         = $this->generarBase16($cadenaConM11).$scodigoControl;

        // dd($cufPro, $scodigoControl, $this->generarBase16($cadenaConM11), $cadenaConM11);

        $datos['factura'][0]['cabecera']['cuf']         = $cufPro;
        $datos['factura'][0]['cabecera']['cufd']        = $scufd;
        $datos['factura'][0]['cabecera']['direccion']   = $sdireccion;

        // $datos['factura'][0]['cabecera']['codigoPuntoVenta']    = 3;
        // $datos['factura'][0]['cabecera']['codigoPuntoVenta']    = 1;

        // dd($datos['factura']);

        // VERIFICAMOS QUE SEA MENSUALIDAD
        for ($i=1; $i < count($datos['factura']); $i++) {
            if($datos['factura'][$i]['detalle']['codigoProducto'] != 2){
                $g = explode(' ', $datos['factura'][$i]['detalle']['descripcion']);
                $datos['factura'][$i]['detalle']['descripcion'] = $g[1];
            }
        }

        // VERIFICAMOS EN EL PERIDOD
        $periodo = explode(' ', $datos['factura'][0]['cabecera']['periodoFacturado']);
        if(array_intersect(["null","undefined"],$periodo))
            $datos['factura'][0]['cabecera']['periodoFacturado'] = $periodo[1];


        $temporal = $datos['factura'];
        $dar = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                    <facturaComputarizadaSectorEducativo xsi:noNamespaceSchemaLocation="facturaComputarizadaSectorEducativo.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></facturaComputarizadaSectorEducativo>';
        $xml_temporal = new SimpleXMLElement($dar);
        $this->formato_xml($temporal, $xml_temporal);

        $xml_temporal->asXML("assets/docs/facturaxml.xml");

        // COMPRIMIMOS EL ARCHIVO A ZIP
        $gzdato = gzencode(file_get_contents('assets/docs/facturaxml.xml',9));
        $fiape = fopen('assets/docs/facturaxml.xml.zip',"w");
        fwrite($fiape,$gzdato);
        fclose($fiape);

        //  hashArchivo EL ARCHIVO
        $archivoZip = $gzdato;
        $hashArchivo = hash("sha256", file_get_contents('assets/docs/facturaxml.xml'));

        // GUARDAMOS EN LA FACTURA
        // dd($datos['factura'][0]['cabecera']['nombreRazonSocial']);

        $factura = new Factura();

        $factura->user_id                   = Auth::user()->id;
        $factura->persona_id                = $datosPersona['persona_id'];
        $factura->carnet                    = $datosPersona['carnet'];
        $factura->razon_social              = $datos['factura'][0]['cabecera']['nombreRazonSocial'];
        $factura->nit                       = $datos['factura'][0]['cabecera']['numeroDocumento'];
        $factura->fecha                     = $datos['factura'][0]['cabecera']['fechaEmision'];
        $factura->total                     = $datos['factura'][0]['cabecera']['montoTotal'];
        $factura->facturado                 = "Si";
        $factura->numero                    = $datos['factura'][0]['cabecera']['numeroFactura'];
        $factura->anio_vigente              = date('Y');
        $factura->cuf                       = $datos['factura'][0]['cabecera']['cuf'];
        $factura->codigo_metodo_pago_siat   = $datos['factura'][0]['cabecera']['codigoMetodoPago'];
        $factura->monto_total_subjeto_iva   = $datos['factura'][0]['cabecera']['montoTotalSujetoIva'];
        $factura->descuento_adicional       = $datos['factura'][0]['cabecera']['descuentoAdicional'];
        $factura->productos_xml             = file_get_contents('assets/docs/facturaxml.xml');
        $factura->tipo_factura              = $tipo_factura;

        $factura->save();


        // ENVIAMOS EL CORREO DE LA FACTURA
        $this->enviaCorreo('jjjoelcito123@gmail.com',$factura->id);


        if($tipo_factura === "online"){
            $siat = app(SiatController::class);
            $for = json_decode($siat->recepcionFactura($archivoZip, $valoresCabecera['fechaEmision'],$hashArchivo));

            if($for->estado === "error"){
                $codigo_descripcion = null;
                $codigo_trancaccion = null;
                $descripcion        = null;
                $codigo_recepcion   = null;
            }else{
                if($for->resultado->RespuestaServicioFacturacion->transaccion){
                    $codigo_recepcion = $for->resultado->RespuestaServicioFacturacion->codigoRecepcion;
                    $descripcion = NULL;
                }else{
                    $codigo_recepcion = NULL;
                    $descripcion = $for->resultado->RespuestaServicioFacturacion->mensajesList->descripcion;
                }
                $codigo_descripcion = $for->resultado->RespuestaServicioFacturacion->codigoDescripcion;
                $codigo_trancaccion = $for->resultado->RespuestaServicioFacturacion->transaccion;
            }
        }else{
            $codigo_descripcion = null;
            $codigo_recepcion   = null;
            $codigo_trancaccion = null;
            $descripcion        = null;
        }

        // $siat = app(SiatController::class);
        // $for = json_decode($siat->recepcionFactura($archivoZip, $valoresCabecera['fechaEmision'],$hashArchivo));

        // if($for->estado === "error"){
        //     $codigo_descripcion = null;
        //     $codigo_trancaccion = null;
        //     $descripcion        = null;
        //     $codigo_recepcion   = null;
        // }else{
        //     if($for->resultado->RespuestaServicioFacturacion->transaccion){
        //         $codigo_recepcion = $for->resultado->RespuestaServicioFacturacion->codigoRecepcion;
        //         $descripcion = NULL;
        //     }else{
        //         $codigo_recepcion = NULL;
        //         $descripcion = $for->resultado->RespuestaServicioFacturacion->mensajesList->descripcion;
        //     }
        //     $codigo_descripcion = $for->resultado->RespuestaServicioFacturacion->codigoDescripcion;
        //     $codigo_trancaccion = $for->resultado->RespuestaServicioFacturacion->transaccion;
        // }

        $facturaNew                     = Factura::find($factura->id);
        $facturaNew->codigo_descripcion = $codigo_descripcion;
        $facturaNew->codigo_recepcion   = $codigo_recepcion;
        $facturaNew->codigo_trancaccion = $codigo_trancaccion;
        $facturaNew->descripcion        = $descripcion;
        // $facturaNew->cuis               = session('scuis');
        // $facturaNew->cufd               = session('scufd');
        // $facturaNew->fechaVigencia      = session('sfechaVigenciaCufd');
        $facturaNew->cuis               = session('scuis');
        $facturaNew->cufd               = $scufd;
        $facturaNew->fechaVigencia      = $sfechaVigenciaCufd;
        $facturaNew->save();

        $data['estado'] = $facturaNew->codigo_descripcion;

        for ($i=1; $i < count($datos['factura']) ; $i++) {

            $servicio = $datos['factura'][$i]['detalle']['codigoProducto'];

            // PREGUNTAMOS SI ES MENSUALIDAD
            if($servicio === "2"){
                $arrayMen = explode(" ", $datos['factura'][$i]['detalle']['descripcion']);
                $pago = Pago::where('persona_id',$datosPersona['persona_id'])
                            ->where('estado', 'paraPagar')
                            ->where('anio_vigente', date('Y'))
                            ->where('mensualidad', $arrayMen[0])
                            ->first();

                if($pago){
                    $pago->descuento    = ($datos['factura'][$i]['detalle']['montoDescuento'] == null)? 0 :  $datos['factura'][$i]['detalle']['montoDescuento'];
                    $pago->subTotal     = ($datos['factura'][$i]['detalle']['subTotal'] == null)? 0 :  $datos['factura'][$i]['detalle']['subTotal'];
                    $pago->estado       = "Pagado";
                    $pago->fecha        = $valoresCabecera['fechaEmision'];
                    $pago->factura_id   = $facturaNew->id;
                    $pago->user_id      = Auth::user()->id;
                    // $pago->cuis         = session('scuis');
                    // $pago->cufd         = session('scufd');
                    // $pago->fechaVigencia= session('sfechaVigenciaCufd');

                    $pago->save();
                }
            }else{
                $pago = Pago::where('persona_id',$datosPersona['persona_id'])
                            ->where('estado', 'paraPagar')
                            ->where('anio_vigente', date('Y'))
                            ->where('servicio_id', $servicio)
                            ->first();

                if($pago){
                    $pago->descuento    = ($datos['factura'][$i]['detalle']['montoDescuento'] == null)? 0 :  $datos['factura'][$i]['detalle']['montoDescuento'];
                    $pago->subTotal     = ($datos['factura'][$i]['detalle']['subTotal'] == null)? 0 :  $datos['factura'][$i]['detalle']['subTotal'];
                    $pago->estado       = "Pagado";
                    $pago->fecha        = $valoresCabecera['fechaEmision'];
                    $pago->factura_id   = $facturaNew->id;
                    $pago->user_id      = Auth::user()->id;
                    // $pago->cuis         = session('scuis');
                    // $pago->cufd         = session('scufd');
                    // $pago->fechaVigencia= session('sfechaVigenciaCufd');

                    $pago->save();
                }
            }

        }



        // PARA VALIDAR EL XML
        // $this->validar();

        return $data;
    }


    // RECEPCION FACTURA FEURA DE LINEA
    public function recepcionFacturaFueraLinea(Request $request){

        if($request->ajax()){
            $factura_id                     = $request->input('factura_id_contingencia');
            $codigo_evento_significativo    = $request->input('evento_significativo_contingencia_select');
            $codigo_cafc_contingencia       = $request->input('codigo_cafc_contingencia');
            $siat = app(SiatController::class);
            $factura = Factura::find($factura_id);
            $xml = $factura['productos_xml'];

            $fechaActual = date('Y-m-d\TH:i:s.v');
            $fechaEmicion = $fechaActual;
            $archivoXML = new SimpleXMLElement($xml);

            // GUARDAMOS EN LA CARPETA EL XML
            $archivoXML->asXML("assets/docs/paquete/facturaxmlContingencia.xml");

            // Ruta de la carpeta que deseas comprimir
            $rutaCarpeta = "assets/docs/paquete";

            // Nombre y ruta del archivo TAR resultante
            $archivoTar = "assets/docs/paquete.tar";

            // Crear el archivo TAR utilizando la biblioteca PharData
            $tar = new PharData($archivoTar);
            $tar->buildFromDirectory($rutaCarpeta);

            // Ruta y nombre del archivo comprimido en formato Gzip
            $archivoGzip = "assets/docs/paquete.tar.gz";

            // Comprimir el archivo TAR en formato Gzip
            $comandoGzip = "gzip -c $archivoTar > $archivoGzip";
            exec($comandoGzip);

            // Leer el contenido del archivo comprimido
            $contenidoArchivo = file_get_contents($archivoGzip);

            // Calcular el HASH (SHA256) del contenido del archivo
            $hashArchivo = hash('sha256', $contenidoArchivo);

            $res = json_decode($siat->recepcionPaqueteFactura($contenidoArchivo, $fechaEmicion, $hashArchivo, $codigo_cafc_contingencia, 1, $codigo_evento_significativo));
            // $res = json_decode($siat->recepcionPaqueteFactura($contenidoArchivo, $fechaEmicion, $hashArchivo, NULL, 1, $codigo_evento_significativo));
            $data['estado'] = "success";
            // dd($res);
            // if($res->estado === "success"){
            if($res->resultado->RespuestaServicioFacturacion->transaccion){
                $data['descripcion']                = $res->resultado->RespuestaServicioFacturacion->codigoDescripcion;
                $data['codRecepcion']               = $res->resultado->RespuestaServicioFacturacion->codigoRecepcion;
                if($res->resultado->RespuestaServicioFacturacion->transaccion){
                    $factura->codigo_descripcion    = $res->resultado->RespuestaServicioFacturacion->codigoDescripcion;
                    $factura->codigo_recepcion      = $res->resultado->RespuestaServicioFacturacion->codigoRecepcion;
                    $factura->codigo_trancaccion    = $res->resultado->RespuestaServicioFacturacion->transaccion;
                    $factura->save();
                    $respVali = json_decode($siat->validacionRecepcionPaqueteFactura(2,$factura->codigo_recepcion));
                    if($respVali->estado === "success"){
                        if($respVali->resultado->RespuestaServicioFacturacion->transaccion){
                            $factura->codigo_descripcion    = $respVali->resultado->RespuestaServicioFacturacion->codigoDescripcion;
                            if($respVali->resultado->RespuestaServicioFacturacion->codigoDescripcion != 'VALIDADA')
                                $factura->descripcion       = json_encode($respVali->resultado->RespuestaServicioFacturacion->mensajesList);
                        }else{

                        }
                        $factura->save();
                    }else{

                    }
                }
            }else{
                $data['estado'] = "error";
            }
        }else{
            $data['estado'] = "error";
        }
        return $data;
    }

    protected function formato_xml($temporal, $xml_temporal){
        $ns_xsi = "http://www.w3.org/2001/XMLSchema-instance";
        foreach($temporal as $key => $value){
            if(is_array($value)){
                if(!is_numeric($key)){
                    $subnodo = $xml_temporal->addChild("$key");
                    $this->formato_xml($value, $subnodo);
                }else{
                    $this->formato_xml($value, $xml_temporal);
                }
            }else{
                if($value == null && $value <> '0'){
                    $hijo = $xml_temporal->addChild("$key","$value");
                    $hijo->addAttribute('xsi:nil','true', $ns_xsi);
                }else{
                    $xml_temporal->addChild("$key", "$value");
                }
            }
        }
    }

    public function actualizaDescuento(Request $request){
        if($request->ajax()){

            $pago = Pago::find($request->input('pago_id'));
            $pago->descuento = $request->input('valor');
            $pago->subTotal = $pago->importe - $request->input('valor');
            $pago->save();

            $persona_id = $pago->persona_id;

            $sumaImporte = Pago::where('estado','paraPagar')
                                ->where('persona_id',$persona_id)
                                ->sum('importe');
            $sumaRebaja = Pago::where('estado','paraPagar')
                                ->where('persona_id',$persona_id)
                                ->sum('descuento');

            $data['valor'] = ($sumaImporte-$sumaRebaja);
            $data['estado'] = 'success';

        }else{
            $data['estado'] = 'error';
        }

        return $data;
    }

    public function arrayCuotasPagar(Request $request){

        if($request->ajax()){
            $persona_id = $request->input('persona');
            $cuotasParaPagar = Pago::select('pagos.*', 'servicios.codigoActividad', 'servicios.codigoProducto', 'servicios.unidadMedida', 'servicios.nombre')
                                    ->join('servicios', 'pagos.servicio_id', '=','servicios.id')
                                    ->where('pagos.persona_id', $persona_id)
                                    ->where('pagos.estado', 'paraPagar')
                                    ->orWhere('pagos.estado', 'Parcial')
                                    ->orderBy('pagos.carrera_id', 'asc')
                                    ->get();
            $data['estado'] = 'success';
            $data['lista'] = json_encode($cuotasParaPagar);
        }else{
            $data['estado'] = 'error';
        }
        return $data;
    }

    public function sumaTotalMonto(Request $request){
        if($request->ajax()){

            $persona_id = $request->input('persona');

            $sumaImporte = Pago::where('estado','paraPagar')
                                ->where('persona_id',$persona_id)
                                ->sum('importe');
            $sumaRebaja = Pago::where('estado','paraPagar')
                                ->where('persona_id',$persona_id)
                                ->sum('descuento');

            $data['valor'] = ($sumaImporte-$sumaRebaja);
        }

        return $data;
    }

    protected function calculaDigitoMod11($cadena, $numDig, $limMult, $x10){

        $mult = 0;
        $suma = 0;
        $dig = 0;
        $i = 0;
        $n = 0;

        if (!$x10) {
            $numDig = 1;
        }

        for ($n = 1; $n <= $numDig; $n++) {
            $suma = 0;
            $mult = 2;

            for ($i = strlen($cadena) - 1; $i >= 0; $i--) {
                $suma += ($mult * intval(substr($cadena, $i, 1)));

                if (++$mult > $limMult) {
                    $mult = 2;
                }
            }

            if ($x10) {
                $dig = (($suma * 10) % 11) % 10;
            } else {
                $dig = $suma % 11;
            }

            if ($dig == 10) {
                $cadena .= "1";
            }

            if ($dig == 11) {
                $cadena .= "0";
            }

            if ($dig < 10) {
                $cadena .= strval($dig);
            }
        }

        return substr($cadena, strlen($cadena) - $numDig, $numDig);
    }

    protected function generarBase16($caracteres) {
        $pString = ltrim($caracteres, '0');
        $vValor = gmp_init($pString);
        return strtoupper(gmp_strval($vValor, 16));
    }

    protected function base10($datos){
        return number_format(hexdec($datos), 0, '', '');
    }

    protected function validar(){
        // Ruta del archivo XML a validar
        $xmlFile = "assets/docs/facturaxml.xml";

        // Ruta del archivo XSD
        $xsdFile = "assets/docs/facturaComputarizadaSectorEducativo.xsd";

        // dd($xmlFile, $xsdFile);

        // Cargar el archivo XML
        $dom = new DOMDocument();
        $dom->load($xmlFile);

        // dd($dom);

        // Habilitar la validación contra el XSD
        $dom->schemaValidate($xsdFile);

        // Verificar si hay errores de validación
        $errors = libxml_get_errors();

        if (empty($errors)) {
            echo "El archivo XML es válido.";
        } else {
            foreach ($errors as $error) {
                echo "Error de validación: " . $error->message . "\n";
            }
        }
    }

    public function generaPdfFacturaNew(Request $request, $factura_id){
        $factura = Factura::find($factura_id);
        $xml = $factura['productos_xml'];

        $archivoXML = new SimpleXMLElement($xml);

        $cabeza = (array) $archivoXML;

        $cuf            = (string)$cabeza['cabecera']->cuf;
        $numeroFactura  = (string)$cabeza['cabecera']->numeroFactura;

        // Genera el texto para el código QR
        $textoQR = 'https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=178436029&cuf='.$cuf.'&numero='.$numeroFactura.'&t=2';
        // Genera la ruta temporal para guardar la imagen del código QR
        $rutaImagenQR = storage_path('app/public/qr_code.png');
        // Genera el código QR y guarda la imagen en la ruta temporal
        QrCode::generate($textoQR, $rutaImagenQR);

        $pdf = PDF::loadView('pdf.generaPdfFacturaNew', compact('factura', 'archivoXML','rutaImagenQR'))->setPaper('letter');
        // unlink($rutaImagenQR);
        return $pdf->stream('factura.pdf');
    }

    protected function generaPdfFacturaNewSave(Request $request, $factura_id){
        $factura = Factura::find($factura_id);
        $xml = $factura['productos_xml'];

        $archivoXML = new SimpleXMLElement($xml);

        $cabeza = (array) $archivoXML;

        $cuf            = (string)$cabeza['cabecera']->cuf;
        $numeroFactura  = (string)$cabeza['cabecera']->numeroFactura;

        // Genera el texto para el código QR
        $textoQR = 'https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=178436029&cuf='.$cuf.'&numero='.$numeroFactura.'&t=2';
        // Genera la ruta temporal para guardar la imagen del código QR
        $rutaImagenQR = storage_path('app/public/qr_code.png');
        // Genera el código QR y guarda la imagen en la ruta temporal
        QrCode::generate($textoQR, $rutaImagenQR);

        $pdf = PDF::loadView('pdf.generaPdfFacturaNew', compact('factura', 'archivoXML','rutaImagenQR'))->setPaper('letter');
        // unlink($rutaImagenQR);
        return $pdf->stream('factura.pdf');
    }

    public function anularFacturaNew(Request $request){
        if($request->ajax()){

            $idFactura = $request->input('factura');
            $moivo = $request->input('moivo');
            $fatura = Factura::find($idFactura);

            // dd($idFactura,$moivo,$fatura, session()->all());

            $siat = app(SiatController::class);

            $respuesta = json_decode($siat->anulacionFactura($moivo, $fatura->cuf));

            // dd($respuesta, session()->all());

            if($respuesta->resultado->RespuestaServicioFacturacion->transaccion){
                $fatura->estado = 'Anulado';
                $pagos = Pago::where('factura_id', $fatura->id)
                                ->get();
                foreach($pagos as $p){
                    if($p->servicio_id == 2){
                        $ePago              = Pago::find($p->id);
                        $ePago->factura_id  = null;
                        $ePago->importe     = 0;
                        $ePago->faltante    = 0;
                        $ePago->fecha       = null;
                        $ePago->estado      = null;
                        $ePago->save();
                    }else{
                        Pago::destroy($p->id);
                    }
                }
            }else{
                $fatura->descripcion = $respuesta->resultado->RespuestaServicioFacturacion->mensajesList->descripcion;
            }

            // dd($fatura);

            $data['estado'] = $respuesta->resultado->RespuestaServicioFacturacion->transaccion;
            $data['descripcion'] = $respuesta->resultado->RespuestaServicioFacturacion->codigoDescripcion;

            $fatura->save();

            // dd($data);

            return $data;
        }
    }

    // protected function verificarConeccion(){
    //     // PARA LA CONNECCION
    //     $siat = app(SiatController::class);
    //     $verificacionSiat = json_decode($siat->verificarComunicacion());
    //     if($verificacionSiat->estado === "success"){
    //         $codigoCuis = json_decode($siat->cuis());
    //         if($codigoCuis->estado === "success"){
    //             session(['scuis' => $codigoCuis->resultado->RespuestaCuis->codigo]);
    //             session(['sfechaVigenciaCuis' => $codigoCuis->resultado->RespuestaCuis->fechaVigencia]);
    //             // session()->put('scuis', $codigoCuis->resultado->RespuestaCuis->codigo);
    //             // session()->put('sfechaVigenciaCuis', $codigoCuis->resultado->RespuestaCuis->fechaVigencia);
    //         }
    //         if(!session()->has('scufd')){
    //             $cufd = json_decode($siat->cufd());
    //             if($cufd->estado === "success"){
    //                 if($cufd->resultado->RespuestaCufd->transaccion){

    //                     session(['scufd' => $cufd->resultado->RespuestaCufd->codigo]);
    //                     session(['scodigoControl' => $cufd->resultado->RespuestaCufd->codigoControl]);
    //                     session(['sdireccion' => $cufd->resultado->RespuestaCufd->direccion]);
    //                     session(['sfechaVigenciaCufd' => $cufd->resultado->RespuestaCufd->fechaVigencia]);

    //                     // session()->put('scufd', $cufd->resultado->RespuestaCufd->codigo);
    //                     // session()->put('scodigoControl', $cufd->resultado->RespuestaCufd->codigoControl);
    //                     // session()->put('sdireccion', $cufd->resultado->RespuestaCufd->direccion);
    //                     // session()->put('sfechaVigenciaCufd', $cufd->resultado->RespuestaCufd->fechaVigencia);
    //                 }
    //             }
    //         }else{
    //             $fechaVigencia = str_replace("T"," ",substr(session('sfechaVigenciaCufd'),0,16));
    //             if($fechaVigencia < date('Y-m-d H:i')){
    //                 $cufd = json_decode($siat->cufd());
    //                 if($cufd->estado === "success"){
    //                     if($cufd->resultado->RespuestaCufd->transaccion){

    //                         session(['scufd' => $cufd->resultado->RespuestaCufd->codigo]);
    //                         session(['scodigoControl' => $cufd->resultado->RespuestaCufd->codigoControl]);
    //                         session(['sdireccion' => $cufd->resultado->RespuestaCufd->direccion]);
    //                         session(['sfechaVigenciaCufd' => $cufd->resultado->RespuestaCufd->fechaVigencia]);

    //                         // session()->put('scufd', $cufd->resultado->RespuestaCufd->codigo);
    //                         // session()->put('scodigoControl', $cufd->resultado->RespuestaCufd->codigoControl);
    //                         // session()->put('sdireccion', $cufd->resultado->RespuestaCufd->direccion);
    //                         // session()->put('sfechaVigenciaCufd', $cufd->resultado->RespuestaCufd->fechaVigencia);
    //                     }
    //                 }
    //             }
    //         }
    //     }


    //     return $siat;
    //     // session()->save();
    //     //END PARA LA CONECCION
    // }

    public function pruebaSiat(){
        $siat = app(SiatController::class);

        $factura = Factura::find(4234);
        $xml = $factura['productos_xml'];


        // $xmlConver = simplexml_load_string($xml);
        // $json = json_encode($xmlConver);
        // $array = json_decode($json, true);

        $fechaActual = date('Y-m-d\TH:i:s.v');
        $fechaEmicion = $fechaActual;
        $archivoXML = new SimpleXMLElement($xml);
        // GUARDAMOS EN LA CARPETA EL XML
        $archivoXML->asXML("assets/docs/paquete/facturaxmlContingencia.xml");


        // Ruta de la carpeta que deseas comprimir
        $rutaCarpeta = "assets/docs/paquete";

        // Nombre y ruta del archivo TAR resultante
        $archivoTar = "assets/docs/paquete.tar";

        // Crear el archivo TAR utilizando la biblioteca PharData
        $tar = new PharData($archivoTar);
        $tar->buildFromDirectory($rutaCarpeta);

        // $carpetaFacatura    = "assets/docs/paquete";
        // $archivoTar         = "assets/docs/paquete.tar";
        // // Comando para empaquetar las facturas en el archivo TAR
        // $comandoTar = "tar -cvf $archivoTar -C $carpetaFacatura .";
        // // Ejecutar el comando
        // exec($comandoTar);

        // Ruta y nombre del archivo TAR original
        // $archivoTar = "/ruta/a/la/carpeta/paquete.tar";

        // Ruta y nombre del archivo comprimido en formato Gzip
        $archivoGzip = "assets/docs/paquete.tar.gz";
        // $archivoGzip = "assets/docs/paquete.tar.zip";

        // Comprimir el archivo TAR en formato Gzip
        $comandoGzip = "gzip -c $archivoTar > $archivoGzip";
        exec($comandoGzip);

        // COMPRIMIMOS EL ARCHIVO A ZIP
        // $gzdato = gzencode('assets/docs/paquete');
        // $fiape = fopen('assets/docs/facturaContingencia.xml.zip',"w");
        // fwrite($fiape,$gzdato);
        // fclose($fiape);

        // //  hashArchivo EL ARCHIVO
        // $archivoZip = $gzdato;
        // $hashArchivo = hash("sha256", file_get_contents('assets/docs/facturaxml.xml'));

        // Leer el contenido del archivo comprimido
        $contenidoArchivo = file_get_contents($archivoGzip);

        // Calcular el HASH (SHA256) del contenido del archivo
        $hashArchivo = hash('sha256', $contenidoArchivo);

        // $res = $siat->recepcionPaqueteFactura($archivoZip, $fechaEmicion, $hashArchivo, NULL, 1, 5112428);
        // $res = $siat->recepcionPaqueteFactura($archivoZip, $fechaEmicion, $hashArchivo, NULL, 1, 5112428);
        $res = $siat->recepcionPaqueteFactura($contenidoArchivo, $fechaEmicion, $hashArchivo, NULL, 1, 5123269);
        // $res = $siat->recepcionPaqueteFactura("1", "2", "3", "4", "5");
        // dd($res, $archivoZip, $fechaEmicion, $archivoZip);
        dd($res);
        // echo json_encode($res, true);
        // echo $res;

        // for ($i = 1; $i <= 50 ; $i++) {
        //     // $verificacionSiat = json_decode($siat->sincronizarParametricaPaisOrigen());
        //     // $verificacionSiat = json_decode($siat->sincronizarParametricaTipoDocumentoIdentidad());
        //     // $verificacionSiat = json_decode($siat->sincronizarParametricaTipoEmision());
        //     // $verificacionSiat = json_decode($siat->sincronizarParametricaTipoHabitacion());
        //     // $verificacionSiat = json_decode($siat->sincronizarParametricaTipoMetodoPago());
        //     // $verificacionSiat = json_decode($siat->sincronizarParametricaTipoMoneda());
        //     $verificacionSiat1 = json_decode($siat->sincronizarParametricaTipoPuntoVenta());
        //     $verificacionSiat2 = json_decode($siat->sincronizarParametricaTiposFactura());
        //     $verificacionSiat3 = json_decode($siat->sincronizarParametricaUnidadMedida());

        //     var_dump($verificacionSiat1);
        //     echo "<br><br><br>";
        //     var_dump($verificacionSiat2);
        //     echo "<br><br><br>";
        //     var_dump($verificacionSiat3);
        //     echo "****************** => <h1>".$i."</h1><= ******************";
        //     sleep(3);
        // }
    }

    protected function enviaCorreo($correo, $factura_id){

        $factura = Factura::find($factura_id);
        $xml = $factura['productos_xml'];

        $archivoXML = new SimpleXMLElement($xml);

        $cabeza = (array) $archivoXML;

        $cuf            = (string)$cabeza['cabecera']->cuf;
        $numeroFactura  = (string)$cabeza['cabecera']->numeroFactura;

        // Genera el texto para el código QR
        $textoQR = 'https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=178436029&cuf='.$cuf.'&numero='.$numeroFactura.'&t=2';
        // Genera la ruta temporal para guardar la imagen del código QR
        $rutaImagenQR = storage_path('app/public/qr_code.png');
        // Genera el código QR y guarda la imagen en la ruta temporal
        QrCode::generate($textoQR, $rutaImagenQR);
        $pdf = PDF::loadView('pdf.generaPdfFacturaNew', compact('factura', 'archivoXML','rutaImagenQR'))->setPaper('letter');

        // Genera la ruta donde se guardará el archivo PDF
        $rutaPDF = storage_path('app/public/factura.pdf');
        // Guarda el PDF en la ruta especificada
        $pdf->save($rutaPDF);

        // $pdfPath = "assets/docs/facturapdf.pdf";
        $xmlPath = "assets/docs/facturaxml.xml";

        $mail = new EnvioFactura();
        // $mail->attach($pdfPath, ['as' => 'Factura.pdf'])
        $mail->attach($rutaPDF, ['as' => 'Factura.pdf'])
            ->attach($xmlPath, ['as' => 'Factura.xml']);

        $response = Mail::to($correo)->send($mail);

        // Elimina el archivo PDF guardado en la ruta temporal
        Storage::delete($rutaPDF);
        // dd($response);
    }
}
