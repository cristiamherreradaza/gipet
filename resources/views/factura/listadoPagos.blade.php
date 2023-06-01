@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
{{--  <link href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">  --}}
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<!-- inicio modal anula factua -->
<div id="modmodalAnularal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">ANULAR FACTURA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="formularioAnulaciion" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Motivo de la anulacion</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="codigoMotivoAnulacion" id="codigoMotivoAnulacion" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <option value="1">FACTURA MAL EMITIDA</option>
                                    <option value="2">NOTA DE CREDITO-DEBITO MAL EMITIDA</option>
                                    <option value="3">DATOS DE EMISION INCORRECTOS</option>
                                    <option value="4">FACTURA O NOTA DE CREDITO-DEBITO DEVUELTA</option>
                                </select>
                                <input type="text" id="factura_id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-block btn-success" onclick="anularFactura()">ANULAR FACTURA</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal anula factua -->

<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            LISTADO ULTIMOS PAGOS
        </h4>
    </div>
    <div class="card-body">

        <form action="{{ url('Factura/generaPdfPagos') }}" method="POST" id="formulario_pagos" target="_blank">
            @csrf
            <div class="row">

                <div class="col-md-1">
                    <div class="form-group">
                        <label class="control-label">No. Factura </label>
                        <input type="number" name="numero" id="numero" class="form-control">
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="form-group">
                        <label class="control-label">No. Recibo </label>
                        <input type="text" name="numero_recibo" id="numero_recibo" class="form-control">
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="form-group">
                        <label class="control-label">C.I. Persona</label>
                        <input type="number" name="ci" id="ci" class="form-control">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">NIT </label>
                        <input type="number" name="nit" id="nit" class="form-control">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">USUARIO </label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">TODOS</option>
                            @foreach ($usuarios as $u)
                                <option value="{{ $u->user->id }}">
                                    {{ $u->user->apellido_paterno }}
                                    {{ $u->user->apellido_materno }}
                                    {{ $u->user->nombres }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Fecha Inicio </label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Fecha Fin </label>
                        <input type="date" name="fecha_final" id="fecha_final" class="form-control">
                    </div>
                </div>

                <div class="col-md-1">
                    <br />
                    <button type="button" class="btn btn-success btn-block" title="Buscar" onclick="buscaPago()">BUSCAR</button>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" id="ajax-bloque-pagos">
                    <table id="tabla-pagos" class="table table-bordered table-hover table-striped text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>TIPO</th>
                                <th>NUMERO</th>
                                <th>CARNET</th>
                                <th>ESTUDIANTE</th>
                                <th>RAZON</th>
                                <th>NIT</th>
                                <th>FECHA</th>
                                <th>MONTO</th>
                                <th>ESTADO</th>
                                <th>ESTADO SIAT</th>
                                <th>USUARIO</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facturas as $f)
                            <tr>
                                <td>{{ $f->id }}</td>
                                <td>
                                    @if ($f->facturado == 'Si')
                                        <span class="text-info">FACTURA</span>
                                    @else
                                        <span class="text-primary">RECIBO</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($f->facturado == 'Si')
                                        <span class="text-info">{{ $f->numero }}</span>
                                    @else
                                        <span class="text-primary">{{ $f->numero_recibo }}</span>

                                    @endif
                                </td>
                                <td>{{ $f->persona->cedula }}</td>
                                <td>{{ $f->persona->nombres }}</td>
                                <td>{{ $f->razon_social }}</td>
                                <td>{{ $f->nit }}</td>
                                <td>{{ $f->fecha }}</td>
                                <td>{{ $f->total }}</td>
                                <td>
                                    @if ($f->estado === "Anulado")
                                        <span class="badge badge-danger">ANULADO</span>
                                    @else
                                        <span class="badge badge-success">VIGENTE</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        if($f->codigo_descripcion == "VALIDADA"){
                                            $text = "badge badge-success";
                                        }else{
                                            $text = "badge badge-danger";
                                        }
                                    @endphp
                                    <span class="{{ $text }}" >{{ $f->codigo_descripcion }}</span>
                                </td>
                                <td>{{ $f->user->nombres }}</td>
                                <td>
                                    @if ($f->productos_xml != null)
                                        <a class="btn btn-info" href="{{ url('Factura/generaPdfFacturaNew', [$f->id]) }}" target="_blank"><i class="fa fa-file-pdf"></i></a>
                                    @endif
                                    {{--  <a href="https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=178436029&cuf={{ $f->cuf }}&numero={{ $f->numero }}&t=2" target="_blank" class="btn btn-dark btn-icon btn-sm"><i class="fa fa-file"></i></a>  --}}

                                    @if ($f->estado != 'Anulado')
                                        @if ($f->productos_xml != null)
                                            <button class="btn btn-danger btn-icon" onclick="modalAnularFactura('{{ $f->id }}')"><i class="fa fa-trash"></i></button>
                                        @endif
                                    @endif

                                    @if ($f->productos_xml == null)
                                        @if ($f->facturado=='Si')

                                            @if ($f->estado != 'Anulado')
                                                <a href="{{ url("Factura/muestraFactura/$f->id") }}" class="btn btn-info text-white" title="Muestra Factura"><i class="fas fa-eye"></i></a>
                                            @else
                                                {{--  <a href="#" class="btn btn-danger text-white" title="Factura Anulada"><i class="fas fa-eye"></i></a>  --}}
                                            @endif

                                        @else

                                            @if ($f->estado != 'Anulado')
                                                <a href="{{ url("Factura/muestraRecibo/$f->id") }}" class="btn btn-primary text-white" title="Muestra Recibo"><i class="fas fa-eye"></i></a>
                                            @else
                                                {{--  <a href="#" class="btn btn-danger text-white" title="Factura Anulada"><i class="fas fa-eye"></i></a>  --}}
                                            @endif

                                        @endif
                                    @endif

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <br />
                <a href="#" target="_blank" class="btn btn-success btn-block" title="GENERA PDF" onclick="generaPdf()">GENERAR PDF</a>
            </div>
        </div>
    </div>
</div>

<!-- inicio modal prerequisitos -->

<!-- fin modal prerequisitos -->

@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $.ajaxSetup({
        // definimos cabecera donde estara el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('#tabla-pagos').DataTable({
            order: [[ 0, "desc" ]],
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
            searching: false,
            lengthChange: false,
            order: [[ 0, "desc" ]]
        });
    });


    function buscaPago()
    {
        let datos_formulario = $("#formulario_pagos").serializeArray();

        $.ajax({
            url: "{{ url('Factura/ajaxBuscaPago') }}",
            method: "POST",
            data: datos_formulario,
            success: function (data) {
                $("#ajax-bloque-pagos").html(data);
            }
        })

    }

    function generaPdf()
    {
        $("#formulario_pagos").submit();
    }

    function modalAnularFactura(factura){
        $('#factura_id').val(factura)
        $('#modmodalAnularal').modal('show')
    }

    function anularFactura(){
        let factura = $('#factura_id').val()
        let codMott = $('#codigoMotivoAnulacion').val()
        if($("#formularioAnulaciion")[0].checkValidity()){
            Swal.fire({
                title: 'Esta seguro de Anular la Factura?',
                text: "No podras revertir eso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Anular!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('Factura/anularFacturaNew') }}",
                        method: "POST",
                        data: {
                            factura: factura,
                            moivo:   codMott
                        },
                        dataType:'json',
                        success: function (data) {
                            if(data.estado){
                                Swal.fire({
                                    icon:'success',
                                    title: 'Exito!',
                                    text:data.descripcion,
                                    timer:1500
                                })
                                buscaPago();
                                $('#modmodalAnularal').modal('hide');
                            }else{
                                Swal.fire({
                                    icon:'error',
                                    title: 'Error!',
                                    text:data.descripcion
                                })
                            }
                        }
                    })
                }
            })
        }else{
            $("#formularioAnulaciion")[0].reportValidity();
        }
    }
</script>
@endsection
