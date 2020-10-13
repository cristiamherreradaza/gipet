<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Perfile;
use App\Menu;
use App\MenusPerfile;

class PerfilController extends Controller
{
    public function listado()
    {
        $perfiles = Perfile::get();
        $menus = Menu::get();
        return view('perfil.listado')->with(compact('perfiles', 'menus'));
    }

    public function guardar(Request $request)
    {
        $perfil = new Perfile();
        $perfil->nombre = $request->nombre_perfil;
        $perfil->descripcion = $request->descripcion_perfil;
        $perfil->save();
        if($request->menus)
        {
            foreach($request->menus as $menu)
            {
                $menuperfil = new MenusPerfile();
                $menuperfil->perfil_id = $perfil->id;
                $menuperfil->menu_id = $menu;
                $menuperfil->save();
            }
        }
        return redirect('Perfil/listado');
    }

    public function ajaxListadoMenu(Request $request)
    {
        $menus = Menu::get();
        $perfil_id = $request->id;
        return view('perfil.ajaxListadoMenu')->with(compact('perfil_id', 'menus'));
    }
    public function actualizar(Request $request)
    {
        $perfil = Perfile::find($request->id);
        $perfil->nombre = $request->nombre;
        $perfil->descripcion = $request->descripcion;
        $perfil->save();
        // Eliminaremos los anteriores menus_perfiles
        $menusperfiles = MenusPerfile::where('perfil_id', $request->id)->get();
        if(count($menusperfiles) != 0)
        {
            foreach($menusperfiles as $menuperfil)
            {
                $menuperfil->delete();
            }    
        }
        // Leeremos los que se enviaron y crearemos
        if($request->menus_editar)
        {
            foreach($request->menus_editar as $menu)
            {
                $menuperfil = new MenusPerfile();
                $menuperfil->perfil_id = $perfil->id;
                $menuperfil->menu_id = $menu;
                $menuperfil->save();
            }
        }
        return redirect('Perfil/listado');
    }

    public function eliminar($id)
    {
        $perfil = Perfile::find($id);
        $perfil->delete();
        $menusperfiles = MenusPerfile::where('perfil_id', $id)->get();
        if(count($menusperfiles) != 0)
        {
            foreach($menusperfiles as $menuperfil)
            {
                $menuperfil->delete();
            }    
        }
        return redirect('Perfil/listado');
    }
}
