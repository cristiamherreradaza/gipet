@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <h3 class="card-title text-info"><strong>LISTADO DE ASIGNATURAS</strong></h3>
        <div class="row">
            <div class="col-md-12">
                <div class="col-sm-12 col-lg-6">
                    <div class="form-group row">
                        <label for="fname2" class="col-sm-3 text-left control-label col-form-label text-danger"><strong>DOCENTE</strong></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ auth()->user()->nombres }} {{ auth()->user()->apellido_paterno }} {{ auth()->user()->apellido_materno }}" readonly>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="gestion_actual" id="gestion_actual" value="{{ date('Y') }}">
                <div class="col-sm-12 col-lg-6">
                    <div class="form-group row">
                        <label for="lname2" class="col-sm-3 text-left control-label col-form-label text-danger"><strong>GESTION</strong></label>
                        <div class="col-sm-9">
                            <select class="select2 form-control custom-select select2-hidden-accessible" name="gestion" id="gestion" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                @foreach($gestiones as $gestion)
                                    @if($gestion->anio_vigente == date('Y'))
                                        <option value="{{ $gestion->anio_vigente }}" selected>{{ $gestion->anio_vigente }}</option>
                                    @else
                                        <option value="{{ $gestion->anio_vigente }}">{{ $gestion->anio_vigente }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12" id="ajaxAsignaturasGestion">
            
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script>
    // Funcion que habilita el uso de Ajax
    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Funcion para mostrar datos de la gestion escogida
    $( function() {
        var gestion_actual = $("#gestion_actual").val();
        $.ajax({
            url: "{{ url('Nota/ajaxAsignaturasGestion') }}",
            data: {
                gestion : gestion_actual
                },
            type: 'get',
            success: function(data) {
                $("#ajaxAsignaturasGestion").show('slow');
                $("#ajaxAsignaturasGestion").html(data);
            }
        });
    });

    //Funcion para mostrar datos de la gestion escogida
    $( function() {
        $("#gestion").change( function() {
            var gestion = $("#gestion").val();
            $.ajax({
                url: "{{ url('Nota/ajaxAsignaturasGestion') }}",
                data: {
                    gestion : gestion
                    },
                type: 'get',
                success: function(data) {
                    $("#ajaxAsignaturasGestion").show('slow');
                    $("#ajaxAsignaturasGestion").html(data);
                }
            });
        });
    });

</script>
@endsection
