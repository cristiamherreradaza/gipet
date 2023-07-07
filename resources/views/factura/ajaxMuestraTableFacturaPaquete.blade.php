<div class="row">
    <div class="col-md-12">
        <button class="btn btn-dark btn-sm btn-block" onclick="mandarFacturasPaquete()">Enviar</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form action="" id="formularioEnvioPaquete">
            <table class="tablesaw table-striped table-hover table-bordered table no-wrap" id="tablaPaqute">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIT</th>
                        <th>RAZON SOCIAL</th>
                        {{--  <th>NOMBRES</th>  --}}
                        <th>ACCIONES</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($facturas as $f)
                    <tr>
                            <td>{{ $f->id }}</td>
                            <td>{{ $f->nit }}</td>
                            <td>{{ $f->razon_social." | ".$f->codigo_descripcion }}</td>
                            {{--  <td>{{ $p->nombres }}</td>  --}}
                            <td>
                                {{--  <input type="text" value="{{ $f->id }}" name="facturas[]">  --}}
                                <input type="checkbox" class="form-control" checked name="check_{{ $f->id }}">
                                {{--  <button type="button" class="btn btn-success" title="PAGOS" onclick="selecciona({{ $p->id }})">
                                    <i class="fas fa-donate"></i>
                                </button>
                                <button onclick="ver_persona('{{ $p->id }}')" type="button" class="btn btn-info" title="ACADEMICO"><i class="fas fa-list"></i></button>
                                <button onclick="eliminar_persona('{{ $p->id }}', '{{ $p->cedula }}')" type="button" class="btn btn-danger" title="ELIMINAR"><i class="fas fa-trash"></i></button>  --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</div>


{{--  <script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>  --}}
{{--  <script>
    $(function () {
        $('#tablaPaqute').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
    });
</script>  --}}
