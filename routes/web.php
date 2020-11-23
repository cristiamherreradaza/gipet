<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('logueo', function () {
    return view('layouts.index');
});

Route::get('/', 'Auth\LoginController@inicio');

// Route::get('user/{id}', function($id){
//     return 'Bienvenido '.$id_demo;
// });

// Route::get('users/{id}', function ($id) {
    
// });

Route::get('prueba/inicia', 'PruebaController@inicia'); 

Route::get('listado', 'PruebaController@listado'); 

Route::get('detalle_alumno', 'PruebaController@detalle_alumno');

Route::get('Prueba/guardar', 'PruebaController@guardar'); 

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('prueba/tabla', 'CarreraController@tabla'); 

    Route::post('carrera/store', 'CarreraController@store'); 

    Route::get('persona/nuevo', 'PersonaController@nuevo'); 
    Route::post('persona/guarda', 'PersonaController@guarda');
    Route::get('Persona/listado', 'PersonaController@listado');
    Route::get('Persona/ajax_listado', 'PersonaController@ajax_listado');
    Route::get('Persona/ver_persona', 'PersonaController@ver_persona');
    Route::get('Persona/ajax_asignaturas_adicionales/{persona_id}', 'PersonaController@ajax_asignaturas_adicionales');
    Route::get('Persona/verifica', 'PersonaController@verifica');
    Route::get('Persona/ver_detalle/{id}', 'PersonaController@ver_detalle');
    // Route::get('persona/ajax_datos', function () {
        // return datatables()->query(DB::table('personas'))->toJson();
    // });
    Route::get('persona/exportarexcel', 'PersonaController@exportarExcel')->name('personas.exportarexcel');
    //
    Route::get('Persona/crear_persona', 'PersonaController@crear_persona');
    Route::post('Persona/guardar_nuevos', 'PersonaController@guardar_nuevos');
    Route::post('Persona/actualizar', 'PersonaController@actualizar');
    Route::get('Persona/ajaxDetalleHistorialAcademico', 'PersonaController@ajaxDetalleHistorialAcademico');
    Route::get('Persona/ajaxDetallePensum', 'PersonaController@ajaxDetallePensum');
    Route::get('Persona/ajaxDetalleMaterias', 'PersonaController@ajaxDetalleMaterias');
    Route::get('Persona/ajaxDetalleCarreras', 'PersonaController@ajaxDetalleCarreras');
    Route::get('Persona/ajaxDetalleHistorialInscripciones', 'PersonaController@ajaxDetalleHistorialInscripciones');
    Route::get('Persona/ajaxDetalleCertificados', 'PersonaController@ajaxDetalleCertificados');
    Route::get('Persona/ajaxDetalleMensualidades', 'PersonaController@ajaxDetalleMensualidades');
    Route::get('Persona/ajaxDetalleExtras', 'PersonaController@ajaxDetalleExtras');

    Route::get('user/asignar', 'UserController@asignar');

    //NOTAS
    Route::get('nota/listado', 'NotaController@listado');

    Route::get('nota/detalle/{id}', 'NotaController@detalle');

    //Route::get('nota/exportarexcel/{id}', 'NotaController@exportarexcel');
    Route::get('nota/exportarexcel/{asignatura_id}/{bimestre}', 'NotaController@exportarexcel');
    Route::get('Nota/finalizarBimestre/{nota_propuesta_id}/{bimestre}', 'NotaController@finalizarBimestre');
    Route::post('Nota/segundoTurno', 'NotaController@segundoTurno');

    Route::post('nota/actualizar', 'NotaController@actualizar');

    Route::post('nota/ajax_importar', 'NotaController@ajax_importar');

    Route::get('Nota/ajaxMuestraNota', 'NotaController@ajaxMuestraNota');
    //NOTAS PROPUESTA
    Route::get('notaspropuesta/listado', 'NotasPropuestaController@listado');

    Route::get('notaspropuesta/exportarexcel/{id}', 'NotasPropuestaController@exportarexcel');

    Route::post('notaspropuesta/actualizar', 'NotasPropuestaController@actualizar');

    Route::post('notaspropuesta/ajax_importar', 'NotasPropuestaController@ajax_importar');

    //MIGRACIONES
    Route::get('Migracion/inicia', 'MigracionController@inicia');
    Route::get('Migracion/usuario', 'MigracionController@usuario');
    Route::get('Migracion/asignatura', 'MigracionController@asignatura');
    Route::get('Migracion/notas_propuestas', 'MigracionController@notas_propuestas');
    Route::get('Migracion/asignaturas_prerequisitos', 'MigracionController@asignaturas_prerequisitos');
    Route::get('Migracion/persona', 'MigracionController@persona');
    Route::get('Migracion/datosKardex', 'MigracionController@datosKardex');
    Route::get('Migracion/docentes', 'MigracionController@docentes');
    Route::get('Migracion/notas', 'MigracionController@notas');
    Route::get('Migracion/notas2', 'MigracionController@notas2');
    Route::get('Migracion/convalidacion', 'MigracionController@convalidacion');
    Route::get('Migracion/notas3', 'MigracionController@notas3');
    Route::get('Migracion/notasInscrtipciones', 'MigracionController@notasInscrtipciones');
    Route::get('Migracion/llenaParalelos', 'MigracionController@llenaParalelos');
    Route::get('Migracion/llenaNotas', 'MigracionController@llenaNotas');

    //INSCRIPCIONES
    Route::get('Inscripcion/inscripcion', 'InscripcionController@inscripcion');

    Route::get('Inscripcion/busca_ci', 'InscripcionController@busca_ci');

    Route::get('Inscripcion/selecciona_asignatura', 'InscripcionController@selecciona_asignatura');

    Route::post('Inscripcion/store', 'InscripcionController@store');

    Route::get('Inscripcion/lista', 'InscripcionController@lista');

    Route::get('Inscripcion/ajax_datos', 'InscripcionController@ajax_datos');

    Route::post('Inscripcion/re_inscripcion', 'InscripcionController@re_inscripcion');

    Route::get('Inscripcion/asignaturas_a_tomar', 'InscripcionController@asignaturas_a_tomar');

    Route::get('Inscripcion/tomar_asignaturas/{persona_id}', 'InscripcionController@tomar_asignaturas');

    Route::get('Inscripcion/vista', 'InscripcionController@vista');

    Route::get('Inscripcion/ver_persona/{persona_id}', 'InscripcionController@ver_persona');

    Route::post('Inscripcion/guardar', 'InscripcionController@guardar');

    Route::post('Inscripcion/inscribirCarrera', 'InscripcionController@inscribirCarrera');

    //inscripciones
    Route::get('Inscripcion/nuevo', 'InscripcionController@nuevo');
    Route::get('Inscripcion/reinscripcion/{id}', 'InscripcionController@reinscripcion');
    Route::post('Inscripcion/ajaxBuscaAsignatura', 'InscripcionController@ajaxBuscaAsignatura');
    Route::post('Inscripcion/guarda_reinscripcion', 'InscripcionController@guarda_reinscripcion');
    //Route::get('Inscripcion/reinscripcion', 'InscripcionController@reinscripcion');
    Route::get('Inscripcion/varios', 'InscripcionController@varios');
    Route::get('Inscripcion/recuperatorio', 'InscripcionController@recuperatorio');
    Route::get('Inscripcion/buscar_recuperatorio', 'InscripcionController@buscar_recuperatorio');
    Route::get('Inscripcion/reinscripcion/{personaId}/{carreraId}', 'InscripcionController@reinscripcion');


    Route::get('Inscripcion/ajaxMuestraNotaInscripcion', 'InscripcionController@ajaxMuestraNotaInscripcion');
    Route::post('Inscripcion/actualizaNotaInscripcion', 'InscripcionController@actualizaNotaInscripcion');
    Route::get('Inscripcion/ajaxMuestraInscripcion', 'InscripcionController@ajaxMuestraInscripcion');
    Route::get('Inscripcion/inscribirCursoCorto/{persona_id}/{asignatura_id}', 'InscripcionController@inscribirCursoCorto');
    Route::get('Inscripcion/ajaxVerCursoCorto', 'InscripcionController@ajaxVerCursoCorto');
    Route::post('Inscripcion/actualizaCursoCorto', 'InscripcionController@actualizaCursoCorto');
    Route::get('Inscripcion/eliminarCursoCorto/{id}', 'InscripcionController@eliminarCursoCorto');

    // PDFS
    Route::get('Inscripcion/reportePdfHistorialAcademico/{persona_id}/{carrera_id}', 'InscripcionController@reportePdfHistorialAcademico');
    Route::get('Inscripcion/boletin/{id}', 'InscripcionController@boletin');

    Route::get('Inscripcion/pruebapdf', 'InscripcionController@pruebapdf')->name('users.pdf');      //ELIMINAR


    // ADMINISTRACION
    Route::post('Asignatura/guarda', 'AsignaturaController@guarda');
    Route::get('Carrera/listado', 'CarreraController@listado');
    Route::get('Carrera/ajax_lista_asignaturas', 'CarreraController@ajax_lista_asignaturas');
    Route::get('Asignatura/listado_malla/{carrera_id}', 'AsignaturaController@listado_malla');
    Route::get('Asignatura/eliminar/{asignatura_id}', 'AsignaturaController@eliminar');
    Route::get('Asignatura/asignaturas_equivalentes', 'AsignaturaController@asignaturas_equivalentes');
    Route::get('Asignatura/ajax_lista', 'AsignaturaController@ajax_lista');
    Route::post('Asignatura/guarda_equivalentes', 'AsignaturaController@guarda_equivalentes');
    Route::get('Asignatura/elimina_equivalentes/{id}', 'AsignaturaController@elimina_equivalentes');

    Route::get('User/nuevo', 'UserController@nuevo');
    Route::post('User/guarda', 'UserController@guarda');
    Route::get('User/editar/{user_id}', 'UserController@editar');
    Route::post('User/actualizar', 'UserController@actualizar');
    Route::get('User/eliminar/{user_id}', 'UserController@eliminar');
    Route::post('User/guarda_asignacion', 'UserController@guarda_asignacion');
    Route::get('User/listado', 'UserController@listado');
    Route::get('User/ajax_listado', 'UserController@ajax_listado');
    //Route::get('User/asigna_materias/{user_id}', 'UserController@asigna_materias');
    Route::get('User/eliminaAsignacion/{np_id}', 'UserController@eliminaAsignacion');
    Route::get('User/perfil', 'UserController@perfil');
    Route::post('User/actualizarImagen', 'UserController@actualizarImagen');
    Route::post('User/actualizarPerfil', 'UserController@actualizarPerfil');
    Route::post('User/password', 'UserController@password');
    Route::get('Persona/detalle/{persona_id}', 'PersonaController@detalle');
    Route::get('Persona/ajax_materias/{carrera_id}/{persona_id}/{anio_vigente}', 'PersonaController@ajax_materias');
    Route::get('User/ajaxEditaPerfil', 'UserController@ajaxEditaPerfil');
    Route::post('User/actualizarPermisosPerfil', 'UserController@actualizarPermisosPerfil');
    Route::get('User/asigna_materias/{id}', 'UserController@asigna_materias');

    Route::get('Asignatura/ajax_muestra_prerequisitos/{asignatura_id}', 'AsignaturaController@ajax_muestra_prerequisitos');
    Route::get('Asignatura/elimina_prerequisito/{prerequisito_id}', 'AsignaturaController@elimina_prerequisito');
    Route::get('Carrera/ajax_combo_materias/{carrera_id}/{anio_vigente}', 'CarreraController@ajax_combo_materias');
    Route::post('Asignatura/guarda_prerequisito', 'AsignaturaController@guarda_prerequisito');

    Route::get('Carrera/listado_nuevo', 'CarreraController@listado_nuevo');
    Route::post('Carrera/guardar', 'CarreraController@guardar');
    Route::post('Carrera/actualizar', 'CarreraController@actualizar');
    Route::get('Carrera/eliminar/{id}', 'CarreraController@eliminar');
    Route::get('Carrera/vista_impresion/{id}', 'CarreraController@vista_impresion');
    Route::get('Carrera/ajaxEditaCarrera', 'CarreraController@ajaxEditaCarrera');

    Route::get('Descuento/listado', 'DescuentoController@listado');
    Route::post('Descuento/guardar', 'DescuentoController@guardar');
    Route::post('Descuento/actualizar', 'DescuentoController@actualizar');
    Route::get('Descuento/eliminar/{id}', 'DescuentoController@eliminar');

    Route::get('Servicio/listado', 'ServicioController@listado');
    Route::post('Servicio/guardar', 'ServicioController@guardar');
    Route::post('Servicio/actualizar', 'ServicioController@actualizar');
    Route::get('Servicio/eliminar/{id}', 'ServicioController@eliminar');
    Route::get('Servicio/listar', 'ServicioController@listar');
    Route::get('Servicio/ajax_lista_cursos', 'ServicioController@ajax_lista_cursos');
    Route::post('Servicio/ajax_guardar_servicio_asignatura', 'ServicioController@ajax_guardar_servicio_asignatura');
    Route::get('Servicio/ajax_verifica_codigo_asignatura', 'ServicioController@ajax_verifica_codigo_asignatura');
    Route::get('Servicio/ajax_verifica_nombre_asignatura', 'ServicioController@ajax_verifica_nombre_asignatura');


    Route::get('Resolucion/listado', 'ResolucionController@listado');
    Route::post('Resolucion/guardar', 'ResolucionController@guardar');
    Route::post('Resolucion/actualizar', 'ResolucionController@actualizar');
    Route::get('Resolucion/eliminar/{id}', 'ResolucionController@eliminar');

    Route::get('Turno/listado', 'TurnoController@listado');
    Route::post('Turno/guardar', 'TurnoController@guardar');
    Route::post('Turno/actualizar', 'TurnoController@actualizar');
    Route::get('Turno/eliminar/{id}', 'TurnoController@eliminar');

    Route::get('Asignatura/listado', 'AsignaturaController@listado');
    Route::get('Descuento/listado', 'DescuentoController@listado');
    Route::get('Servicio/listado', 'ServicioController@listado');
    Route::get('Turno/listado', 'TurnoController@listado');

    Route::get('Perfil/listado', 'PerfilController@listado');
    Route::post('Perfil/guardar', 'PerfilController@guardar');
    Route::get('Perfil/ajaxListadoMenu', 'PerfilController@ajaxListadoMenu');
    Route::post('Perfil/actualizar', 'PerfilController@actualizar');
    Route::get('Perfil/eliminar/{id}', 'PerfilController@eliminar');

    Route::get('Predefinida/listado', 'PredefinidaController@listado');
    Route::post('Predefinida/guardar', 'PredefinidaController@guardar');
    Route::post('Predefinida/actualizar', 'PredefinidaController@actualizar');
    Route::get('Predefinida/eliminar/{id}', 'PredefinidaController@eliminar');
    Route::get('Predefinida/cambiar/{id}', 'PredefinidaController@cambiar');

    Route::get('Certificado/listado', 'CertificadoController@listado');
    Route::post('Certificado/guardar', 'CertificadoController@guardar');
    Route::post('Certificado/actualizar', 'CertificadoController@actualizar');
    Route::get('Certificado/eliminar/{id}', 'CertificadoController@eliminar');
    Route::get('Certificado/cambiar/{id}', 'CertificadoController@cambiar');
    Route::get('Certificado/ajaxEditaRequisitos', 'CertificadoController@ajaxEditaRequisitos');
    Route::post('Certificado/requisitos', 'CertificadoController@requisitos');
    Route::get('Certificado/emitir_certificado/{persona_id}/{certificado_id}', 'CertificadoController@emitir_certificado');
    Route::get('Certificado/eliminar_certificado/{persona_id}/{certificacion_id}', 'CertificadoController@eliminar_certificado');

    //DETALLE DEL ESTUDIANTE
    Route::get('Kardex/detalle_estudiante/{persona_id}', 'KardexController@detalle_estudiante');
    Route::get('Kardex/ajax_datos_principales', 'KardexController@ajax_datos_principales');
    Route::post('Kardex/guardar_datosPrincipales', 'KardexController@guardar_datosPrincipales');
    Route::get('Kardex/ajax_datos_adicionales', 'KardexController@ajax_datos_adicionales');
    Route::post('Kardex/guardar_datosAdicionales', 'KardexController@guardar_datosAdicionales');
    Route::get('Kardex/ajax_datos_carreras', 'KardexController@ajax_datos_carreras');
    Route::post('Kardex/guardar_datosCarreras', 'KardexController@guardar_datosCarreras');
    Route::get('Kardex/ajax_datos_reinscripcion', 'KardexController@ajax_datos_reinscripcion');
    // Route::post('Kardex/guardar_datosCarreras', 'KardexController@guardar_datosCarreras');
    Route::get('Kardex/ajax_datos_asig_tomar', 'KardexController@ajax_datos_asig_tomar');
    Route::post('Kardex/guarda_reinscripcion', 'KardexController@guarda_reinscripcion');

    Route::get('Kardex/ajax_datos_notas_carreras', 'KardexController@ajax_datos_notas_carreras');

    //TRANSACCIONES
    Route::get('Transaccion/pagos', 'TransaccionController@pagos');
    Route::get('Transaccion/verifica_ci', 'TransaccionController@verifica_ci');
    Route::get('Transaccion/consulta', 'TransaccionController@consulta');

    Route::get('Transaccion/carreras', 'TransaccionController@carreras');
    Route::get('Transaccion/verifica_cobros_temporada_carrera', 'TransaccionController@verifica_cobros_temporada_carrera');
    Route::get('Transaccion/verifica_cobros_temporada_asignatura', 'TransaccionController@verifica_cobros_temporada_asignatura');
    Route::get('Transaccion/asignaturas', 'TransaccionController@asignaturas');
    Route::get('Transaccion/verifica_descuento', 'TransaccionController@verifica_descuento');
    Route::get('Transaccion/verifica_datos', 'TransaccionController@verifica_datos');
    Route::get('Transaccion/formulario', 'TransaccionController@formulario');
    Route::post('Transaccion/guardar_todo', 'TransaccionController@guardar_todo');
    Route::post('Transaccion/guardar_factura', 'TransaccionController@guardar_factura');

    Route::post('Transaccion/pago_recuperatorio', 'TransaccionController@pago_recuperatorio');

    // REPORTES
    Route::get('Lista/alumnos', 'ListaController@alumnos');
    Route::get('Lista/ajaxBusquedaAlumnos', 'ListaController@ajaxBusquedaAlumnos');
    Route::get('Lista/reportePdfAlumnos/{carrera}/{curso}/{turno}/{paralelo}/{gestion}/{estado}', 'ListaController@reportePdfAlumnos');
});



