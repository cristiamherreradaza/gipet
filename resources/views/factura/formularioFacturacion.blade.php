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
    <div class="card border-info" id="mostrar" style="display:block;">
        <div class="card-header bg-info">
            <h4 class="mb-0 text-white">
                DATOS PARA LA FACTURA
            </h4>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>BUSCA POR (CARNET/AP/AM/NOMBRES)
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control" name="termino" id="termino">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12" id="ajaxPersonas">

                </div>
            </div>

            <div class="row">
                <div class="col-md-12" id="ajaxDatosPersona">

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

    $(document).on('keyup', '#termino', function(e) {

        let termino_busqueda = $('#termino').val();
        // let tipo = $('#venta_tipo_id').val();
        // let marca = $('#venta_marca_id').val();

        if (termino_busqueda.length > 3) {
            // alert('si paso');
            $.ajax({
                url: "{{ url('Factura/ajaxBuscaPersona') }}",
                data: {termino: termino_busqueda},
                type: 'POST',
                success: function(data) {
                    $("#ajaxPersonas").show('slow');
                    $("#ajaxPersonas").html(data);
                }
            });
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

</script>
@endsection
