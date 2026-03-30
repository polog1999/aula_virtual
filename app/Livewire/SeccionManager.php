<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Seccion;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\Matricula;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Attributes\On;

class SeccionManager extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    public $cursos, $docentes, $periodos;

    // Formulario
    public $seccion_id, $curso_id, $docente_id, $periodo_id, $nombre, $vacantes, $fecha_inicio, $activo = 1;
    public $horarios_form = [];

    public function mount()
    {
        $this->cursos = Curso::where('activo', 1)->get();
        $this->docentes = Docente::with('user')->get();
        $this->periodos = Periodo::all();
        $this->addHorario();
    }

    public function addHorario()
    {
        $this->horarios_form[] = ['dia_semana' => '', 'hora_inicio' => '', 'hora_fin' => ''];
    }

    public function removeHorario($index)
    {
        unset($this->horarios_form[$index]);
        $this->horarios_form = array_values($this->horarios_form);
    }

    public function openModal($id = null)
    {
        $this->reset(['seccion_id', 'curso_id', 'docente_id', 'periodo_id', 'nombre', 'vacantes', 'fecha_inicio', 'activo', 'horarios_form']);
        
        if ($id) {
            $this->seccion_id = $id;
            $seccion = Seccion::with('horarios')->findOrFail($id);
            $this->curso_id = $seccion->curso_id;
            $this->docente_id = $seccion->docente_id;
            $this->periodo_id = $seccion->periodo_id;
            $this->nombre = $seccion->nombre;
            $this->vacantes = $seccion->vacantes;
            $this->fecha_inicio = $seccion->fecha_inicio->format('Y-m-d');
            $this->activo = $seccion->activo;
            
            $this->horarios_form = $seccion->horarios->map(fn($h) => [
                'dia_semana' => $h->dia_semana,
                'hora_inicio' => Carbon::parse($h->hora_inicio)->format('H:i'),
                'hora_fin' => Carbon::parse($h->hora_fin)->format('H:i')
            ])->toArray();
        } else {
            $this->addHorario();
        }
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate([
            'curso_id' => 'required',
            'docente_id' => 'required',
            'periodo_id' => 'required',
            'nombre' => 'required|string|max:100',
            'vacantes' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'horarios_form.*.dia_semana' => 'required',
            'horarios_form.*.hora_inicio' => 'required',
            'horarios_form.*.hora_fin' => 'required',
        ]);

        // Verificar si el curso tiene sesiones
        $totalSesionesCurso = DB::table('sesiones')
            ->join('modulos', 'sesiones.modulo_id', '=', 'modulos.id')
            ->where('modulos.curso_id', $this->curso_id)
            ->count();

        if ($totalSesionesCurso === 0) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Error', 'text' => 'El curso seleccionado no tiene sesiones creadas en el Constructor.']);
            return;
        }

        try {
            DB::transaction(function () {
                $data = [
                    'curso_id' => $this->curso_id,
                    'docente_id' => $this->docente_id,
                    'periodo_id' => $this->periodo_id,
                    'nombre' => $this->nombre,
                    'vacantes' => $this->vacantes,
                    'fecha_inicio' => $this->fecha_inicio,
                    'activo' => $this->activo,
                ];

                if ($this->seccion_id) {
                    $seccion = Seccion::find($this->seccion_id);
                    $seccion->update($data);
                } else {
                    $seccion = Seccion::create($data);
                }

                // Actualizar Horarios
                $seccion->horarios()->delete();
                foreach ($this->horarios_form as $h) {
                    $seccion->horarios()->create($h);
                }

                // Generar Calendario exacto por sesiones
                $this->generarCalendarioPorSesiones($seccion);
            });

            $this->isOpen = false;
            $this->dispatch('swal', ['icon' => 'success', 'title' => 'Éxito', 'text' => 'Sección y calendario de clases generado correctamente.']);
        } catch (\Exception $e) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Error', 'text' => $e->getMessage()]);
        }
    }

    private function generarCalendarioPorSesiones($seccion)
    {
        // 1. Eliminar clases existentes que no tengan asistencia (o todas para reiniciar)
        DB::table('seccion_clases')->where('seccion_id', $seccion->id)->delete();

        // 2. Obtener todas las sesiones del curso en orden
        $sesiones = DB::table('sesiones')
            ->join('modulos', 'sesiones.modulo_id', '=', 'modulos.id')
            ->where('modulos.curso_id', $seccion->curso_id)
            ->orderBy('modulos.orden', 'asc')
            ->orderBy('sesiones.id', 'asc')
            ->select('sesiones.id')
            ->get();

        $totalSesionesAAasignar = $sesiones->count();

        // 3. Mapeo de días permitidos
        $mapDias = [
            'LUNES' => Carbon::MONDAY, 'MARTES' => Carbon::TUESDAY, 'MIÉRCOLES' => Carbon::WEDNESDAY,
            'JUEVES' => Carbon::THURSDAY, 'VIERNES' => Carbon::FRIDAY, 'SÁBADO' => Carbon::SATURDAY, 'DOMINGO' => Carbon::SUNDAY
        ];
        $diasPermitidos = collect($this->horarios_form)
            ->pluck('dia_semana')
            ->map(fn($d) => $mapDias[strtoupper($d)] ?? null)
            ->filter()
            ->toArray();

        // 4. Bucle de generación
        $fechaCorriente = Carbon::parse($this->fecha_inicio);
        $sesionesAsignadas = 0;
        $clasesParaInsertar = [];

        // Seguridad: Si no hay días permitidos, evitar bucle infinito
        if (empty($diasPermitidos)) return;

        // El bucle corre HASTA que hayamos asignado todas las sesiones del curso
        while ($sesionesAsignadas < $totalSesionesAAasignar) {
            
            // Si el día de la fecha actual está en el horario...
            if (in_array($fechaCorriente->dayOfWeek, $diasPermitidos)) {
                
                $clasesParaInsertar[] = [
                    'seccion_id' => $seccion->id,
                    'sesion_id' => $sesiones[$sesionesAsignadas]->id,
                    'fecha' => $fechaCorriente->toDateString(),
                    'estado' => 'PROGRAMADA',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                $sesionesAsignadas++;
            }

            // Avanzar un día en el calendario para la siguiente iteración
            $fechaCorriente->addDay();

            // Cláusula de seguridad para evitar bucles infinitos (máximo 2 años de búsqueda)
            if ($sesionesAsignadas < $totalSesionesAAasignar && $fechaCorriente->diffInYears(Carbon::parse($this->fecha_inicio)) > 2) {
                break;
            }
        }

        // 5. Inserción masiva
        if (!empty($clasesParaInsertar)) {
            DB::table('seccion_clases')->insert($clasesParaInsertar);
        }
    }

    #[On('deleteSeccion')]
    public function deleteSeccion($id)
    {
        $matriculados = DB::table('matriculas')->where('seccion_id', $id)->where('estado', 'ACTIVA')->count();
        if ($matriculados > 0) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'No permitido', 'text' => "Hay $matriculados alumnos matriculados."]);
            return;
        }

        DB::transaction(function () use ($id) {
            DB::table('seccion_clases')->where('seccion_id', $id)->delete();
            DB::table('horarios')->where('seccion_id', $id)->delete();
            Seccion::find($id)->delete();
        });

        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Eliminado', 'text' => 'Sección eliminada correctamente.']);
    }

    public function render()
    {
        $secciones = Seccion::with(['curso', 'docentes.user', 'periodo'])
            ->withCount(['matriculas as matriculas_activas' => fn($q) => $q->where('estado', 'ACTIVA')])
            ->where(function($q) {
                $q->where('nombre', 'ilike', '%' . $this->search . '%')
                  ->orWhereHas('curso', fn($c) => $c->where('nombre', 'ilike', '%' . $this->search . '%'));
            })
            ->latest()
            ->paginate(10);

        return view('livewire.seccion-manager', ['secciones_list' => $secciones]);
    }
}