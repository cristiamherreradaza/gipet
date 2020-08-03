<?php

namespace App\Http\Controllers;

use App\User;
use App\Turno;
use DataTables;
use App\Asignatura;
use App\Perfile;
use App\MenusPerfile;
use App\MenusUser;
use App\NotasPropuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    public function nuevo()
    {
        $perfiles = Perfile::get();
        return view('user.nuevo')->with(compact('perfiles'));
    }

    public function guarda(Request $request)
    {
        //dd($request->perfil);
        $user = new User();
        $user->apellido_paterno = $request->apellido_paterno;
        $user->apellido_materno = $request->apellido_materno;
        $user->nombres = $request->nombres;
        //$user->nomina = $request->nomina;
        $user->password = Hash::make($request->username);
        $user->cedula = $request->ci;
        $user->expedido = $request->expedido;
        //$user->tipo_usuario = $request->tipo;
        $user->nombre_usuario = $request->username;
        $user->fecha_incorporacion = date('Y-m-d');

        $user->vigente = 'Si';
        //$user->rol = $request->rol;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->lugar_nacimiento = $request->lugar_nacimiento;
        $user->sexo = $request->sexo;
        $user->estado_civil = $request->estado_civil;
        $user->nombre_conyugue = $request->nombre_conyugue;
        $user->nombre_hijo = $request->nombre_hijo;
        $user->direccion = $request->direccion;
        $user->zona = $request->zona;
        
        $user->numero_celular = $request->numero_celular;
        $user->numero_fijo = $request->numero_fijo;
        $user->email = $request->email;
        //$user->foto = $request->foto;
        $user->persona_referencia = $request->persona_referencia;
        $user->numero_referencia = $request->numero_referencia;
        $user->name = $request->username;
        $user->perfil_id = $request->perfil;
        $user->save();

        if($request->perfil)
        {
            $menus = MenusPerfile::where('perfil_id', $request->perfil)->get();
            if(count($menus) > 0)
            {
                foreach($menus as $menu)
                {
                    $menu_user = new MenusUser();
                    $menu_user->user_id = $user->id;
                    $menu_user->menu_id = $menu->menu_id;
                    $menu_user->save();
                }
            }
        }
        return redirect('User/listado');

    }

    public function editar($id)
    {
        $user = User::find($id);
        $perfiles = Perfile::get();
        return view('user.editar')->with(compact('user', 'perfiles'));
    }

    public function actualizar(Request $request)
    {
        $sw=0;
        $user = User::find($request->id);
        $user->apellido_paterno = $request->apellido_paterno;
        $user->apellido_materno = $request->apellido_materno;
        $user->nombres = $request->nombres;
        //$user->nomina = $request->nomina;
        //$user->password = Hash::make($request->username);
        $user->cedula = $request->ci;
        $user->expedido = $request->expedido;
        //$user->tipo_usuario = $request->tipo;
        $user->nombre_usuario = $request->username;
        //$user->fecha_incorporacion = date('Y-m-d');

        //$user->vigente = 'Si';
        //$user->rol = $request->rol;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->lugar_nacimiento = $request->lugar_nacimiento;
        $user->sexo = $request->sexo;
        $user->estado_civil = $request->estado_civil;
        $user->nombre_conyugue = $request->nombre_conyugue;
        $user->nombre_hijo = $request->nombre_hijo;
        $user->direccion = $request->direccion;
        $user->zona = $request->zona;
        
        $user->numero_celular = $request->numero_celular;
        $user->numero_fijo = $request->numero_fijo;
        $user->email = $request->email;
        //$user->foto = $request->foto;
        $user->persona_referencia = $request->persona_referencia;
        $user->numero_referencia = $request->numero_referencia;
        $user->name = $request->username;
        if($user->perfil_id != $request->perfil)
        {
            // Eliminaremos el perfil con sus respectivos menus anteriores en la tabla menusUser
            $menuusers = MenusUser::where('user_id', $user->id)->get();
            if(count($menuusers) > 0)
            {
                foreach($menuusers as $menuuser)
                {
                    $menuuser->delete();
                }
            }
            // Asignaremos nuevo perfil
            $user->perfil_id = $request->perfil;
            $sw=1;
        }        
        $user->save();

        if($sw == 1)
        {
            if($request->perfil)
            {
                $menus = MenusPerfile::where('perfil_id', $request->perfil)->get();
                if(count($menus) > 0)
                {
                    // Adicionaremos los nuevos
                    foreach($menus as $menu)
                    {
                        $menu_user = new MenusUser();
                        $menu_user->user_id = $user->id;
                        $menu_user->menu_id = $menu->menu_id;
                        $menu_user->save();
                    }
                }
            }
        }
        
        return redirect('User/listado');
        //dd($user);
    }

    public function asignar()
    {
        $users = User::where('vigente', 'si')->get();
        return view('user.asignar')->with(compact('users'));
    }

    public function listado()
    {
    	return view('user.listado');
    }

    public function ajax_listado()
    {
        //$lista_personal = User::all();
        $lista_personal = User::get();
    	return Datatables::of($lista_personal)
            ->addColumn('action', function ($lista_personal) {
                return '<button onclick="asigna_materias('.$lista_personal->id.')" class="btn btn-info" title="Asignar materias"><i class="fas fa-plus"></i></button>
                <button onclick="editar('.$lista_personal->id.')" class="btn btn-primary" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>
                <button onclick="eliminar(' . $lista_personal->id . ',\''.$lista_personal->nombre_usuario.'\')" class="btn btn-danger" title="Eliminar usuario"><i class="fas fa-minus"></i></button>';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function asigna_materias($usuario_id = null)
    {
        $gestion_vigente = date('Y');

        $datos_persona = User::find($usuario_id);

        $turnos = Turno::where('borrado', NULL)->get();

        $asignaturas = Asignatura::where('borrado', NULL)
                    ->where('anio_vigente', $gestion_vigente)
                    ->get();

        $asignaturas_docente = NotasPropuesta::where('borrado', NULL)
                            ->where('user_id', $usuario_id)
                            ->where('anio_vigente', $gestion_vigente)
                            ->get();

    	return view('user.asigna_materias')->with(compact('asignaturas', 'asignaturas_docente', 'datos_persona', 'turnos'));
    }

    public function guarda_asignacion(Request $request)
    {
        $error_duplicado = 0;
        $asignacionGuardada = 0;
        $validacion = NotasPropuesta::where('borrado', NULL)
                    ->where('asignatura_id', $request->asignatura_id)
                    ->where('user_id', $request->user_id)
                    ->where('turno_id', $request->turno_id)
                    ->where('paralelo', $request->paralelo)
                    ->where('anio_vigente', $request->anio_vigente)
                    ->count();
        // dd($validacion);

        if ($validacion > 0) {
            $error_duplicado = 1;
        }else{
            $nNotaPropuesta = new NotasPropuesta();
            $nNotaPropuesta->asignatura_id = $request->asignatura_id;   
            $nNotaPropuesta->user_id = $request->user_id;   
            $nNotaPropuesta->paralelo = $request->paralelo;   
            $nNotaPropuesta->turno_id = $request->turno_id;   
            $nNotaPropuesta->anio_vigente = $request->anio_vigente;   
            $nNotaPropuesta->save();
            $asignacionGuardada = 1;
        }

        return response()->json([
            'error_duplicado' => $error_duplicado,
            'asignacionGuardada' => $asignacionGuardada
        ]);
    }

    public function eliminaAsignacion(Request $request, $np_id)
    {
        $datosNP = NotasPropuesta::find($np_id);

        $eliminaNP = NotasPropuesta::find($np_id);
        $eliminaNP->borrado = date('Y-m-d H:i:s');
        $eliminaNP->save();
        return response()->json([
            'usuario' => $datosNP->user_id
        ]);
    }

    public function eliminar($id)
    {
        $user = User::find($id);
        $user->borrado = date('Y-m-d H:i:s');
        $user->save();
        return redirect('User/listado');
    }

    public function perfil()
    {
        return view('user.perfil');
    }

    public function actualizarImagen(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'documento' => 'required|mimes:jpeg,jpg,png|max:2048'
        ]);
        if($validation->passes()){
            $filename = time().'.'.request()->documento->getClientOriginalExtension();
            request()->documento->move(public_path('assets/images/users'), $filename);
            $usuario = User::find($request->id_usuario);
            $usuario->foto = $filename;
            $usuario->save();
            return redirect('User/perfil');
        }else{
            switch ($validation->errors()->first()) {
                default:
                    $mensaje = "Fallo al cambiar de imagen, verificar que el archivo importado sea del tipo .jpg .jpeg .png y el limite no sea mayor a 2048 kbs.";
                    break;
            }
            return redirect('User/perfil')->with('flash', $mensaje);
        }
    }

    public function actualizarPerfil(Request $request)
    {
        $user = User::find($request->id);
        $user->nombres = $request->nombres;
        $user->apellido_paterno = $request->apellido_paterno;
        $user->apellido_materno = $request->apellido_materno;
        $user->direccion = $request->direccion;
        $user->numero_fijo = $request->numero_fijo;
        $user->numero_celular = $request->numero_celular;
        $user->email = $request->email;
        $user->persona_referencia = $request->persona_referencia;
        $user->numero_referencia = $request->numero_referencia;
        $user->save();
        return redirect('home');
    }
}
