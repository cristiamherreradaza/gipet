@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('content')
<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>
<div class="row">
    <!-- Column -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Dynamic Form Fields</h4>
                <form action="{{ url('Prueba/guardar') }}" method="GET" >
                @csrf
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="Schoolname_1" placeholder="School Name">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" class="form-control"  name="Age_1" placeholder="Age">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <button class="btn btn-success" type="button" onclick="education_fields();"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="education_fields">
                        {{-- content --}}
                    </div>
                    <input type="text" hidden name="cantidad" id="cantidad" value="1">  
                    <div class="modal-footer">
                        <button type="submit" class="btn waves-effect waves-light btn-block btn-success" >GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
@stop
@section('js')
<!--This page JavaScript -->
<script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/jquery.repeater/repeater-init.js') }}"></script>
<script>    
    var room = 1;
    var cantidad = 1;
    function education_fields() {

        room++;
        cantidad++;
        var objTo = document.getElementById('education_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "row removeclass" + room);
        var rdiv = 'removeclass' + room;
        divtest.innerHTML = '<div class="col-sm-3">\
                                <div class="form-group">\
                                    <input type="text" class="form-control" name="Schoolname_' + room + '" placeholder="School Name">\
                                </div>\
                            </div>\
                            <div class="col-sm-2">\
                                <div class="form-group">\
                                    <input type="text" class="form-control" name="Age_' + room + '" placeholder="Age">\
                                </div>\
                            </div>\
                            <div class="col-sm-2">\
                                <div class="form-group">\
                                    <button class="btn btn-danger" type="button" onclick="remove_education_fields(' + room + ');"> <i class="fa fa-minus"></i>\
                                    </button>\
                                </div>\
                            </div>';

        objTo.appendChild(divtest)
        $('#cantidad').val(cantidad);
        // alert(room);
    }

    function remove_education_fields(rid) {
        $('.removeclass' + rid).remove();
        cantidad--;
        $('#cantidad').val(cantidad);
    }

</script>

@endsection
