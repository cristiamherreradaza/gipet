@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<link href="{{ asset('assets/plugins/horizontal-timeline/css/horizontal-timeline.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>

<h1>{{ $usuario->nombres }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</h1>

<div class="row">
    <!-- Column -->
    <div class="col-lg-12">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                @foreach($gestiones as $key => $gestion)
                    @if($key == 0)
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#" role="tab" onClick='gestion(\"" + {{ $gestion->gestion }} + "\")'>{{ $gestion->gestion }}</a> 
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#" role="tab" onClick='gestion(\"" + {{ $gestion->gestion }} + "\")'>{{ $gestion->gestion }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <!-- Tab panes Lacrimosa5991376 -->
            <div class="tab-content">

                <h1>
                    hola
                </h1>
                
            </div>
        </div>
    </div>
    <!-- Column -->
</div>

@stop
@section('js')

<script src="{{ asset('assets/plugins/horizontal-timeline/js/horizontal-timeline.js') }}"></script>

<script>
function gestion(anio) {
  alert('anio');
}
</script>

@endsection
