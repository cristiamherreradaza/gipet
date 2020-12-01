@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<form method="post" id="upload_form" enctype="multipart/form-data" class="upload_form mt-4">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="select_file" id="select_file">
                    <label class="custom-file-label" for="inputGroupFile04">Elegir archivo</label>
                </div>
                <div class="input-group-append">
                    <input type="submit" name="upload" id="upload" class="btn btn-success" value="Importar" style="width: 200px;">
                </div>
            </div>
        </div>
    </div>
</form>
@stop
@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/datatable-advanced.init.js') }}"></script>
<script>
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    // Script de importacion de excel
    $(document).ready(function() {
        $('.upload_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ url('Importacion/importar_2') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data)
                {
                    if(data.sw == 1){
                        Swal.fire(
                        'Hecho',
                        data.message,
                        'success'
                        ).then(function() {
                            location.reload();          //Aqui editar
                            $('#select_file').val('');
                        });
                    }else{
                        Swal.fire(
                        'Oops...',
                        data.message,
                        'error'
                        )
                    }
                }
            })
        });
    });
</script>

@endsection