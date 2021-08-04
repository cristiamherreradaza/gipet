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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
class FacturaController extends Controller
{
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

        return view('factura.ajaxPersona')->with(compact('datosPersona', 'inscripciones', 'descuentos', 'servicios', 'siguienteCuota'));
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
        $cuotaEliminar->estado = null;
        $cuotaEliminar->save();
    }

    public function muestraRecibo(Request $request, $recibo_id)
    {
        $cuotasPagadas = Pago::where('factura_id', $recibo_id)
                            ->get();

        return view('factura.generaRecibo')->with(compact('cuotasPagadas'));
    }

    public function muestraFactura(Request $request, $recibo_id)
    {
        $cuotasPagadas = Pago::where('factura_id', $recibo_id)
                            ->get();

        $factura = Factura::find($cuotasPagadas[0]->factura_id);

        $parametros = Parametro::find($factura->parametro_id);

        return view('factura.generaFactura')->with(compact('cuotasPagadas', 'factura', 'parametros'));
    }

    public function ajaxMuestraTablaPagos(Request $request)
    {
        $persona_id = $request->persona_id;
        $persona = Persona::find($request->persona_id);
        // mostramos las cuotas para pagar
        $cuotasParaPagar = Pago::where('persona_id', $request->persona_id)
            ->where('estado', 'paraPagar')
            ->orWhere('estado', 'Parcial')
            ->orderBy('carrera_id', 'asc')
            ->get(); 

        // extraemos la ultima cuota para eliminar de la tabla
        $ultimaCuota = Pago::where('persona_id', $request->persona_id)
                        ->where('estado', 'paraPagar')
                        ->orWhere('estado', 'Parcial')
                        ->orderBy('id', 'desc')
                        ->first();

        return view('factura.ajaxMuestraTablaPagos')->with(compact('persona_id', 'cuotasParaPagar', 'ultimaCuota', 'persona'));
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

        if($request->input('numero') == null && $request->input('ci') == null && $request->input('nit') == null && $request->input('user_id') == null && $request->input('fecha_inicio') == null && $request->input('fecha_final') == null){
            $pagos->limit(100);
        }

        $cobros = $pagos->get();

        // return view('factura.ajaxBuscaPago')->with(compact('cobros'));
        $pdf = PDF::loadView('pdf.generaPagos', compact('cobros', 'numero', 'numero_recibo', 'ci', 'nit', 'user_id', 'fecha_inicio', 'fecha_final'))->setPaper('letter');
        return $pdf->stream('pagos.pdf');

    }
}
