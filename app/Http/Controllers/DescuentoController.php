<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Descuento;

class DescuentoController extends Controller
{
    public function listado()
    {
        $descuentos = Descuento::get();
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
        $descuento->delete();
        return redirect('Descuento/listado');
    }
}
