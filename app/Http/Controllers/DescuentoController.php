<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Descuento;

class DescuentoController extends Controller
{
    public function listado()
    {
        $descuentos = Descuento::whereNull('borrado')
                        ->get();
        return view('descuento.listado')->with(compact('descuentos'));
    }

    public function guardar(Request $request)
    {
        $descuento = new Descuento();
        $descuento->nombre = $request->nombre_descuento;
        $descuento->porcentaje = $request->porcentaje_descuento;
        $descuento->save();
        return redirect('Descuento/listado');
    }

    public function actualizar(Request $request)
    {
        $descuento = Descuento::find($request->id);
        $descuento->nombre = $request->nombre;
        $descuento->porcentaje = $request->porcentaje;
        $descuento->save();
        return redirect('Descuento/listado');
    }

    public function eliminar($id)
    {
        $descuento = Descuento::find($id);
        $descuento->borrado = date('Y-m-d H:i:s');
        $descuento->save();
        return redirect('Descuento/listado');
    }
}
