<?php

namespace App\Http\Controllers;

use App\Pago;
use DataTables;
use App\Factura;
use App\Persona;
use App\Servicio;
use App\CarrerasPersona;
use App\DescuentosPersona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $gestionActual = date('Y');
        $servicios = Servicio::get();
        $datosPersona = Persona::find($request->personaId);
        $carreras = CarrerasPersona::where('persona_id', $request->personaId)
                                    ->where('anio_vigente', $gestionActual)
                                    ->get();
        $pagos = Pago::where('persona_id', $request->personaId)
                    ->where('anio_vigente', $gestionActual)
                    ->get();

        $descuento = DescuentosPersona::where('persona_id', $request->personaId)
                    ->where('anio_vigente', $gestionActual)
                    ->get();

        /*$descuentosCobrados = Pago::where('persona_id', $request->personaId)
                            ->where('descuento_persona_id', '<>', )
                            ->where('anio_vigente', $gestionActual)
                            ->get();*/

        // dd($datosPersona);
        return view('factura.formularioFacturacion')->with(compact('datosPersona', 'carreras', 'servicios', 'pagos', 'descuento'));
    }

    public function imprimeFactura()
    {
        return view('factura.imprimeFactura');
    }

    public function ajaxBuscaPersona(Request $request)
    {
        $personas = DB::select("
                                Select 
                                    id, 
                                    cedula, 
                                    apellido_paterno, 
                                    apellido_materno, 
                                    nombres, 
                                    concat(cedula,' ',apellido_paterno,' ',apellido_materno,' ',nombres) as campo_mixto 
                                    from personas where concat(cedula,' ',apellido_paterno,' ',apellido_materno,' ',nombres) like '%$request->termino%' limit 8");

        // dd($personas);

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

    public function generaRecibo(Request $request)
    {
        $hoy = date('Y-m-d');

        $cuotasParaPagar = Pago::where('persona_id', $request->persona_id)
            ->where('estado', 'paraPagar')
            ->orWhere('estado', 'Parcial')
            ->get();

        // calculamos el monto total
        $total = 0;

        foreach ($cuotasParaPagar as $cp) {
            $total += $cp->importe;
            $anio = $cp->anio_vigente;
        }

        $ultmoRecibo = Factura::where('facturado', 'no')
                            ->orderBy('id', 'desc')
                            ->first();

        if ($ultmoRecibo) {
            $contadorRecibo = $ultmoRecibo->numero+1;
        } else {
            $contadorRecibo = 1;
        }

        // creamos el recibo en la tabla de facturas
        $recibo               = new Factura();
        $recibo->user_id      = Auth::user()->id;
        $recibo->persona_id   = $request->persona_id;
        $recibo->fecha        = $hoy;
        $recibo->total        = $total;
        $recibo->numero       = $contadorRecibo;
        $recibo->anio_vigente = $anio;
        $recibo->facturado    = "No";
        $recibo->save();

        $reciboId = $recibo->id;
        
        foreach ($cuotasParaPagar as $cp) 
        {
            if($cp->estado == 'paraPagar'){
                $estado = 'Pagado';
            }else{
                $estado = null;
            }
            $cuotasPagadas             = Pago::find($cp->id);
            $cuotasPagadas->estado     = $estado;
            $cuotasPagadas->fecha      = $hoy;
            $cuotasPagadas->factura_id = $reciboId;
            
            $cuotasPagadas->save();
        }

        $cuotasPagadas = Pago::where('factura_id', $reciboId)
                            ->get();

        return redirect("Factura/muestraRecibo/$reciboId");
    }

    public function muestraRecibo(Request $request, $recibo_id)
    {
        $cuotasPagadas = Pago::where('factura_id', $recibo_id)
                            ->get();

        return view('factura.generaRecibo')->with(compact('cuotasPagadas'));
    }

    public function ajaxEliminaItemPago(Request $request)
    {
        // actualizamos el estado del item a pagar
        $cuotaEliminar = Pago::find($request->pago_id);
        $cuotaEliminar->estado = null;
        $cuotaEliminar->save();
    }

    public function ajaxMuestraTablaPagos(Request $request)
    {
        $persona_id = $request->persona_id;
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

        return view('factura.ajaxMuestraTablaPagos')->with(compact('persona_id', 'cuotasParaPagar', 'ultimaCuota'));
    }

    public function ajaxPreciosServicios(Request $request)
    {
        $preciosServicios = Servicio::find($request->servicio_id);
        $persona = Persona::find($request->persona_id);

        return view('factura.ajaxPreciosServicios')->with(compact('preciosServicios', 'persona'));
    }

    public function ajaxAdicionaItemServicio(Request $request)
    {
        // $datosPago = Pago::find($request->pago_id);

        // if($request->pago_parcial == 'parcial'){
        //     $faltante = $datosPago->a_pagar - $request->importe_pago;
        //     $estado = 'Parcial';
        // }else{
        //     $faltante = 0;
        //     $estado = 'paraPagar';
        // }
        // actualizamos los datos para mostrar en la tabla pagos
        $cuotaAPagar              = new Pago();
        $cuotaAPagar->user_id     = Auth::user()->id;
        $cuotaAPagar->persona_id  = $request->persona_id;
        $cuotaAPagar->servicio_id = $request->servicio_id;
        $cuotaAPagar->importe     = $request->importe;
        // $cuotaAPagar->faltante = $faltante;
        $cuotaAPagar->estado      = 'paraPagar';
        $cuotaAPagar->save();
    }

    public function ajaxEliminaItemPagoServicio(Request $request)
    {
        Pago::destroy($request->pago_id);
    }
}
