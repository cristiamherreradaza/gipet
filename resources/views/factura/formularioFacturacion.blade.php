@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <h4>
                    <span class="text-info">APELLIDO PATERNO: </span>
                    {{ $datosPersona->apellido_paterno }}
                </h4>
            </div>

            <div class="col-md-3">
                <h4>
                    <span class="text-info">APELLIDO MATERNO: </span>
                    {{ $datosPersona->apellido_materno }}
                </h4>
            </div>

            <div class="col-md-3">
                <h4>
                    <span class="text-info">NOMBRES: </span>
                    {{ $datosPersona->nombres }}
                </h4>
            </div>

            <div class="col-md-3">
                <h4>
                    <span class="text-info">FECHA NACIMIENTO: </span>
                    {{ $datosPersona->fecha_nacimiento }}
                </h4>
            </div>

        </div>

        <div class="row">
            <div class="col-md-3">
                <h4>
                    <span class="text-info">CARNET: </span>
                    {{ $datosPersona->cedula }}
                </h4>
            </div>

            <div class="col-md-3">
                <h4>
                    <span class="text-info">EXPEDIDO: </span>
                    {{ $datosPersona->expedido }}
                </h4>
            </div>

            <div class="col-md-3">
                <h4>
                    <span class="text-info">CELULAR: </span>
                    {{ $datosPersona->celular }}
                </h4>
            </div>

            <div class="col-md-3">
                <h4>
                    <span class="text-info">EMAIL: </span>
                    {{ $datosPersona->email }}
                </h4>
            </div>

        </div>

    </div>

    <div class="card border-info" id="mostrar" style="display:block;">
        <div class="card-header bg-info">
            <h4 class="mb-0 text-white">
                DATOS PARA LA FACTURA
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                @if ($pagos->count() > 0)
                    <input type="hidden" value="">
                @else
                    <input type="hidden" value="No" name="pago_antes">
                @endif



                <div class="col-3">
                    <div class="form-group">
                        <label>Servicio 
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                        </label>
                        <select name="servicio_id" id="servicio_id" class="form-control" required>
                            <option value="">SELECCIONE</option>
                            @foreach ($servicios as $s)
                                <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>CANTIDAD 
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control" name="cantidad" id="cantidad" value="{{ $datosPersona->nit }}" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>NIT 
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control" name="nit" id="nit" value="{{ $datosPersona->nit }}" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>RAZON SOCIAL 
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control" name="razon_social" id="razon_social" value="{{ $datosPersona->razon_social_cliente }}" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-block btn-info" onclick="adicionaItem()">Adicionar</button>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive m-t-40">
                        <table id="pensiones" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Descripcion</th>                        
                                    <th>Precio Unitario</th>                        
                                    <th>Subtotal</th>                        
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('Factura/imprimeFactura') }}" class="btn btn-block btn-success">FACTURAR</a>
                </div>
            </div>

        </div>

        
    </div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<!-- This Page JS -->
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/forms/select2/select2.init.js') }}"></script>

<script>
    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var t = $('#pensiones').DataTable({
        paging: false,
        searching: false,
        ordering:  false,
        info: false,
        language: {
            url: '{{ asset('datatableEs.json') }}'
        },
    });

    function adicionaItem()
    {
        let cantidad = Number($("#cantidad").val());
        let c = 1;
        for (let i = 0; i < cantidad; i++) {
            
            t.row.add([
                '1',
                c+'&#186; Mensualidad',
                '200.00',
                '200.00',
                '<button type="button" class="btnElimina btn btn-danger" title="Elimina Producto"><i class="fas fa-trash-alt"></i></button>'
            ]).draw(false);

            c++;
        }
    }

</script>
@endsection
