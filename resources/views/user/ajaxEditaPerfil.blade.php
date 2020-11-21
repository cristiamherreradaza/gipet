<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">EDITAR PERMISOS</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <form action="{{ url('User/actualizarPermisosPerfil') }}"  method="POST" >
        @csrf
        <div class="modal-body">
            <input type="hidden" name="usuario_id" id="usuario_id" value="{{ $usuario->id }}">
            <input type="hidden" name="perfil_id" id="perfil_id" value="{{ $perfil->id }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Menus</label>
                        @foreach($menugeneral as $key => $menu)
                            @php
                                $consulta = App\MenusUser::where('user_id', $usuario->id)->where('menu_id', $menu->id)->count();
                                if($consulta > 0)
                                {
                                    $checkeado = 'checked';
                                }
                                else
                                {
                                    $checkeado = '';
                                }
                            @endphp
                            <div class="col-sm-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input cajas" value="{{ $menu->id }}" id="customCheck-{{$key}}" name="permisos[]" {{ $checkeado }}>
                                    <label for="customCheck-{{$key}}" class="custom-control-label">{{ $menu->nombre }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizar_perfil()">ACTUALIZAR PERFIL</button>
        </div>
    </form>
</div>