<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;

class TransaccionController extends Controller
{
   	public function pagos()
    {
        // $almacenes = Almacene::get();
        // $grupos = Grupo::all();
        // $clientes = User::where('rol', 'Cliente')
        //             ->get();
        // return view('transaccion.pagos')->with(compact('almacenes', 'clientes', 'grupos'));
        return view('transaccion.pagos');
    }

    public function verifica_ci(Request $request)
    {
    	$carnet = $request->ci;
        // $almacenes = Almacene::get();
        // $grupos = Grupo::all();
        $persona = Persona::where('carnet', $carnet)
                    ->first();
        // dd($persona->nombres);
        // return view('transaccion.pagos')->with(compact('almacenes', 'clientes', 'grupos'));
        return response()->json([
            'id' => $persona->id,
            'nombres' => $persona->nombres,
            'apellido_paterno' => $persona->apellido_paterno,
            'apellido_materno' => $persona->apellido_materno,
            'nit' => $persona->nit,
            'razon_social_cliente' => $persona->razon_social_cliente
        ]);
    }
}
