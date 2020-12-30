<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AsignaturaNotasExport;
use App\Imports\AsignaturaNotasImport;
use App\User;
use App\Predefinida;
use App\Turno;
use App\Asignatura;
use App\Perfile;
use App\Menu;
use App\MenusPerfile;
use App\MenusUser;
use App\Nota;
use App\NotasPropuesta;
use App\CarrerasPersona;
use App\Inscripcione;
use Validator;
use DataTables;

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
        $user->perfil_id = $request->perfil;
        $user->apellido_paterno = $request->apellido_paterno;
        $user->apellido_materno = $request->apellido_materno;
        $user->nombres = $request->nombres;
        //$user->nomina = $request->nomina;
        $user->password = Hash::make('123456789');
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
        
        $user->numero_celular = $request->celular;
        $user->numero_fijo = $request->numero_fijo;
        $user->email = $request->email;
        //$user->foto = $request->foto;
        $user->persona_referencia = $request->persona_referencia;
        $user->numero_referencia = $request->numero_referencia;
        $user->name = $request->username;
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
        $user = User::find($request->id_edicion);
        $user->apellido_paterno = $request->apellido_paterno_edicion;
        $user->apellido_materno = $request->apellido_materno_edicion;
        $user->nombres = $request->nombres_edicion;
        //$user->nomina = $request->nomina_edicion;
        //$user->password = Hash::make($request->username)_edicion;
        $user->cedula = $request->ci_edicion;
        $user->expedido = $request->expedido_edicion;
        //$user->tipo_usuario = $request->tipo_edicion;
        $user->nombre_usuario = $request->username_edicion;
        //$user->fecha_incorporacion = date('Y-m-d')_edicion;

        //$user->vigente = 'Si'_edicion;
        //$user->rol = $request->rol_edicion;
        $user->fecha_nacimiento = $request->fecha_nacimiento_edicion;
        $user->lugar_nacimiento = $request->lugar_nacimiento_edicion;
        $user->sexo = $request->sexo_edicion;
        $user->estado_civil = $request->estado_civil_edicion;
        $user->nombre_conyugue = $request->nombre_conyugue_edicion;
        $user->nombre_hijo = $request->nombre_hijo_edicion;
        $user->direccion = $request->direccion_edicion;
        $user->zona = $request->zona_edicion;
        
        $user->numero_celular = $request->celular_edicion;
        $user->numero_fijo = $request->numero_fijo_edicion;
        $user->email = $request->email_edicion;
        //$user->foto = $request->foto_edicion;
        $user->persona_referencia = $request->persona_referencia_edicion;
        $user->numero_referencia = $request->numero_referencia_edicion;
        $user->name = $request->username_edicion;
        // if($user->perfil_id != $request->perfil_edicion)
        // {
        //     // Eliminaremos el perfil con sus respectivos menus anteriores en la tabla menusUser
        //     $menuusers = MenusUser::where('user_id', $user->id)->get();
        //     if(count($menuusers) > 0)
        //     {
        //         foreach($menuusers as $menuuser)
        //         {
        //             $menuuser->delete();
        //         }
        //     }
        //     // Asignaremos nuevo perfil
        //     $user->perfil_id = $request->perfil_edicion;
        //     $sw=1;
        // }

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
        $user->perfil_id = $request->perfil_edicion;
        $sw=1;
        
        $user->save();

        if($sw == 1)
        {
            if($request->perfil_edicion)
            {
                $menus = MenusPerfile::where('perfil_id', $request->perfil_edicion)->get();
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

    public function ajax_asigna_materias(Request $request)
    {
        $usuario = User::find($request->usuario_id);
        return view('user.ajaxAsignaMaterias')->with(compact('usuario'));
    }

    public function ajaxEditaPerfil(Request $request)
    {
        $perfil = Perfile::find($request->perfil_id);
        $menugeneral = Menu::whereNull('padre')->get();
        $menusperfil = MenusPerfile::where('perfil_id', $perfil->id)->get();
        $usuario = User::find($request->usuario_id);
        return view('user.ajaxEditaPerfil')->with(compact('perfil', 'menusperfil', 'menugeneral', 'usuario'));
    }

    
    public function asignar()
    {
        $users = User::where('vigente', 'Si')->get();
        return view('user.asignar')->with(compact('users'));
    }

    public function listado()
    {
        $usuarios = User::get();
        $perfiles = Perfile::get();
        $menus = Menu::whereNull('padre')->get();
    	return view('user.listado')->with(compact('menus', 'perfiles', 'usuarios'));
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

    // Funcion que muestra vista para la asignacion de materias a los docentes
    public function asigna_materias($id)
    {
        $docente = User::find($id);
        $turnos = Turno::get();
        $asignaturas = Asignatura::where('anio_vigente', date('Y'))->get();
        $asignaturas_docente = NotasPropuesta::where('docente_id', $id)
                                            ->where('anio_vigente', date('Y'))
                                            ->get();
        $mallasCurriculares = Asignatura::select('anio_vigente')
                                        ->groupBy('anio_vigente')
                                        ->get();
        //return view('user.asigna_materias')->with(compact('asignaturas', 'asignaturas_docente', 'docente', 'turnos'));
        return view('user.asignacion_materias')->with(compact('asignaturas', 'asignaturas_docente', 'docente', 'turnos', 'mallasCurriculares'));
    }

    public function ajaxBusquedaAsignaciones(Request $request)
    {
        $docente            = User::find($request->docente_id);
        $gestion            = $request->gestion;
        $asignaturasMalla   = Asignatura::where('anio_vigente', $gestion)
                                        ->orderBy('carrera_id')
                                        ->orderBy('gestion')
                                        ->orderBy('orden_impresion')
                                        ->get();
        $asignaturasDocente = NotasPropuesta::where('docente_id', $docente->id)
                                        ->where('anio_vigente', $gestion)
                                        ->orderBy('carrera_id')
                                        ->orderBy('asignatura_id')
                                        ->get();
        $turnos     = Turno::get();
        $paralelos  = Inscripcione::whereNotNull('paralelo')
                                ->select('paralelo')
                                ->groupBy('paralelo')
                                ->get();
        return view('user.ajaxBusquedaAsignaciones')->with(compact('docente', 'asignaturasMalla', 'asignaturasDocente', 'turnos', 'paralelos', 'gestion'));
    }

    // Funcion que procesa la solicitud de asignacion de materias a los docentes
    public function guarda_asignacion(Request $request)
    {
        $duplicado = 'No';
        // Busca en la tabla notaspropuesta, si existe un registro que coincida con los request
        $asignatura = NotasPropuesta::where('asignatura_id', $request->asignatura_id)
                                    ->where('docente_id', $request->user_id)
                                    ->where('turno_id', $request->turno_id)
                                    ->where('paralelo', $request->paralelo)
                                    ->where('anio_vigente', $request->anio_vigente)
                                    ->first();

        $datosAsignatura = Asignatura::where('id', $request->asignatura_id)->first();
        if($asignatura){
            // Existe un registro y cambia la variable a duplicado
            $duplicado = 'Si';
        }else{
            // No existe, entonces crear un registro, previo verificaremos si se establecieron notas predefinidas
            $predefinida = Predefinida::where('activo', 'Si')->first();
            // Evaluaremos si encontro un registro que este activo
            if($predefinida){
                // Existe un registro, entonces colocar en la nota propuesta, los valores de predefinida
                $asignatura                      = new NotasPropuesta();
                $asignatura->user_id             = Auth::user()->id;
                $asignatura->asignatura_id       = $request->asignatura_id;
                $asignatura->docente_id          = $request->user_id;
                $asignatura->carrera_id          = $datosAsignatura->carrera_id;
                $asignatura->paralelo            = $request->paralelo;
                $asignatura->turno_id            = $request->turno_id;
                $asignatura->anio_vigente        = $request->anio_vigente;
                $asignatura->fecha               = date('Y-m-d');
                $asignatura->nota_asistencia     = $predefinida->nota_asistencia;
                $asignatura->nota_practicas      = $predefinida->nota_practicas;
                $asignatura->nota_puntos_ganados = $predefinida->nota_puntos_ganados;
                $asignatura->nota_primer_parcial = $predefinida->nota_primer_parcial;
                $asignatura->nota_examen_final   = $predefinida->nota_examen_final;
                $asignatura->save();
            }else{
                // No existe, entonces crear registro sin valores predefinidos
                $asignatura                = new NotasPropuesta();
                $asignatura->user_id       = Auth::user()->id;
                $asignatura->asignatura_id = $request->asignatura_id;
                $asignatura->carrera_id    = $datosAsignatura->carrera_id;
                $asignatura->docente_id    = $request->user_id;
                $asignatura->paralelo      = $request->paralelo;
                $asignatura->turno_id      = $request->turno_id;
                $asignatura->anio_vigente  = $request->anio_vigente;
                $asignatura->save();
            }
            // Si se hubieran registrado alumnos en esta materia, asignarles al docente en la tabla notas
            $notas = Nota::where('asignatura_id', $request->asignatura_id)
                        ->where('turno_id', $request->turno_id)
                        ->where('paralelo', $request->paralelo)
                        ->where('anio_vigente', $request->anio_vigente)
                        ->get();
            foreach($notas as $nota){
                $nota->docente_id = $request->user_id;
                $nota->save();
            }
        }
        return response()->json([
            'duplicado' => $duplicado
        ]);
    }

    // Funcion que elimina la asignacion de un docente a la materia que tenia asignada
    public function eliminaAsignacion(Request $request, $np_id)
    {
        $nota_propuesta = NotasPropuesta::find($np_id);
        $usuario_id = $nota_propuesta->docente_id;
        // Si existieran notas relacionadas a este docente modificar/retirar su docente_id
        $notas = Nota::where('docente_id', $nota_propuesta->docente_id)
                    ->where('asignatura_id', $nota_propuesta->asignatura_id)
                    ->where('turno_id', $nota_propuesta->turno_id)
                    ->where('paralelo', $nota_propuesta->paralelo)
                    ->where('anio_vigente', $nota_propuesta->anio_vigente)
                    ->get();
        foreach($notas as $nota){
            $nota->docente_id = NULL;
            $nota->save();
        }
        // Ahora eliminamos el registro
        $nota_propuesta->delete();
        return response()->json([
            'usuario' => $usuario_id
        ]);
        // $nota_propuesta = NotasPropuesta::find($np_id);
        // $usuario_id = $nota_propuesta->user_id;
        // // Si existieran notas relacionadas a este docente modificar/retirar su user_id
        // $notas = Nota::where('asignatura_id', $nota_propuesta->asignatura_id)
        //             ->where('turno_id', $nota_propuesta->turno_id)
        //             ->where('user_id', $nota_propuesta->user_id)
        //             ->where('paralelo', $nota_propuesta->paralelo)
        //             ->where('anio_vigente', $nota_propuesta->anio_vigente)
        //             ->get();
        // foreach($notas as $nota){
        //     $nota->user_id = NULL;
        //     $nota->save();
        // }
        // // Ahora eliminamos el registro
        // $nota_propuesta->delete();
        // return response()->json([
        //     'usuario' => $nota_propuesta->user_id
        // ]);
    }

    public function eliminar($id)
    {
        $user = User::find($id);
        // Eliminaremos los respectivos menus asignados al usuario
        $menuusers = MenusUser::where('user_id', $user->id)->get();
        if(count($menuusers) > 0)
        {
            foreach($menuusers as $menuuser)
            {
                $menuuser->delete();
            }
        }
        $user->delete();
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

    public function password(Request $request)
    {
        $usuario = User::find($request->id_password);
        $usuario->password = Hash::make($request->password);
        $usuario->save();
        return redirect('User/listado');
    }

    public function actualizarPermisosPerfil(Request $request)
    {
        if($request->permisos)
        {
            $usuario            = User::find($request->usuario_id);
            $menus_permisos     = MenusUser::where('user_id', $usuario->id)
                                        ->get();
            // Eliminamos todos los permisos correspondientes al usuario X
            foreach($menus_permisos as $menu)
            {
                $menu->delete();
            }
            // Si existen valores en el array $request->permisos
            foreach($request->permisos as $registro)
            {
                // En una variable almacenamos a los menus correspondientes al padre
                $nuevos_permisos    = Menu::where('id', $registro)
                                        ->orWhere('padre', $registro)
                                        ->get();
                if(count($nuevos_permisos) > 0)
                {
                    // Llenamos con los nuevos valores correspondientes
                    foreach($nuevos_permisos as $menu)
                    {
                        $nuevo          = new MenusUser();
                        $nuevo->user_id = $usuario->id;
                        $nuevo->menu_id = $menu->id;
                        $nuevo->save();
                    }
                }
            }
        }
        return redirect('User/listado');
    }

    public function verMaterias()
    {
        $usuarios       = User::get();
        $turnos         = Turno::get();
        $asignaturas    = Asignatura::orderBy('anio_vigente')->get();
        $paralelos      = CarrerasPersona::select('paralelo')
                                    ->groupBy('paralelo')
                                    ->get();
        $gestiones  = CarrerasPersona::select('anio_vigente')
                                    ->groupBy('anio_vigente')
                                    ->orderBy('anio_vigente', 'desc')
                                    ->get();
        $mallas     = Asignatura::select('anio_vigente')
                                ->whereNotNull('anio_vigente')
                                ->groupBy('anio_vigente')
                                ->orderBy('anio_vigente', 'desc')
                                ->get();
        return view('user.verMaterias')->with(compact('asignaturas', 'turnos', 'paralelos', 'gestiones', 'usuarios', 'mallas'));
    }

    public function ajaxVerMaterias(Request $request)
    {
        // $mallaCurricular    = Asignatura::where('anio_vigente', $request->malla)
        //                                 ->get();
        // $arrayAsignaturas   = array();
        // foreach($mallaCurricular as $materia)
        // {
        //     array_push($arrayAsignaturas, $materia->id);
        // }
        // $asignaturas    = NotasPropuesta::where('docente_id', $request->usuario)
        //                                 ->where('anio_vigente', $request->gestion)
        //                                 ->whereIn('asignatura_id', $arrayAsignaturas)
        //                                 ->groupBy('asignatura_id')
        //                                 ->get();
        // $asignaturas    = Nota::where('notas.docente_id', $request->usuario)
        //                     ->where('notas.anio_vigente', $request->gestion)
        //                     ->join('asignaturas', 'asignaturas.id', '=', 'notas.asignatura_id')
        //                     ->where('asignaturas.anio_vigente', $request->malla)
        //                     ->select('notas.*')
        //                     ->groupBy('notas.asignatura_id')
        //                     ->get();

        // ANTIGUO

        // $asignaturas    = NotasPropuesta::where('notas_propuestas.docente_id', $request->usuario)
        //                                 ->whereNull('notas_propuestas.deleted_at')
        //                                 ->where('notas_propuestas.anio_vigente', $request->gestion)
        //                                 ->join('asignaturas', 'asignaturas.id', '=', 'notas_propuestas.asignatura_id')
        //                                 ->where('asignaturas.anio_vigente', $request->malla)
        //                                 ->select('notas_propuestas.*')
        //                                 ->groupBy('notas_propuestas.asignatura_id')
        //                                 ->get();
        // $docente        = User::find($request->usuario);

        // $materias       = Inscripcione::where('inscripciones.anio_vigente', $request->gestion)
        //                             ->join('asignaturas', 'asignaturas.id', '=', 'inscripciones.asignatura_id')
        //                             ->where('asignaturas.anio_vigente', $request->malla)
        //                             ->select('inscripciones.*')
        //                             ->groupBy('inscripciones.asignatura_id')
        //                             ->get();

        // Busqueda de las notas

        $materias  = Inscripcione::where('asignatura_id', $request->asignatura)
                                ->where('turno_id', $request->turno)
                                ->where('paralelo', $request->paralelo)
                                ->where('anio_vigente', $request->gestion)
                                ->groupBy('asignatura_id')
                                ->get();

        //dd($materias);
        return view('user.ajaxVerMaterias')->with(compact('asignaturas', 'docente', 'materias'));
    }
    
    public function formatoExcelAsignatura($asignatura_id, $turno_id, $paralelo, $anio_vigente)
    {
        return Excel::download(new AsignaturaNotasExport($asignatura_id, $turno_id, $paralelo, $anio_vigente), date('Y-m-d').'-formatoAsignaturasImportacion.xlsx');
    }
    
    public function importarNotasAsignaturas(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xlsx|max:2048'
        ]);
        if($validation->passes())
        {
            // // Buscaremos el valor maximo de importacion
            // $maximo = CarrerasPersona::max('numero_importacion');
            // if($maximo)
            // {
            //     $numero = $maximo + 1;
            // }
            // else
            // {
            //     $numero = 1;
            // }
            // // Creamos variables de sesión para pasar al import
            // session(['numero' => $numero]);
            $file = $request->file('select_file');
            Excel::import(new AsignaturaNotasImport, $file);
            // Eliminamos variables de sesión
            // session()->forget('numero');
            return response()->json([
                'message' => 'Importacion realizada con exito',
                'sw' => 1
            ]);
        }
        else
        {
            switch ($validation->errors()->first()) {
                case "The select file field is required.":
                    $mensaje = "Es necesario agregar un archivo excel.";
                    break;
                case "The select file must be a file of type: xlsx.":
                    $mensaje = "El archivo debe ser del tipo: xlsx.";
                    break;
                default:
                    $mensaje = "Fallo al importar el archivo seleccionado.";
                    break;
            }
            return response()->json([
                //0
                'message' => $mensaje,
                'sw' => 0
            ]);
        }
    }

}