<div class="col-lg-12">
        <div class="card border-danger">
            <div class="card-header bg-danger">
                <h4 class="mb-0 text-white" id="nombre_carrera">Datos de la Carrera</h4>
            </div>
                <div class="card-body">
                    <div class="row" id="tabsProductos">
                        <div class="col-md-2">
                            <button type="button" id="tab1" class="btn btn-block btn-inverse activo">INCRIPCIONES - NOTAS</button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="tab2" class="btn btn-block btn-primary inactivo">MODIFICAR</button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="tab3" class="btn btn-block btn-warning inactivo">MOSTRAR</button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="tab4" class="btn btn-block btn-info inactivo">REGISTRO</button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="tab5" class="btn btn-block btn-success inactivo">MOSTRAR</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 tabContenido" id="tab1C">
                            <div class="card border-inverse">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="demo-foo-row-toggler" class="table table-bordered no-wrap"
                                            data-toggle-column="first">
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Codigo Asignatura</th>
                                                    <th>Asignatura</th>
                                                    <th>1er Bimestre</th>
                                                    <th>2do Bimestre</th>
                                                    <th>3er Bimestre</th>
                                                    <th>4to Bimestre</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $num = 1;
                                                @endphp
                                                @foreach ($inscripciones as $insc)
                                                    @php
                                                        $asig = DB::select("SELECT *
                                                                                FROM asignaturas
                                                                                WHERE id = '$insc->asignatura_id'");
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $num++ }}</td>
                                                        <td>{{ $asig[0]->codigo_asignatura }}</td>
                                                        <td>{{ $asig[0]->nombre_asignatura }}</td>
                                                        @php
                                                            $nota1 = DB::select("SELECT nota.*
                                                                                FROM notas nota, (SELECT MAX(id) as id
                                                                                                FROM notas 
                                                                                                WHERE asignatura_id = '481'
                                                                                                AND turno_id = '$insc->turno_id'
                                                                                                AND persona_id = '$insc->persona_id'
                                                                                                AND paralelo = '$insc->paralelo'
                                                                                                AND anio_vigente = '$insc->anio_vigente'
                                                                                                AND trimestre = '1'
                                                                                                GROUP BY asignatura_id)tmp
                                                                                WHERE nota.id = tmp.id
                                                                                ORDER BY nota.id ASC");
                                                        @endphp
                                                        <td>{{ $nota1[0]->nota_total }}</td>
                                                        @php
                                                            $nota2 = DB::select("SELECT nota.*
                                                                                FROM notas nota, (SELECT MAX(id) as id
                                                                                                FROM notas
                                                                                                WHERE asignatura_id = '481'
                                                                                                AND turno_id = '$insc->turno_id'
                                                                                                AND persona_id = '$insc->persona_id'
                                                                                                AND paralelo = '$insc->paralelo'
                                                                                                AND anio_vigente = '$insc->anio_vigente'
                                                                                                AND trimestre = '2'
                                                                                                GROUP BY asignatura_id)tmp
                                                                                WHERE nota.id = tmp.id
                                                                                ORDER BY nota.id ASC");
                                                        @endphp
                                                        <td>{{ $nota2[0]->nota_total }}</td>
                                                        @php
                                                            $nota3 = DB::select("SELECT nota.*
                                                                                FROM notas nota, (SELECT MAX(id) as id
                                                                                                FROM notas 
                                                                                                WHERE asignatura_id = '481'
                                                                                                AND turno_id = '$insc->turno_id'
                                                                                                AND persona_id = '$insc->persona_id'
                                                                                                AND paralelo = '$insc->paralelo'
                                                                                                AND anio_vigente = '$insc->anio_vigente'
                                                                                                AND trimestre = '3'
                                                                                                GROUP BY asignatura_id)tmp
                                                                                WHERE nota.id = tmp.id
                                                                                ORDER BY nota.id ASC");
                                                        @endphp
                                                        <td>{{ $nota3[0]->nota_total }}</td>
                                                        @php
                                                            $nota4 = DB::select("SELECT nota.*
                                                                                FROM notas nota, (SELECT MAX(id) as id
                                                                                                FROM notas 
                                                                                                WHERE asignatura_id = '481'
                                                                                                AND turno_id = '$insc->turno_id'
                                                                                                AND persona_id = '$insc->persona_id'
                                                                                                AND paralelo = '$insc->paralelo'
                                                                                                AND anio_vigente = '$insc->anio_vigente'
                                                                                                AND trimestre = '4'
                                                                                                GROUP BY asignatura_id)tmp
                                                                                WHERE nota.id = tmp.id
                                                                                ORDER BY nota.id ASC");
                                                        @endphp
                                                        <td>{{ $nota4[0]->nota_total }}</td>
                                                        @php
                                                            if($insc->nota > 70){
                                                        @endphp
                                                        <td><span class="badge py-1 badge-success">{{ $insc->nota }}</span> </td>
                                                        @php
                                                            } else {
                                                        @endphp
                                                        <td><span class="badge py-1 badge-danger">{{ $insc->nota }}</span> </td>
                                                        @php
                                                            }
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        
                            </div>
                        </div>
                        <div class="col-md-12 tabContenido" id="tab2C" style="display: none;">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <div class="form-body">
                                        <!--/row-->
                                        <!-- NOMBRE DEL ATRIBUTO ENCIMA -->
                                        <div class="row pt-3">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Trabaja 
                                                        <span class="text-danger">
                                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                                        </span>
                                                    </label>
                                                    <select class="form-control" id="trabaja" name="trabaja" required>
                                                        <option value="">Seleccionar</option>
                                                        <option value="Si">Si</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- row -->
                                        <div class="row pt-3">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Nombre de la Empresa</label>
                                                    <input type="text" id="empresa" class="form-control" name="empresa">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Direcci&oacute;n de la Empresa</label>
                                                    <input type="text" id="direccion_empresa" class="form-control" name="direccion_empresa">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Telefono de la Empresa</label>
                                                    <input type="text" id="telefono_empresa" class="form-control" name="telefono_empresa">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Fax</label>
                                                    <input type="text" id="fax" class="form-control" name="fax">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Email Empresa</label>
                                                    <input type="email" id="email_empresa" class="form-control" name="email_empresa">
                                                </div>
                                            </div>
                                        </div>  
                                        <!-- row -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 tabContenido" id="tab3C" style="display: none;">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Nombre Padre </label>
                                                    <input type="text" class="form-control" name="nombre_padre" id="nombre_padre">
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Celular Padre </label>
                                                    <input type="text" class="form-control" name="celular_padre" id="celular_padre">
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Nombre Madre </label>
                                                    <input type="text" class="form-control" name="nombre_madre" id="nombre_madre">
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Celular Madre </label>
                                                    <input type="text" class="form-control" name="celular_madre" id="celular_madre">
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Nombre Tutor </label>
                                                    <input type="text" class="form-control" name="nombre_tutor" id="nombre_tutor">
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Celular Tutor </label>
                                                    <input type="text" class="form-control" name="telefono_tutor" id="telefono_tutor">
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Nombre Esposo </label>
                                                    <input type="text" class="form-control" name="nombre_esposo" id="nombre_esposo">
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Celular Esposo </label>
                                                    <input type="text" class="form-control" name="telefono_esposo" id="telefono_esposo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 tabContenido" id="tab4C" style="display: none;">
                            <div class="card border-info">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Carrera
                                                    <span class="text-danger">
                                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                                    </span>
                                                </label>
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="carrera_1" name="carrera_1">
                                                    <option value="0">Seleccionar</option>
                                                    {{-- @foreach($carreras as $carre)
                                                    <option value="{{ $carre->id }}">{{ $carre->nombre }}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Turno
                                                    <span class="text-danger">
                                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                                    </span>
                                                </label>
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_1" name="turno_1">
                                                    <option value="">Seleccionar</option>
                                                    {{-- @foreach($turnos as $tur)
                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Paralelo
                                                    <span class="text-danger">
                                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                                    </span>
                                                </label>
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_1" name="paralelo_1">
                                                    <option value="">Seleccionar</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="control-label">Gesti&oacute;n</label>
                                                <input type="text" class="form-control" id="gestion_1" name="gestion_1" value="2020">
                                            </div>
                                        </div>
                                        <input type="text" hidden name="cantidad" id="cantidad" value="1">
                                        <input type="text" hidden name="numero[]" id="numero" value="1">    
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-12">
                                            <div class="form-group">
                                                <button class="btn btn-success" type="button" onclick="education_fields();">ADICIONAR CARRERA</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="education_fields">
                                        {{-- content --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 tabContenido" id="tab5C" style="display: none;">
                            <div class="card border-success">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Asignatura
                                                    <span class="text-danger">
                                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                                    </span>
                                                </label>
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_1" name="asignatura_1">
                                                    <option value="0">Seleccionar</option>
                                                    {{-- @foreach($asignaturas as $asig)
                                                    <option value="{{ $asig->id }}">{{ $asig->nombre_asignatura }}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Turno
                                                    <span class="text-danger">
                                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                                    </span>
                                                </label>
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_asig_1" name="turno_asig_1">
                                                    <option value="">Seleccionar</option>
                                                    {{-- @foreach($turnos as $tur)
                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Paralelo
                                                    <span class="text-danger">
                                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                                    </span>
                                                </label>
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_asig_1" name="paralelo_asig_1">
                                                    <option value="">Seleccionar</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="control-label">Gesti&oacute;n</label>
                                                <input type="text" class="form-control" id="gestion_asig_1" name="gestion_asig_1" value="2020">
                                            </div>
                                        </div>
                                        <input type="text" hidden name="cantidad_asig" id="cantidad_asig" value="1">
                                        <input type="text" hidden name="numero_asig[]" id="numero_asig" value="1">    
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-12">
                                            <div class="form-group">
                                                <button class="btn btn-info" type="button" onclick="education_fieldss();">ADICIONAR ASIGNATURAS</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="education_fieldss">
                                        {{-- content --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn waves-effect waves-light btn-block btn-success">Guardar</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn waves-effect waves-light btn-block btn-inverse" onclick="cerrar_datos_carrera()">Cerrar</button>
                        </div>
                    </div>

                </div>
            

        </div>
    </div>