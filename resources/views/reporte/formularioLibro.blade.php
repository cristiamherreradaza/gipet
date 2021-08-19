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

        <form action="{{ url('Reporte/libroVentas') }}" method="POST" id="formulario-libro">
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

                <div class="col-md-3">
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
                    <br />
                    <button type="submit" formtarget="_blank" class="btn btn-danger" title="Buscar" name="boton" value="pdf"><i class="mr-2 mdi mdi-file-pdf"></i> PDF</button>
                    <button type="submit" formtarget="_blank" class="btn btn-success" title="Buscar" name="boton" value="excel"><i class="mr-2 mdi mdi-file-excel-box"></i> EXCEL</button>
                </div>
            </div>
        </form>

    </div>
</div>
@stop