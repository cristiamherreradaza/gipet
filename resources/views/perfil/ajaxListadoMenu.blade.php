<div class="form-group">
    <label class="control-label">Menus</label>
    @foreach($menus as $key => $menu)
        @php
            $menuperfil = App\MenusPerfile::where('perfil_id', $perfil_id)
                                        ->where('menu_id', $menu->id)
                                        ->first();
            if($menuperfil)
            {
                $checked = 'checked';
            }
            else
            {
                $checked = '';
            }
        @endphp
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" value="{{ $menu->id }}" id="custom-Check{{$key}}" name="menus_editar[]" {{ $checked }}>
            <label for="custom-Check{{$key}}" class="custom-control-label">
                {{ $menu->nombre }}
                @if($menu->padre)
                    @php
                        $menu = App\Menu::find($menu->padre);
                    @endphp
                    ( {{ $menu->nombre }} )
                @endif    
            </label>
        </div>
    @endforeach
</div>