<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapFault;

class SiatController extends Controller
{

    protected $header = "apikey: TokenApi eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiI4NDM5ODU2THB6IiwiY29kaWdvU2lzdGVtYSI6Ijc3MkM0QTVENUVBQTQyQjlBNDFCNDM2Iiwibml0IjoiSDRzSUFBQUFBQUFBQURNMHR6QXhOak13c2dRQUYyano4UWtBQUFBPSIsImlkIjo2NTAyNjYsImV4cCI6MTY5MTk3MTIwMCwiaWF0IjoxNjg0MDkxNTc0LCJuaXREZWxlZ2FkbyI6MTc4NDM2MDI5LCJzdWJzaXN0ZW1hIjoiU0ZFIn0.09bh1_ENu-jzmY5kh31AEfmmLY79ucj_XN_nHnmaBDayNYq6_QcwaiwDc87PMHNRj2y5bDvAFBC0g3HXqTgZaA";
    protected $timeout = 5;

    public function verificarComunicacion(){
        $wsdl = "https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionCodigos?wsdl";
        $aoptions = array(
            'http' => array(
                // 'header' => "apikey: TokenApi eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiI4NDM5ODU2THB6IiwiY29kaWdvU2lzdGVtYSI6Ijc3MkM0QTVENUVBQTQyQjlBNDFCNDM2Iiwibml0IjoiSDRzSUFBQUFBQUFBQURNMHR6QXhOak13c2dRQUYyano4UWtBQUFBPSIsImlkIjo2NTAyNjYsImV4cCI6MTY5MTk3MTIwMCwiaWF0IjoxNjg0MDkxNTc0LCJuaXREZWxlZ2FkbyI6MTc4NDM2MDI5LCJzdWJzaXN0ZW1hIjoiU0ZFIn0.09bh1_ENu-jzmY5kh31AEfmmLY79ucj_XN_nHnmaBDayNYq6_QcwaiwDc87PMHNRj2y5bDvAFBC0g3HXqTgZaA",
                'header' => $this->header,
                'timeout' => $this->timeout
            ),
        );

        $context = stream_context_create($aoptions);

        $data = array();

        try {
            $client = new \SoapClient($wsdl,[
                'stream_context' => $context,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE
            ]);
            $resultado = $client->verificarComunicacion();
            $data['estado'] = 'success';
            $data['resultado'] = $resultado;
        } catch (SoapFault $fault) {
            $resultado = false;
            $data['estado'] = 'error';
            $data['resultado'] = $resultado;
        }

        // return $resultado;
        // return json_encode($resultado, JSON_UNESCAPED_UNICODE);
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function cuis(){
        $wsdl               = "https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionCodigos?wsdl";
        $codigoAmbiente     = 2;
        $codigoModalidad    = 2;
        $codigoPuntoVenta   = 0;
        $codigoSistema      = "772C4A5D5EAA42B9A41B436";
        $codigoSucursal     = 0;
        $nit                = "178436029";

        $parametros         =  array(
            'SolicitudCuis' => array(
                'codigoAmbiente'    => $codigoAmbiente,
                'codigoModalidad'   => $codigoModalidad,
                'codigoPuntoVenta'  => $codigoPuntoVenta,
                'codigoSistema'     => $codigoSistema,
                'codigoSucursal'    => $codigoSucursal,
                'nit'               => $nit
            )
        );

        $aoptions = array(
            'http' => array(
                'header' => $this->header,
                'timeout' => $this->timeout
            ),
        );

        $context = stream_context_create($aoptions);

        try {
            $client = new \SoapClient($wsdl,[
                'stream_context' => $context,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE
            ]);

            $resultado = $client->cuis($parametros);

            $data['estado'] = 'success';
            $data['resultado'] = $resultado;
        } catch (SoapFault $fault) {
            $resultado = false;
            $data['estado'] = 'error';
            $data['resultado'] = $resultado;
        }
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function cufd(){
        $wsdl               = "https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionCodigos?wsdl";
        $codigoAmbiente     = 2;
        $codigoModalidad    = 2;
        $codigoPuntoVenta   = 0;
        $codigoSistema      = "772C4A5D5EAA42B9A41B436";
        $codigoSucursal     = 0;
        $cuis               = session('scuis');
        $nit                = "178436029";

        $parametros         =  array(
            'SolicitudCufd' => array(
                'codigoAmbiente'    => $codigoAmbiente,
                'codigoModalidad'   => $codigoModalidad,
                'codigoPuntoVenta'  => $codigoPuntoVenta,
                'codigoSistema'     => $codigoSistema,
                'codigoSucursal'    => $codigoSucursal,
                'cuis'              => $cuis,
                'nit'               => $nit
            )
        );

        $aoptions = array(
            'http' => array(
                'header' => $this->header,
                'timeout' => $this->timeout
            ),
        );

        $context = stream_context_create($aoptions);

        try {
            $client = new \SoapClient($wsdl,[
                'stream_context' => $context,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE
            ]);

            $resultado = $client->cufd($parametros);

            $data['estado'] = 'success';
            $data['resultado'] = $resultado;
        } catch (SoapFault $fault) {
            $resultado = false;
            $data['estado'] = 'error';
            $data['resultado'] = $resultado;
        }
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function sincronizarListaProductosServicios(){
        $wsdl               = "https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionSincronizacion?wsdl";
        $codigoAmbiente     = 2;
        $codigoPuntoVenta   = 0;
        $codigoSistema      = "772C4A5D5EAA42B9A41B436";
        $codigoSucursal     = 0;
        $cuis               = session('scuis');
        $nit                = "178436029";

        // dd($wsdl,
        // $codigoAmbiente,
        // $codigoPuntoVenta,
        // $codigoSistema,
        // $codigoSucursal,
        // $cuis,
        // $nit);

        $parametros         =  array(
            'SolicitudSincronizacion' => array(
                'codigoAmbiente'    => $codigoAmbiente,
                'codigoPuntoVenta'  => $codigoPuntoVenta,
                'codigoSistema'     => $codigoSistema,
                'codigoSucursal'    => $codigoSucursal,
                'cuis'              => $cuis,
                'nit'               => $nit
            )
        );

        $aoptions = array(
            'http' => array(
                'header' => $this->header,
                'timeout' => $this->timeout
            ),
        );

        $context = stream_context_create($aoptions);

        try {
            $client = new \SoapClient($wsdl,[
                'stream_context' => $context,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE
            ]);

            $resultado = $client->sincronizarListaProductosServicios($parametros);

            $data['estado'] = 'success';
            $data['resultado'] = $resultado;
        } catch (SoapFault $fault) {
            $resultado = false;
            $data['estado'] = 'error';
            $data['resultado'] = $resultado;
        }

        // dd($data);

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
