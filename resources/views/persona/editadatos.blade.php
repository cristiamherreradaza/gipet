@if ($persona->estado == null)
    <h3 class="text-success">FORMULARIO EDICION DE ACCESOS </h3>
    <div class="row">
        <div class="col-md-6">
            ESTUDIANTES: <span class="text-info text-bold">{{ $persona->apellido_paterno." ".$persona->apellido_materno." ".$persona->nombres }}</span>
        </div>
        <div class="col-md-6">
            CEDULA: <span class="text-info text-bold">{{ $persona->cedula }}</span>
        </div>
    </div>
    <hr>
    <form action="" id="formulario-edita-userPass">
        @csrf
        <input type="hidden" value="{{ $persona->id }}" name="persona_id">
        <div class="row">
            <div class="col-md-6">
                <label for="">USUARIO<b class="text-danger">*</b></label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="{{$persona->usuario}}" required placeholder="Escriba su usuario">
            </div>
            <div class="col-md-6">
                <label for="">CONTRASEÑA<b class="text-danger">*</b></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Escriba su contraseña">
                <small class="text-danger">Si no desea cambiar su contraseña, deje en blanco</small>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-success btn-block" onclick="guardardatosUserPass()">GUARDAR MIS DATOS</button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-danger btn-block" onclick="volerIntentar()">CANCELAR</button>
            </div>
        </div>
        <br>
    </form>
@elseif ($persona->cantidad_intentos == 1)
    <h3 class="text-success">VERIFICACION DE DATOS PERSONALES - ESTUDIANTES </h3>
    <form action="" id="formulario-edita-persona">
        @csrf
        <input type="hidden" value="{{ $persona->id }}" name="persona_id">
        <div class="row">
            <div class="col-md-4">
                <label for="">APELLIDO PATERNO<b class="text-danger">*</b></label>
                <input style="text-transform:uppercase" type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="{{$persona->apellido_paterno}}" required placeholder="Apellido Parterno" disabled>
                <small class="text-danger" id="_apellido_paterno"></small>
            </div>
            <div class="col-md-4">
                <label for="">APELLIDO MATERNO<b class="text-danger">*</b></label>
                <input  style="text-transform:uppercase" type="text" class="form-control" id="apellido_materno" name="apellido_materno"  value="{{$persona->apellido_materno}}" required placeholder="Apellido Materno" disabled>
                <small class="text-danger" id="_apellido_materno"></small>
            </div>
            <div class="col-md-4">
                <label for="">NOMBRES<b class="text-danger">*</b></label>
                <input  style="text-transform:uppercase" type="text" class="form-control" id="nombres" name="nombres" value="{{$persona->nombres}}" required placeholder="Nombres Completos" disabled>
                <small class="text-danger" id="_nombres"></small>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <label for="">FECHA DE NACIMIENTO<b class="text-danger">*</b></label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{$persona->fecha_nacimiento}}" required disabled>
                <small class="text-danger" id="_fecha_nacimiento"></small>
            </div>
            <div class="col-md-4">
                <label for="">GENERO<b class="text-danger">*</b></label>
                <select class="form-control"  id="genero" name="genero" required disabled>
                    <option value="Masculino" {{($persona->sexo == 'Masculino')? 'selected': ''}}>Masculino</option>
                    <option value="Femenino" {{($persona->sexo == 'Femenino')? 'selected': ''}}>Femenino</option>
                </select>
                <small class="text-danger" id="_genero"></small>
            </div>
            <div class="col-md-4">
                <label for="">CEDULA DE IDENTIDAD<b class="text-danger">*</b></label>
                <input type="text" class="form-control" id="cedula" name="cedula"  value="{{$persona->cedula}}" required placeholder="Cedula de Identidad" disabled>
                <small class="text-danger" id="_cedula"></small>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <label for="">EXPEDIDO CEDULA<b class="text-danger">*</b></label>
                <select name="expedido" id="expedido" class="form-control" required disabled>
                    <option {{ ($persona->expedido == "La Paz")? 'selected': '' }} value="La Paz">La Paz</option>
                    <option {{ ($persona->expedido == "Oruro")? 'selected': '' }} value="Oruro">Oruro</option>
                    <option {{ ($persona->expedido == "Potosi")? 'selected': '' }} value="Potosi">Potosi</option>
                    <option {{ ($persona->expedido == "Cochabamba")? 'selected': '' }} value="Cochabamba">Cochabamba</option>
                    <option {{ ($persona->expedido == "Chuquisaca")? 'selected': '' }} value="Chuquisaca">Chuquisaca</option>
                    <option {{ ($persona->expedido == "Tarija")? 'selected': '' }} value="Tarija">Tarija</option>
                    <option {{ ($persona->expedido == "Pando")? 'selected': '' }} value="Pando">Pando</option>
                    <option {{ ($persona->expedido == "Beni")? 'selected': '' }} value="Beni">Beni</option>
                    <option {{ ($persona->expedido == "Santa Cruz")? 'selected': '' }} value="Santa Cruz">Santa Cruz</option>
                </select>
                <small class="text-danger" id="_expedido"></small>
            </div>
            <div class="col-md-4">
                <label for="">NUMERO DE CELULAR<b class="text-danger">*</b></label>
                <input type="text" class="form-control" name="numero_celular" id="numero_celular" value="{{$persona->numero_celular}}" required placeholder="Numero de celular" disabled>
                <small class="text-danger" id="_numero_celular"></small>
            </div>
            <div class="col-md-4">
                <label for="">CORREO ELECTRONICO</label>
                <input type="text" class="form-control" name="correo_electronico" id="correo_electronico" value="{{$persona->email}}" placeholder="Correo Electronico" disabled>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-8">
                <label for="">REFERENCIA FAMILIAR</label>
                <input style="text-transform:uppercase" type="text" class="form-control"  name="referencia_familiar" id="referencia_familiar" value="{{$persona->nombre_padre}}" placeholder="Nombres Referencia" disabled>
            </div>
            <div class="col-md-4">
                <label for="">NUMERO DE CELULAR</label>
                <input type="text" class="form-control"  name="referencia_familiar_celular" id="referencia_familiar_celular" value="{{$persona->celular_padre}}" placeholder="Numero de la Referencia personal" disabled>
                <small>Numero de la referencia personal</small>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <label for="">Direccion de Domicilio</label>
                <textarea style="text-transform:uppercase"  class="form-control" name="direccion_domicilio" id="direccion_domicilio" cols="30" rows="2" placeholder="Direccion de domicilio" disabled>{{$persona->direccion}}</textarea>
            </div>
        </div>
        <br>
        {{--  <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-success btn-block" onclick="guardardatos()">GUARDAR MIS DATOS</button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-danger btn-block" onclick="volerIntentar()">CANCELAR</button>
            </div>
        </div>  --}}
        <br>
    </form>
@else

    <table class="table table-hover text-center">
        <thead>
            <tr>
                <th>Ap Paterno</th>
                <th>Ap Materno</th>
                <th>Nombres</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $persona->apellido_paterno }}</td>
                <td>{{ $persona->apellido_materno }}</td>
                <td>{{ $persona->nombres }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover text-center">
        <thead>
            <tr>
                <th>Fecha Nacimiento</th>
                <th>Genero</th>
                <th>N° Cedula</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ date('d/m/Y', strtotime($persona->fecha_nacimiento)) }}</td>
                <td>{{ $persona->sexo }}</td>
                <td>{{ $persona->cedula }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover text-center">
        <thead>
            <tr>
                <th>Expedido Cedula</th>
                <th>N° Celular</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $persona->expedido }}</td>
                <td>{{ $persona->numero_celular }}</td>
                <td>{{ $persona->email }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover text-center">
        <thead>
            <tr>
                <th>Referencia Familiar</th>
                <th>N° Celular referencia</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $persona->nombre_padre }}</td>
                <td>{{ $persona->celular_padre }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover text-center">
        <thead>
            <tr>
                <th>Direccion de Domicilio</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $persona->direccion }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <hr>
    <button class="btn btn-success btn-block" onclick="volerIntentar()">Volver</button>
    <hr>
    <br>
@endif
