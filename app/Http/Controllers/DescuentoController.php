<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $descuento->user_id = Auth::user()->id;
        $descuento->nombre = $request->nombre_descuento;
        $descuento->monto = $request->monto_descuento;
        $descuento->save();
        return redirect('Descuento/listado');
    }

    public function actualizar(Request $request)
    {
        $descuento = Descuento::find($request->id);
        $descuento->user_id = Auth::user()->id;
        $descuento->nombre = $request->nombre;
        $descuento->monto = $request->monto;
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
