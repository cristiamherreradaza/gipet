<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio;

class ServicioController extends Controller
{
    public function listado()
    {
        $servicios = Servicio::whereNull('borrado')
                        ->get();
        return view('servicio.listado')->with(compact('servicios'));
    }

    public function guardar(Request $request)
    {
        $servicio = new Servicio();
        $servicio->sigla = $request->sigla_servicio;
        $servicio->nombre = $request->nombre_servicio;
        $servicio->precio = $request->precio_servicio;
        $servicio->save();
        return redirect('Servicio/listado');
    }

    public function actualizar(Request $request)
    {
        $servicio = Servicio::find($request->id);
        $servicio->sigla = $request->sigla;
        $servicio->nombre = $request->nombre;
        $servicio->precio = $request->precio;
        $servicio->save();
        return redirect('Servicio/listado');
    }

    public function eliminar($id)
    {
        $servicio = Servicio::find($id);
        $servicio->borrado = date('Y-m-d H:i:s');
        $servicio->save();
        return redirect('Servicio/listado');
    }
}
