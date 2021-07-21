@extends('layouts.reporte')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            LIBRO DE VENTAS
        </h4>
    </div>
    <div class="card-body">

        <form action="{{ url('Reporte/libroVentas') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Fecha Inicio </label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Fecha Fin </label>
                        <input type="date" name="fecha_final" id="fecha_final" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <br />
                    <button type="submit" formtarget="_blank" class="btn btn-success btn-block" title="Buscar">GENERAR</button>
                </div>
            </div>
        </form>

    </div>
</div>

{{-- <div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            LIBRO DE VENTAS
        </h4>
    </div>
    <div class="card-body">

        <form action="{{ url('Reporte/libroVentas') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-md-1">
                    <div class="form-group">
                        <label class="control-label">Curso</label>
                        <select name="gestion" id="gestion" class="form-control">
                            <option value="1"> 1° A&ntilde;o </option>
                            <option value="2"> 2° A&ntilde;o </option>
                            <option value="3"> 3° A&ntilde;o </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Turno</label>
                        <select name="turno" id="turno" class="form-control">
                            @foreach($turnos as $turno)
                            <option value="{{ $turno->id }}"> {{ $turno->descripcion }} </option>
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

                <div class="col-md-2">
                    <br />
                    <button type="submit" class="btn btn-success btn-block" title="Buscar">GENERA LIBRO VENTAS</button>
                </div>
            </div>
        </form>

    </div>
</div> --}}

<!-- inicio modal prerequisitos -->

<!-- fin modal prerequisitos -->

@stop