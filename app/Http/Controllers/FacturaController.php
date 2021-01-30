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
        $datosPersona = Persona::find($request->personaId);

        $inscripciones = CarrerasPersona::where('persona_id', $request->personaId)
                                        ->where('anio_vigente', $gestionActual)
                                        ->get();

        $descuentos = DescuentosPersona::where('persona_id', $request->personaId)
                                    ->where('anio_vigente', $gestionActual)
                                    ->get();

        

        return view('factura.ajaxPersona')->with(compact('datosPersona', 'inscripciones', 'descuentos'));

    }
}
