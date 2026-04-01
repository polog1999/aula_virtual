<?php

namespace App\Livewire\Alumno;

use Livewire\Component;
use App\Models\Matricula;
use App\Models\Sesion;
use Illuminate\Support\Facades\Auth;

class MiAula extends Component
{
    public $search = '';
    public $selectedMatriculaId; 
    public $openModules = [];    
    
    // Propiedades para el Modal de Recurso
    public $isResourceModalOpen = false;
    public $sesionSeleccionada;

    public function mount()
    {
        $primera = $this->matriculas->first();
        if ($primera) {
            $this->selectCurso($primera->id);
        }
    }

    public function selectCurso($id)
    {
        $this->selectedMatriculaId = $id;
        $this->openModules = []; 
    }

    public function toggleModulo($moduloId)
    {
        if (in_array($moduloId, $this->openModules)) {
            $this->openModules = array_diff($this->openModules, [$moduloId]);
        } else {
            $this->openModules[] = $moduloId;
        }
    }

    // --- NUEVO: Lógica para abrir modal de recursos ---
    public function openResourceModal($sesionId)
    {
        $this->sesionSeleccionada = Sesion::with('recursos')->find($sesionId);
        $this->isResourceModalOpen = true;
    }

    public function closeResourceModal()
    {
        $this->isResourceModalOpen = false;
        $this->reset('sesionSeleccionada');
    }

    public function getMatriculasProperty()
    {
        return Matricula::where('alumno_id', Auth::id())
            ->where('estado', 'ACTIVA')
            ->with(['seccion.curso.categoria', 'seccion.periodo', 'seccion.docentes.user'])
            ->whereHas('seccion.curso', function($q) {
                $q->where('nombre', 'ilike', '%' . $this->search . '%');
            })->get();
    }

    public function getMatriculaSeleccionadaProperty()
    {
        if (!$this->selectedMatriculaId) return null;
        return Matricula::with([
            'seccion.curso.modulos' => function($q) {
                $q->orderBy('orden', 'asc')->with('sesiones.recursos');
            },
            'seccion.docentes.user'
        ])->find($this->selectedMatriculaId);
    }

    public function render()
    {
        return view('livewire.alumno.mi-aula');
    }
}