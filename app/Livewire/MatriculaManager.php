<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Matricula;
use App\Models\Seccion;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AlumnosMatriculadosExport;

class MatriculaManager extends Component
{
    use WithPagination;

    // Propiedades de búsqueda y modales
    public $search = '';
    public $isModalOpen = false;

    // Datos para selects
    public $secciones_list_select;

    // Campos del formulario
    public $matriculaId;
    public $seccion_id;
    public $estado;

    protected $queryString = ['search'];

    public function mount()
    {
        // Cargamos las secciones para el select del modal una sola vez
        $this->secciones_list_select = Seccion::with(['curso.categoria', 'docentes.user'])
            ->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal($id)
    {
        $this->resetValidation();
        $matricula = Matricula::findOrFail($id);
        
        $this->matriculaId = $id;
        $this->seccion_id = $matricula->seccion_id;
        $this->estado = $matricula->estado;

        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'seccion_id' => 'required|exists:secciones,id',
            'estado' => 'required|in:ACTIVA,INACTIVA,RETIRADO,FINALIZADO',
        ]);

        try {
            $matricula = Matricula::findOrFail($this->matriculaId);
            $matricula->update([
                'seccion_id' => $this->seccion_id,
                'estado' => $this->estado
            ]);

            $this->isModalOpen = false;
            $this->dispatch('swal', ['icon' => 'success', 'title' => 'Éxito', 'text' => 'Matrícula actualizada correctamente.']);
        } catch (QueryException $e) {
            if ($e->getCode() === '23505') {
                $this->dispatch('swal', ['icon' => 'error', 'title' => 'Duplicado', 'text' => 'Este alumno ya está matriculado en la sección seleccionada.']);
            } else {
                $this->dispatch('swal', ['icon' => 'error', 'title' => 'Error', 'text' => 'Ocurrió un error al actualizar.']);
            }
        }
    }

    public function exportar()
    {
        $fileName = 'reporte-alumnos-matriculados-' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new AlumnosMatriculadosExport, $fileName);
    }

    public function render()
    {
        $query = Matricula::query();

        if ($this->search) {
            $s = $this->search;
            $query->where(function($q) use ($s) {
                $q->whereHas('seccion.curso', function ($sub) use ($s) {
                    $sub->where('nombre', 'ilike', "%{$s}%");
                })->orWhereHas('seccion.curso.categoria', function ($sub) use ($s) {
                    $sub->where('nombre', 'ilike', "%{$s}%");
                })->orWhereHas('alumnos.user', function ($sub) use ($s) {
                    $sub->where('nombres', 'ilike', "%{$s}%")
                       ->orWhere('apellido_paterno', 'ilike', "%{$s}%")
                       ->orWhere('apellido_materno', 'ilike', "%{$s}%")
                       ->orWhere('numero_documento', 'ilike', "%{$s}%");
                })->orWhereHas('seccion', function ($sub) use ($s) {
                    $sub->where('nombre', 'ilike', "%{$s}%");
                });
            });
        }

        $matriculas = $query->with(['alumnos.user', 'seccion.curso.categoria', 'seccion.docentes.user'])
            ->orderBy('fecha_matricula', 'desc')
            ->paginate(10);

        return view('livewire.matricula-manager', [
            'matriculas_list' => $matriculas
        ]);
    }
}