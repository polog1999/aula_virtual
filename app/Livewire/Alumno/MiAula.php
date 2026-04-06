<?php

namespace App\Livewire\Alumno;

use Livewire\Component;
use App\Models\Matricula;
use App\Models\Sesion;
use App\Models\Calificacion;
use Illuminate\Support\Facades\Auth;

class MiAula extends Component
{
    public $search = '';
    public $selectedMatriculaId; 
    public $openModules = [];    
    
    // Propiedades para el Modal
    public $isResourceModalOpen = false;
    public $sesionSeleccionada;
    public $notaSesion = null;

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

    public function openResourceModal($sesionId)
    {
        $this->sesionSeleccionada = Sesion::with('recursos')->find($sesionId);
        
        // Buscar la nota específica para esta sesión y esta matrícula
        $calificacion = Calificacion::where('sesion_id', $sesionId)
            ->where('matricula_id', $this->selectedMatriculaId)
            ->first();
            
        $this->notaSesion = $calificacion ? $calificacion->nota : null;
        $this->isResourceModalOpen = true;
    }

    public function closeResourceModal()
    {
        $this->isResourceModalOpen = false;
        $this->reset(['sesionSeleccionada', 'notaSesion']);
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

        // Cargamos la matrícula con sus notas para cruzarlas en la vista
        return Matricula::with([
            'seccion.curso.modulos.sesiones.recursos',
            'seccion.docentes.user',
            'calificaciones' // Importante para ver las notas en la lista
        ])->find($this->selectedMatriculaId);
    }

    public function render()
    {
        return view('livewire.alumno.mi-aula');
    }
}