<?php

namespace App\Http\Controllers;

use App\Pago;
use DataTables;
use App\Persona;
use App\Servicio;
use App\CarrerasPersona;
use App\DescuentosPersona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        /*$personas = Persona::where('apellido_paterno', 'like', "%$request->termino%")
                                ->orWhere('apellido_materno', 'like', "%$request->termino%")
                                ->orWhere('nombres', 'like', "%$request->termino%")
                                ->orWhere('cedula', 'like', "%$request->termino%")
                                ->limit(10)
                                ->get();*/

        $personas = DB::select("Select id, cedula, apellido_paterno, apellido_materno, nombres, concat(cedula,' ',apellido_paterno,' ',apellido_materno,' ',nombres) as campo_mixto from personas where concat(cedula,' ',apellido_paterno,' ',apellido_materno,' ',nombres) like '%$request->termino%' limit 8");

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
        $gestionActual = date('Y');
        // dd($request->all());
        $paraPagar = Pago::where('persona_id', $request->persona_id)
                    ->where('carrera_id', $request->carrera_id)
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
                        ->where('carrera_id', $request->carrera_id)
                        ->whereNull('estado')
                        ->orderBy('mensualidad', 'asc')
                        ->first();

        return view('factura.ajaxMuestraCuotaAPagar')->with(compact('siguienteCuota'));
    }

    public function ajaxAdicionaItem(Request $request)
    {
        // dd($request->all());
        $cuotaAPagar = Pago::find($request->pago_id);
        $cuotaAPagar->estado = 'paraPagar';
        $cuotaAPagar->save();

        $siguienteCuota = Pago::where('persona_id', $request->persona_id)
            ->where('carrera_id', $request->carrera_id)
            ->whereNull('estado')
            ->orderBy('mensualidad', 'asc')
            ->first();

        $cuotasParaPagar = Pago::where('persona_id', $request->persona_id)
            ->where('carrera_id', $request->carrera_id)
            ->where('estado', 'paraPagar')
            ->orderBy('mensualidad', 'asc')
            ->get(); 

        return view('factura.ajaxMuestraCuotaAPagar')->with(compact('siguienteCuota', 'cuotasParaPagar'));

    }

}
