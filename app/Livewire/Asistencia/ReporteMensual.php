<?php

namespace App\Livewire\Asistencia;

use Livewire\Component;
use App\Models\Periodo;
use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Seccion;
use App\Models\Matricula;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteMensual extends Component
{
    // Filtros
    public $periodo_id, $categoria_id, $curso_id, $seccion_id, $mes;
    
    // Listas para selects
    public $periodos, $categorias = [], $cursos = [], $secciones = [];
    
    // Datos para la tabla
    public $diasDelMes = [];
    public $estudiantesReporte = [];

    public function mount()
    {
        $this->periodos = Periodo::orderBy('anio', 'desc')->get();
        $this->categorias = Categoria::all();
        $this->mes = date('n'); // Mes actual por defecto
    }

    // Lógica de Cascada (Igual que el Manager)
    public function updatedCategoriaId() {
        $this->reset(['curso_id', 'seccion_id', 'estudiantesReporte']);
        $this->cursos = Curso::where('categoria_id', $this->categoria_id)->get();
    }

    public function updatedCursoId() {
        $this->reset(['seccion_id', 'estudiantesReporte']);
        $this->secciones = Seccion::where('curso_id', $this->curso_id)
            ->where('periodo_id', $this->periodo_id)
            ->get();
    }

    public function generarReporte()
    {
        $this->validate([
            'periodo_id' => 'required',
            'seccion_id' => 'required',
            'mes' => 'required'
        ]);

        $periodo = Periodo::find($this->periodo_id);
        $anio = $periodo->anio;

        // 1. Obtener las fechas programadas en seccion_clases para ese mes
        $this->diasDelMes = DB::table('seccion_clases')
            ->where('seccion_id', $this->seccion_id)
            ->whereMonth('fecha', $this->mes)
            ->whereYear('fecha', $anio)
            ->orderBy('fecha', 'asc')
            ->pluck('fecha');

        $totalClasesMes = $this->diasDelMes->count();

        // 2. Obtener matriculados y sus asistencias
        $matriculas = Matricula::where('seccion_id', $this->seccion_id)
            ->where('estado', 'ACTIVA')
            ->with(['alumnos.user', 'asistencias' => function($q) use ($anio) {
                $q->whereYear('fecha', $anio)->whereMonth('fecha', $this->mes);
            }])
            ->get();

        // 3. Mapear datos para la tabla
        $this->estudiantesReporte = $matriculas->map(function($m) use ($totalClasesMes) {
            $asistenciasPorDia = [];
            $aCount = 0; $fCount = 0; $tCount = 0;

            foreach($m->asistencias as $asistencia) {
                $dia = Carbon::parse($asistencia->fecha)->day;
                $asistenciasPorDia[$dia] = $asistencia->estado;
                
                if($asistencia->estado == 'ASISTIO') $aCount++;
                if($asistencia->estado == 'FALTO') $fCount++;
                if($asistencia->estado == 'TARDANZA') $tCount++;
            }

            return (object) [
                'apellido_paterno' => $m->alumnos->user->apellido_paterno,
                'nombres' => $m->alumnos->user->nombres,
                'asistencias_por_dia' => $asistenciasPorDia,
                'total_asistencias' => $aCount,
                'total_faltas' => $fCount,
                'total_tardanzas' => $tCount,
                'porcentaje_asistencia' => $totalClasesMes > 0 ? (($aCount + ($tCount * 0.5)) / $totalClasesMes) * 100 : 0
            ];
        })->sortBy('apellido_paterno')->values();
    }

    public function render()
    {
        return view('livewire.asistencia.reporte-mensual');
    }
}