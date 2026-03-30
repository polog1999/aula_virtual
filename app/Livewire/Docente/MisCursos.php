<?php

namespace App\Livewire\Docente;

use Livewire\Component;
use App\Models\Seccion;
use App\Models\Sesion;
use App\Models\Matricula;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class MisCursos extends Component
{
    use WithFileUploads;

    // Propiedades de navegación
    public $secciones;
    public $seccionSeleccionadaId;
    public $search = '';

    // Modales
    public $isAlumnosModalOpen = false;
    public $isEditSesionModalOpen = false;

    // Datos del Modal
    public $alumnos = [];
    public $nombreSeccionModal = '';
    
    // Formulario de Sesión (Contenido del Docente)
    public $sesionId;
    public $ses_titulo, $ses_descripcion, $ses_evaluacion, $ses_activo, $ses_link;

    public function mount()
    {
        $this->loadSecciones();
    }

    public function loadSecciones()
    {
        // Traemos las secciones asignadas al docente logueado
        $docenteId = Auth::user()->id;
        $this->secciones = Seccion::where('docente_id', $docenteId)
            ->with(['curso.categoria', 'periodo', 'matriculas.alumnos.user'])
            ->withCount('matriculas')
            ->get();
    }

    public function selectSeccion($id)
    {
        $this->seccionSeleccionadaId = ($this->seccionSeleccionadaId == $id) ? null : $id;
    }

    // --- LÓGICA DE ALUMNOS ---
    public function openAlumnosModal($seccionId)
    {
        $seccion = Seccion::with('matriculas.alumnos.user', 'matriculas.alumnos.padre.user')->find($seccionId);
        $this->nombreSeccionModal = $seccion->nombre;
        $this->alumnos = $seccion->matriculas;
        $this->isAlumnosModalOpen = true;
    }

    // --- LÓGICA DE GESTIÓN DE CONTENIDO (SESIONES) ---
    public function editSesion($sesionId)
    {
        $sesion = Sesion::findOrFail($sesionId);
        $this->sesionId = $sesionId;
        $this->ses_titulo = $sesion->titulo;
        $this->ses_descripcion = $sesion->descripcion;
        $this->ses_evaluacion = $sesion->es_evaluacion;
        $this->ses_activo = $sesion->activo;
        // Asumiendo que el link se guarda en la descripción o tienes un campo link_reunion
        // Si no existe el campo, usaremos la descripción para este ejemplo
        $this->isEditSesionModalOpen = true;
    }

    public function saveSesion()
    {
        $this->validate([
            'ses_titulo' => 'required',
            'ses_descripcion' => 'required',
        ]);

        $sesion = Sesion::find($this->sesionId);
        $sesion->update([
            'titulo' => mb_strtoupper($this->ses_titulo),
            'descripcion' => $this->ses_descripcion,
            'es_evaluacion' => $this->ses_evaluacion,
            'activo' => $this->ses_activo,
        ]);

        $this->isEditSesionModalOpen = false;
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Contenido Actualizado', 'text' => 'La sesión ha sido publicada con el nuevo material.']);
    }

    public function getSeccionActivaProperty()
    {
        return Seccion::with(['curso.modulos.sesiones', 'periodo'])->find($this->seccionSeleccionadaId);
    }

    public function render()
    {
        return view('livewire.docente.mis-cursos');
    }
}