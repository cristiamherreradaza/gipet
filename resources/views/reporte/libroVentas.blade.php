@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<style type="text/css" media="print">
    @page {
        size: landscape;
    }
</style>
<div class="PrintArea">
    <div class="row">
        <div class="col-md-12">
            <img src="{{ asset('assets/imagenes/portal_uno_R.png') }}" height="100" alt="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center"><h2>LIBRO DE VENTAS</h2></div>
        <div class="col-md-12 text-center"><h3>(Expresado en Bolivianos)</h3></div>
        <div class="col-md-12 text-center"><h3>Periodo: {{ $fecha_inicio }} hasta {{ $fecha_final }}</h3></div>
        <div class="col-md-12">
            <table class="table table-bordered table-hover table-striped text-center">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Factura</th>
                        <th>Caja</th>
                        <th>N. Autoriz.</th>
                        <th>NIT</th>
                        <th>Razon Social</th>
                        <th>T.Ventas</th>
                        <th>T.Desctos</th>
                        <th>T.Factdo</th>
                        <th>T.ImpTos</th>
                        <th>V.Neta</th>
                        <th>AdmIN</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalVentas = 0;
                        $totalImpositivo = 0;
                    @endphp
                    @forelse ($facturas as $f)
                    @php
                        $totalVentas += $f->total;
                        $totalImpositivo += $f->total*0.13;
                    @endphp
                        <tr>
                            <td>{{ $f->fecha }}</td>
                            <td>{{ $f->numero }}</td>
                            <td>Caja 1</td>
                            <td>{{ $f->parametro->numero_autorizacion }}</td>
                            <td>{{ $f->nit }}</td>
                            <td>{{ $f->razon_social }}</td>
                            <td>{{ $f->total }}</td>
                            <td>0</td>
                            <td>{{ $f->total }}</td>
                            <td>{{ $f->total*0.13 }}</td>
                            <td>{{ $f->total-($f->total*0.13) }}</td>
                            <td>{{ $f->user->nombres }}</td>
                        </tr>    
                    @empty
                        <h3 class="text-danger text-center">NO EXISTEN REGISTROS</h3>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>TOTAL</th>
                        <th>{{ $totalVentas }}</th>
                        <th></th>
                        <th>{{ $totalVentas }}</th>
                        <th>{{ $totalImpositivo }}</th>
                        <th>{{ $totalVentas - $totalImpositivo }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <button type="button" class="btn btn-info btn-block" title="Imprimir" onclick="imprimir()">IMPRIMIR</button>
    </div>
    <div class="col-md-6">
        <button type="button" class="btn btn-success btn-block" title="Imprimir" onclick="imprimir()">GENERA EXCEL</button>
    </div>
</div>

@stop

@section('js')
<script src="{{ asset('dist/js/pages/samplepages/jquery.PrintArea.js') }}"></script>
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script>
    function imprimir()
    {
        $("div.PrintArea").printArea();
    }
</script>

@endsection