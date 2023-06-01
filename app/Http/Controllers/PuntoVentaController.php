<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PuntoVentaController extends Controller
{
    public function listado(Request $request){
        return view('puntoventa.listado');
    }

    public function ajaxListado(Request $request){
        if($request->ajax()){
            $siat = app(SiatController::class);
            $respuesta = json_decode($siat->consultaPuntoVenta());
            if($respuesta->estado === "success"){
                $puntos = json_decode(json_encode($respuesta->resultado->RespuestaConsultaPuntoVenta->listaPuntosVentas), true);
                $data['listado'] = view('puntoventa.ajaxListado')->with(compact('puntos'))->render();
            }else{

            }
            return $data;
        }
    }

    public function guarda(Request $request){
        if($request->ajax()){
            $nombre         = $request->input('nombre');
            $descripcion    = $request->input('descripcion');
            $siat = app(SiatController::class);
            $res = json_decode($siat->registroPuntoVenta($descripcion,$nombre), true);
            $data['estado'] = $res['estado'];
            return $data;
        }
    }

    public function eliminaPuntoVenta(Request $request){
        if($request->ajax()){
            $cod         = $request->input('cod');
            $siat = app(SiatController::class);
            $res = json_decode($siat->cierrePuntoVenta($cod), true);
            $data['estado'] = $res['estado'];
            return $data;
        }
    }
}
