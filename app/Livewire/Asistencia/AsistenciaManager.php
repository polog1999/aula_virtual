<?php

namespace App\Livewire\Asistencia;

use Livewire\Component;
use App\Models\Periodo;
use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Seccion;
use App\Models\Matricula;
use App\Models\Asistencia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsistenciaManager extends Component
{
    // Filtros
    public $periodo_id, $categoria_id, $curso_id, $seccion_id, $fecha;
    
    // Listas
    public $periodos, $categorias = [], $cursos = [], $secciones = [], $fechas = [];
    
    // Datos de la tabla
    public $estudiantes = [];
    public $asistencias_data = []; // [matricula_id => ['estado' => 'ASISTIO', 'detalles' => '']]

    public function mount()
    {
        $this->periodos = Periodo::orderBy('anio', 'desc')->get();
        $this->categorias = Categoria::all();
    }

    // Cascada: Cuando cambia Categoria
    public function updatedCategoriaId()
    {
        $this->resetFilters(['curso_id', 'seccion_id', 'fecha']);
        if ($this->categoria_id) {
            $this->cursos = Curso::where('categoria_id', $this->categoria_id)->where('activo', true)->get();
        }
    }

    // Cascada: Cuando cambia Curso
    public function updatedCursoId()
    {
        $this->resetFilters(['seccion_id', 'fecha']);
        if ($this->curso_id && $this->periodo_id) {
            $this->secciones = Seccion::where('curso_id', $this->curso_id)
                ->where('periodo_id', $this->periodo_id)
                ->with('docentes.user')
                ->get();
        }
    }

    // Cascada: Cuando cambia Sección
    public function updatedSeccionId()
    {
        $this->resetFilters(['fecha']);
        if ($this->seccion_id) {
            // Obtener fechas de seccion_clases generadas anteriormente
            $this->fechas = DB::table('seccion_clases')
                ->where('seccion_id', $this->seccion_id)
                ->orderBy('fecha', 'asc')
                ->pluck('fecha');
        }
    }

    private function resetFilters($fields) {
        foreach($fields as $f) { $this->$f = null; }
        $this->estudiantes = [];
    }

    public function buscarAlumnos()
    {
        $this->validate([
            'periodo_id' => 'required',
            'seccion_id' => 'required',
            'fecha' => 'required',
        ]);

        // Buscar asistencias existentes
        $asistenciasExistentes = Asistencia::where('fecha', $this->fecha)
            ->whereHas('matricula', function($q) {
                $q->where('seccion_id', $this->seccion_id);
            })->get()->keyBy('matricula_id');

        // Buscar matriculados
        $matriculas = Matricula::where('seccion_id', $this->seccion_id)
            ->where('estado', 'ACTIVA')
            ->with('alumnos.user')
            ->get();

        $this->estudiantes = [];
        $this->asistencias_data = [];

        foreach ($matriculas as $m) {
            $user = $m->alumnos->user;
            $existente = $asistenciasExistentes[$m->id] ?? null;

            $this->estudiantes[] = [
                'matricula_id' => $m->id,
                'nombre_completo' => "{$user->apellido_paterno} {$user->apellido_materno}, {$user->nombres}",
            ];

            $this->asistencias_data[$m->id] = [
                'estado' => $existente ? $existente->estado : 'ASISTIO',
                'detalles' => $existente ? $existente->detalles : '',
            ];
        }

        if(empty($this->estudiantes)) {
            $this->dispatch('swal', ['icon' => 'info', 'title' => 'Sin alumnos', 'text' => 'No hay alumnos activos en esta sección.']);
        }
    }

    public function guardarAsistencia()
    {
        try {
            DB::transaction(function () {
                foreach ($this->asistencias_data as $matricula_id => $data) {
                    Asistencia::updateOrCreate(
                        ['matricula_id' => $matricula_id, 'fecha' => $this->fecha],
                        ['estado' => $data['estado'], 'detalles' => $data['detalles'] ?? null]
                    );
                }
            });

            $this->dispatch('swal', ['icon' => 'success', 'title' => '¡Éxito!', 'text' => 'Asistencia guardada correctamente.']);
        } catch (\Exception $e) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Error', 'text' => 'No se pudo guardar la asistencia.']);
        }
    }

    public function render()
    {
        return view('livewire.asistencia.asistencia-manager');
    }
}