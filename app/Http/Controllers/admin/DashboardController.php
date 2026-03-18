<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\Taller;
use App\Models\Categoria;
use App\Models\CronogramaPago;
use App\Models\Disciplina;
use App\Models\Docente;
use App\Models\Lugar;
use App\Models\Seccion;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function latestThree(Request $request)
    {
        
        // 1. Obtener valores del request. Si no existen, 'anio' será el actual y 'mes' será null.
        $anioSeleccionado = $request->input('anio', Carbon::now()->year);
        $mesSeleccionado = $request->input('mes'); // Obtenemos el mes, será null o "" si no se selecciona.

        $queryIngresos = CronogramaPago::query();

        // 2. Siempre filtramos por año.
        $queryIngresos->whereYear('fecha_pago', $anioSeleccionado);

        // 3. Verificamos si se proporcionó un mes válido (no es null ni un string vacío).
        if ($mesSeleccionado && $mesSeleccionado != 'todos') {
            // Si hay un mes, añadimos el filtro de mes.
            $mesComoEntero = (int) $mesSeleccionado;
            $queryIngresos->whereMonth('fecha_pago', $mesComoEntero);

            // Y preparamos la descripción para el mes.
            $nombreMes = Carbon::create()->month($mesComoEntero)->locale('es')->monthName;
            $periodo = "Recaudado en " . ucfirst($nombreMes) . " de " . $anioSeleccionado;
        } else {
            // Si no hay mes, la descripción es solo para el año.
            $periodo = "Recaudado en el año " . $anioSeleccionado;
        }

        // $ingresosCalculados = $queryIngresos->where('estado', 'PAGADO')->where('concepto','ilike', "%Mensualidad%")->sum('monto');
        $ingresosCalculados = $queryIngresos->where('estado', 'PAGADO')->sum('monto');

        // --- FIN DE LA CORRECCIÓN ---


        // El resto de tu código para obtener los otros datos permanece igual.
        $secciones = Seccion::with(['talleres.categoria:id', 'talleres.disciplina:id,nombre,imagen', 'docentes.user:id,nombres,apellido_paterno,apellido_materno', 'lugares:id,nombre'])->withCount([
            'matriculas as matriculas_activas_count' => function ($q) {
                $q->where('estado', 'ACTIVA');
            }
        ])->latest()->take(3)->get();

        $num_tall_activos = Seccion::select('id')->where('activo', 1)->count();
        $num_docentes = User::where('es_docente', true)->where('activo',true)->count();

        // Mejora: Contar alumnos únicos en lugar de matrículas.
        $num_alumnos = Matricula::where('estado', 'ACTIVA')->distinct('alumno_id')->count('alumno_id');

        $categorias = Categoria::select('id')->get();
        $disciplinas = Disciplina::select('id', 'nombre')->get();
        $lugares = Lugar::select('id', 'nombre')->get();
        $docentes = Docente::select('user_id')->with(['user:id,nombres,apellido_paterno,apellido_materno'])->get();

        // Aseguramos que los nombres de las variables coincidan con la vista.
        return view('portal.dashboard', [
            'secciones' => $secciones,
            'num_tall_activos' => $num_tall_activos,
            'num_docentes' => $num_docentes,
            'num_alumnos' => $num_alumnos,
            'categorias' => $categorias,
            'disciplinas' => $disciplinas,
            'docentes' => $docentes,
            'lugares' => $lugares,
            'ingresos' => $ingresosCalculados,
            'periodo_ingresos' => $periodo
        ]);
    }
}
