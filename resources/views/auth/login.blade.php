@extends('layouts.index')

@section('content')

<div class="card-body">
    <h1 class="text-center text-info">Inicio de Sesión</h1>
    <img class="card-img-top img-responsive" src="{{ asset('assets/images/background/logo_trans.png') }}" alt="Card image cap">
    <form class="form-horizontal form-material" method="POST" action="{{ route('login') }}">
        @csrf
        <br>
        <div class="form-group ">
            <div class="col-xs-12">
                <input id="name" type="name" class="form-control  @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre de Usuario"> 
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
            </div>
        </div>
        
        <div class="form-group text-center mt-3">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light">
                    {{ __('Confirmar') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
