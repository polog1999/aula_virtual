<?php

use App\Http\Controllers\admin\AlumnoController;
use App\Http\Controllers\admin\CategoriaController;
use App\Http\Controllers\admin\CursoController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\docente\TallerController as DocenteTallerController;
use App\Http\Controllers\TallerController as TallerController;
use App\Http\Controllers\admin\TallerController as AdminTallerController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DisciplinaController;
use App\Http\Controllers\admin\DocenteController;
use App\Http\Controllers\admin\LugarController;
use App\Http\Controllers\admin\MatriculaController;
use App\Http\Controllers\admin\PagoController as AdminPagoController;
use App\Http\Controllers\admin\PeriodoController;
use App\Http\Controllers\admin\ReporteController;
use App\Http\Controllers\admin\SeccionController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\alumno\AsistenciaController as AlumnoAsistenciaController;
use App\Http\Controllers\alumno\HorarioController;
use App\Http\Controllers\alumno\PagoController;
use App\Http\Controllers\apoderado\AsistenciaController as ApoderadoAsistenciaController;
use App\Http\Controllers\apoderado\CronogramaPagoController as ApoderadoCronogramaPagoController;
use App\Http\Controllers\apoderado\HijoController;
use App\Http\Controllers\apoderado\HorarioController as ApoderadoHorarioController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ReporteAsistenciaController;
use App\Http\Controllers\DisciplinaController as ControllersDisciplinaController;
use App\Http\Controllers\docente\AsistenciaController as DocenteAsistenciaController;
use App\Http\Controllers\AsistenciaController as AdminAsistenciaController;
use App\Http\Controllers\docente\HijoController as DocenteHijoController;
use App\Http\Controllers\docente\HorarioController as DocenteHorarioController;
use App\Http\Controllers\docente\PagosController;
use App\Http\Controllers\MisCursosController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SeleccionarRol;
use App\Http\Controllers\SeleccionarRolController;
use App\Http\Controllers\SesionController;
use App\Models\Sesion;
use Illuminate\Support\Facades\Session;

Route::get('/prueba/{periodoId}/{lugarId}', [AsistenciaController::class, 'getDisciplinas']);
// Route::get('/', function () {
//     return view('confirmacion');
// });
Route::middleware('auth')->get('/seleccionar-rol', [SeleccionarRolController::class, 'show'])->name('seleccionar.rol');
Route::middleware('auth')->get('/seleccionar-rol/acceder', [SeleccionarRolController::class, 'select'])->name('definir.rol.activo');
Route::get('/pagos/comprobante/{pago}', [TallerController::class, 'generarComprobantePago'])->name('pagos.comprobante');
// Route::post('/talleres', [TallerController::class, 'store'])->name('talleres.store');

Route::middleware('auth', 'role:admin')->prefix('portal')->group(function () {

    // Route::get('/dashboard', [DashboardController::class, 'latestThree'])->name('portal.dashboard');

    Route::get('modulos', [ModuloController::class, 'index'])->name('portal.modulos.index');
    Route::post('modulos', [ModuloController::class, 'store'])->name('portal.modulos.store');
    Route::put('modulos/{id}', [ModuloController::class, 'update'])->name('portal.modulos.update');
    Route::delete('modulos/{id}', [ModuloController::class, 'destroy'])->name('portal.modulos.delete');

    Route::post('sesiones', [SesionController::class, 'store'])->name('portal.sesiones.store');

    Route::get('secciones', [SeccionController::class, 'index'])->name('portal.secciones.index');
    Route::post('secciones', [SeccionController::class, 'store'])->name('portal.secciones.store');
    Route::put('secciones/{seccion}', [SeccionController::class, 'update'])->name('portal.secciones.update');
    Route::delete('secciones/{seccion}', [SeccionController::class, 'destroy'])->name('portal.secciones.destroy');

    Route::get('/categorias', [CategoriaController::class, 'index'])->name('portal.categorias.index');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('portal.categorias.store');
    Route::put('/categorias/{id}', [CategoriaController::class, 'update'])->name('portal.categorias.update');
    Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy'])->name('portal.categorias.destroy');

    Route::get('/lugares', [LugarController::class, 'index'])->name('portal.lugares.index');
    Route::post('/lugares', [LugarController::class, 'store'])->name('portal.lugares.store');
    Route::put('/lugares/{id}', [LugarController::class, 'update'])->name('portal.lugares.update');
    Route::delete('/lugares/{id}', [LugarController::class, 'destroy'])->name('portal.lugares.destroy');

    Route::get('/cursos', [CursoController::class, 'index'])->name('portal.cursos.index');
    Route::get('/cursos/create', [CursoController::class, 'create'])->name('portal.cursos.create');

    Route::post('/cursos', [CursoController::class, 'store'])->name('portal.cursos.store');
    Route::put('/cursos/{id}', [CursoController::class, 'update'])->name('portal.cursos.update');
    Route::delete('/cursos/{id}', [CursoController::class, 'destroy'])->name('portal.cursos.destroy');

    Route::get('/periodos', [PeriodoController::class, 'index'])->name('portal.periodos.index');
    Route::post('/periodos', [PeriodoController::class, 'store'])->name('portal.periodos.store');
    Route::put('/periodos/{id}', [PeriodoController::class, 'update'])->name('portal.periodos.update');
    Route::delete('/periodos/{id}', [PeriodoController::class, 'destroy'])->name('portal.periodos.destroy');
    Route::get('periodos/{periodoId}', [PeriodoController::class, 'getPeriodo']);

    Route::get('matriculas', [MatriculaController::class, 'index'])->name('portal.matriculas.index');
    Route::put('matriculas/{id}', [MatriculaController::class, 'update'])->name('portal.matriculas.update');
    Route::delete('matriculas/{id}', [MatriculaController::class, 'destroy'])->name('portal.matriculas.destroy');
    Route::put('matriculas/cancelar/{matricula}', [MatriculaController::class, 'cancelarMatricula'])->name('portal.matriculas.cancelar');

    // Route::get('/cronogramaPagos', [CronogramaPagoController::class, 'index'])->name('portal.cronogramaPagos.index');
    // Route::put('cronogramaPagos/{id}/confirmar', [CronogramaPagoController::class, 'confirmarPago']);

    Route::get('/pagos', [AdminPagoController::class, 'index'])->name('portal.pagos.index');

    Route::get('docentes', [DocenteController::class, 'index'])->name('portal.docentes.index');
    Route::put('docentes/{id}', [DocenteController::class, 'update'])->name('portal.docentes.update');
    Route::delete('docentes/{id}', [DocenteController::class, 'destroy'])->name('portal.docentes.destroy');

    Route::get('alumnos', [AlumnoController::class, 'index'])->name('portal.alumnos.index');
    Route::put('alumnos/{id}', [AlumnoController::class, 'update'])->name('portal.alumnos.update');
    Route::delete('alumnos/{id}', [AlumnoController::class, 'destroy'])->name('portal.alumnos.destroy');

    Route::get('usuarios', [UserController::class, 'index'])->name('portal.users.index');
    Route::get('usuarios/{id}/edit', [UserController::class, 'edit'])->name('portal.users.edit');
    Route::put('usuarios/{id}', [UserController::class, 'update'])->name('portal.users.update');
    Route::post('usuarios', [UserController::class, 'store'])->name('portal.users.store');
    Route::delete('usuarios/{id}', [UserController::class, 'destroy'])->name('portal.users.destroy');

    Route::get('reportes/alumnos-matriculados', [ReporteController::class, 'exportarAlumnos'])
        ->name('portal.reportes.alumnos');

    Route::get('reportes/alumnos-pagos', [AdminPagoController::class, 'exportarPagos'])
        ->name('portal.reportes.pagos');
});
Route::middleware('auth', 'role:admin|encargado_sede')->prefix('portal')->group(function () {
    Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('portal.asistencias.index');
    Route::put('/edit', [AsistenciaController::class, 'update'])->name('portal.asistencias.update');
    Route::get('/asistencias/reporte-por-periodo', [AsistenciaController::class, 'reportePeriodo'])->name('portal.asistencias.reportePeriodo');
    Route::get('/asistencias/reporte', [AsistenciaController::class, 'reporte'])->name('portal.asistencias.reporte');
    // Route::get('categorias/{disciplinaId}', [AsistenciaController::class, 'getCategorias']);
    // Route::get('docentes/{disciplinaId}/{categoriaId}', [AsistenciaController::class, 'getDocentes']);
    Route::get('deportes/{periodoId}/{lugarId}', [AsistenciaController::class, 'getDisciplinas']);
    Route::get('docentes/{periodoId}/{lugarId}/{disciplinaId}', [AsistenciaController::class, 'getDocentes']);
    Route::get('secciones/{periodoId}/{lugarId}/{disciplinaId}/{docenteId}', [AsistenciaController::class, 'getSecciones']);
    Route::get('sesiones/{seccionId}', [AsistenciaController::class, 'getSesiones']);

    Route::get('horarios/{periodoId}/{disciplinaId}/{seccionId}', [AsistenciaController::class, 'getHorarios']);
    Route::get('crear-asistencia/{periodoId}/{disciplinaId}/{seccionId}/{fecha}', [AsistenciaController::class, 'create'])->name('portal.crearAsistencias.create');
    Route::post('asistencias/', [AsistenciaController::class, 'store'])->name('portal.guardarAsistencias.store');

    Route::get('reportes/asistencias-periodo', [ReporteAsistenciaController::class, 'exportarAsistencias'])
        ->name('portal.reportes.asistencias');
    Route::get('perfil', [PerfilController::class, 'index'])->name('portal.perfil.index');

    Route::get(
        '/',
        function () {
            $user = auth()->user();
            if ($user->hasRole('admin')) {
                return redirect()->route('portal.periodos.index'); // Si es admin, ejecuta la lógica del dashboard
            }

            if ($user->hasRole('encargado_sede')) {
                return redirect()->route('portal.asistencias.index');
            }

            // if ($user->hasRole('docente')) {
            //     return redirect()->route('docente.talleres');
            // }

            // Si no tiene ninguno de los anteriores, al perfil o al inicio
            return redirect()->route('portal.perfil.index');
        }
    );

    // Route::get('perfil', [PerfilController::class, 'index'])->name('portal.perfil.index');
});
Route::middleware('auth', 'role:admin|docente|encargado_sede')->prefix('portal')->group(function () {
    Route::get('/mis-cursos', [MisCursosController::class, 'index'])->name('portal.misCursos');
});

Route::middleware('auth', 'role:docente')->prefix('docente')->group(function () {
    Route::get('/talleres', [MisCursosController::class, 'index'])->name('docente.talleres');
    Route::get('perfil', [PerfilController::class, 'index'])->name('docente.perfil.index');
    Route::get('/pagos', [PagosController::class, 'index'])->name('docente.pagos.index');
    Route::get('/hijos', [DocenteHijoController::class, 'index'],)->name('docente.hijos.index');
    Route::get('/asistencias', [DocenteAsistenciaController::class, 'index'])->name('docente.asistencias.index');
    Route::get('/horarios', [DocenteHorarioController::class, 'index'])->name('docente.horarios.index');
    // Route::put('perfil', [PerfilController::class, 'updatePassword'])->name('docente.perfil.updatePassword');
});
Route::middleware('auth', 'role:ALUMNO')->prefix('alumno')->group(function () {
    Route::get('/', [HorarioController::class, 'index'])->name('alumno.horarios.index');
    Route::get('/pagos', [PagoController::class, 'index'])->name('alumno.pagos.index');
    Route::get('/asistencias', [AlumnoAsistenciaController::class, 'index'])->name('alumno.asistencias.index');
    Route::get('perfil', [PerfilController::class, 'index'])->name('alumno.perfil.index');
    // Route::put('perfil', [PerfilController::class, 'updatePassword'])->name('alumno.perfil.updatePassword');
});

Route::middleware('auth', 'role:encargado_sede')->prefix('encargado-sede')->group(function () {
    Route::get('/', [AsistenciaController::class, 'index'])->name('encargadoSede.asistencias.index');
    Route::put('/', [AsistenciaController::class, 'update'])->name('encargadoSede.asistencias.update');
    Route::get('/asistencias/reporte-por-periodo', [AsistenciaController::class, 'reportePeriodo'])->name('encargadoSede.asistencias.reportePeriodo');
    Route::get('/asistencias/reporte', [AsistenciaController::class, 'reporte'])->name('encargadoSede.asistencias.reporte');
    // Route::get('categorias/{disciplinaId}', [AsistenciaController::class, 'getCategorias']);
    // Route::get('docentes/{disciplinaId}/{categoriaId}', [AsistenciaController::class, 'getDocentes']);
    Route::get('deportes/{periodoId}/{lugarId}', [AsistenciaController::class, 'getDisciplinas']);
    Route::get('docentes/{periodoId}/{lugarId}/{disciplinaId}', [AsistenciaController::class, 'getDocentes']);
    Route::get('secciones/{periodoId}/{lugarId}/{disciplinaId}/{docenteId}', [AsistenciaController::class, 'getSecciones']);
    Route::get('sesiones/{seccionId}', [AsistenciaController::class, 'getSesiones']);

    Route::get('horarios/{periodoId}/{disciplinaId}/{seccionId}', [AsistenciaController::class, 'getHorarios']);
    Route::get('crear-asistencia/{periodoId}/{disciplinaId}/{seccionId}/{fecha}', [AsistenciaController::class, 'create'])->name('encargadoSede.crearAsistencias.create');
    Route::post('/', [AsistenciaController::class, 'store'])->name('encargadoSede.guardarAsistencias.store');

    Route::get('reportes/asistencias-periodo', [ReporteAsistenciaController::class, 'exportarAsistencias'])
        ->name('encargadoSede.reportes.asistencias');
    Route::get('perfil', [PerfilController::class, 'index'])->name('encargadoSede.perfil.index');
    // Route::put('perfil', [PerfilController::class, 'updatePassword'])->name('encargadoSede.perfil.updatePassword');
});

// Route::middleware('preventBackHistory')->group(function () {
//     // Route::get('/login',[AuthController::class,'showLogin'])->name('login');
//     // Route::post('/login',[AuthController::class,'login'])->name('login');
//     // Route::post('/logout',[AuthController::class,'logout'])->name('logout');
// });

Route::middleware('auth', 'role:PADRE')->prefix('apoderado')->group(function () {
    Route::get('/', [ApoderadoCronogramaPagoController::class, 'index'])->name('apoderado.pagos.index');
    Route::get('/hijos', [HijoController::class, 'index'],)->name('apoderado.hijos.index');
    Route::get('/asistencias', [ApoderadoAsistenciaController::class, 'index'])->name('apoderado.asistencias.index');
    Route::get('perfil', [PerfilController::class, 'index'])->name('apoderado.perfil.index');
    // Route::put('perfil', [PerfilController::class, 'updatePassword'])->name('apoderado.perfil.updatePassword');
    Route::get('/horarios', [ApoderadoHorarioController::class, 'index'])->name('apoderado.horarios.index');
});

Route::get('/', [ControllersDisciplinaController::class, 'index'])->name('index');
Route::get('{disciplina}/talleres', [TallerController::class, 'show'])->name('talleres.show');
Route::post('/talleres/preInscripcion', [TallerController::class, 'storeInscripcion'])->name('talleres.preinscripcion');
Route::get('/talleres/casi-listo/{token}', [TallerController::class, 'showCasiListo'])->name('talleres.casi-listo');
Route::post('talleres/inscripcion/enviar-comprobante', [TallerController::class, 'storeComprobante'])->name('talleres.inscripcion.comprobante');
Route::post('talleres/procesandoPago/{monto}/{orden}/{inscripcionId}', [TallerController::class, 'procesandoPago'])->name('talleres.procesandoPago');
Route::get('talleres/inscripcion/respuesta', function () {
    // Asegúrate de que solo se pueda acceder a esta página si viene con un mensaje
    if (session()->has('pagosNiubiz')) {
        return view('confirmado');
    } else if (session()->has('paymentData')) {
        $paymentData = session('paymentData');
        return view('rechazado', compact('paymentData'));
    } else {
        return redirect('/');
    }
})->name('talleres.inscripcion.respuesta');
Route::get('verificar-por-dni/{dni}', [TallerController::class, 'ws_reniec'])->name('talleres.verificarPorDni');
Route::get('verificar-por-dni-local/{dni}', [TallerController::class, 'verificarPorDni'])->name('talleres.verificarPorDni');


Route::post('enviar-codigo-verificacion', [TallerController::class, 'enviarCodigo'])->name('talleres.enviarCodigo');

Route::get('/test-ip', function () {
    return response()->json([
        'ip_metodo_directo' => request()->ip(),
        'todas_las_ips' => request()->ips(),
        'cabeceras' => request()->header()
    ]);
});


Route::post('/guardar-aceptacion-terminos', function () {
    // Guardamos en la sesión que el usuario aceptó
    Session::put('terminos_aceptados', true);
    return response()->json(['status' => 'success']);
})->name('terminos.aceptar');

Route::post('/guardar-negacion-terminos', function () {
    // Guardamos en la sesión que el usuario aceptó
    Session::put('terminos_aceptados', false);
    return response()->json(['status' => 'success']);
})->name('terminos.borrar');

// Route::get('post',[Post::class,'index']);
// Route::get('post/{id}',[Post::class,'show']);
// Route::get('post/create',[Post::class,'create']);
// Route::post('post/{id}',[Post::class, 'store']);
// Route::get('post/{id}/edit',[Post::class],'edit');
// Route::put('post/{id}',[Post::class,'update']);
// Route::delete('post/{id}',[Post::class,'destroy']);
