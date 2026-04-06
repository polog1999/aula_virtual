<?php

namespace App\Livewire\Docente;

use Livewire\Component;
use App\Models\Seccion;
use App\Models\Sesion;
use App\Models\SesionRecurso;
use App\Models\Calificacion;
use App\Models\Matricula;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class MisCursos extends Component
{
    use WithFileUploads;

    public $seccionSeleccionadaId;
    
    // Estados de Modales
    public $isAlumnosModalOpen = false;
    public $isEditSesionModalOpen = false;
    public $isCalificarModalOpen = false;

    // Datos para el Cuadro de Notas (Modal Alumnos)
    public $alumnosMatriculados = [];
    public $modulosDelCurso = [];
    public $nombreSeccionModal = '';

    // Formulario de Edición de Sesión
    public $sesionId, $ses_titulo, $ses_descripcion, $ses_evaluacion, $ses_activo;
    
    // Gestión de Recursos
    public $tipo_recurso_nuevo = 'ARCHIVO', $nombre_recurso_nuevo, $archivo_nuevo, $link_nuevo, $recursos_existentes = [];

    // Calificación de una Sesión Específica
    public $sesionCalificarId, $tituloSesionCalificar;
    public $notas_input = []; 

    public function mount()
    {
        $primera = Seccion::where('docente_id', Auth::id())->first();
        if ($primera) {
            $this->selectSeccion($primera->id);
        }
    }

    public function selectSeccion($id)
    {
        $this->seccionSeleccionadaId = $id;
        $this->reset(['isAlumnosModalOpen', 'isEditSesionModalOpen', 'isCalificarModalOpen']);
    }

    // --- MODAL: CUADRO DE NOTAS POR UNIDADES ---
    public function openAlumnosModal($seccionId)
    {
        $seccion = Seccion::with([
            'curso.modulos.sesiones', 
            'matriculas.alumnos.user', 
            'matriculas.calificaciones'
        ])->findOrFail($seccionId);

        $this->nombreSeccionModal = $seccion->nombre;
        $this->modulosDelCurso = $seccion->curso->modulos;
        $this->alumnosMatriculados = $seccion->matriculas;
        
        $this->isAlumnosModalOpen = true;
    }

    // --- MODAL: CALIFICAR UNA EVALUACIÓN ---
    public function openCalificarModal($sesionId)
    {
        $sesion = Sesion::findOrFail($sesionId);
        $this->sesionCalificarId = $sesionId;
        $this->tituloSesionCalificar = $sesion->titulo;

        $seccion = Seccion::with(['matriculas.alumnos.user'])->find($this->seccionSeleccionadaId);
        
        $this->notas_input = [];
        foreach ($seccion->matriculas as $m) {
            $cal = Calificacion::where('matricula_id', $m->id)->where('sesion_id', $sesionId)->first();
            $this->notas_input[$m->id] = $cal ? $cal->nota : null;
        }

        $this->isCalificarModalOpen = true;
    }

    public function guardarNotas()
    {
        foreach ($this->notas_input as $matriculaId => $nota) {
            Calificacion::updateOrCreate(
                ['matricula_id' => $matriculaId, 'sesion_id' => $this->sesionCalificarId],
                ['nota' => ($nota !== '' && $nota !== null ? $nota : null)]
            );
        }
        $this->isCalificarModalOpen = false;
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Éxito', 'text' => 'Calificaciones actualizadas.']);
    }

    // --- MODAL: GESTOR DE SESIÓN Y RECURSOS ---
    public function editSesion($sesionId)
    {
        $sesion = Sesion::with('recursos')->findOrFail($sesionId);
        $this->sesionId = $sesionId;
        $this->ses_titulo = $sesion->titulo;
        $this->ses_descripcion = $sesion->descripcion;
        $this->ses_evaluacion = $sesion->es_evaluacion ? 1 : 0;
        $this->ses_activo = $sesion->activo ? 1 : 0;
        $this->recursos_existentes = $sesion->recursos;
        $this->isEditSesionModalOpen = true;
    }

    public function saveSesion()
    {
        $this->validate(['ses_titulo' => 'required', 'ses_descripcion' => 'required']);
        
        Sesion::find($this->sesionId)->update([
            'titulo' => mb_strtoupper($this->ses_titulo),
            'descripcion' => $this->ses_descripcion,
            'es_evaluacion' => (bool)$this->ses_evaluacion,
            'activo' => (bool)$this->ses_activo
        ]);

        $this->isEditSesionModalOpen = false;
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Actualizado', 'text' => 'Sesión guardada correctamente.']);
    }

    public function addRecurso()
    {
        $this->validate([
            'nombre_recurso_nuevo' => 'required',
            'archivo_nuevo' => $this->tipo_recurso_nuevo == 'ARCHIVO' ? 'required|max:10240' : 'nullable',
            'link_nuevo' => $this->tipo_recurso_nuevo == 'LINK' ? 'required|url' : 'nullable',
        ]);

        $url = $this->tipo_recurso_nuevo === 'ARCHIVO' 
               ? $this->archivo_nuevo->store('recursos', 'public') 
               : $this->link_nuevo;

        SesionRecurso::create([
            'sesion_id' => $this->sesionId,
            'nombre' => mb_strtoupper($this->nombre_recurso_nuevo),
            'url_path' => $url,
            'tipo' => $this->tipo_recurso_nuevo
        ]);

        $this->recursos_existentes = SesionRecurso::where('sesion_id', $this->sesionId)->get();
        $this->reset(['nombre_recurso_nuevo', 'archivo_nuevo', 'link_nuevo']);
    }

    public function deleteRecurso($id)
    {
        $re = SesionRecurso::find($id);
        if ($re->tipo == 'ARCHIVO') Storage::disk('public')->delete($re->url_path);
        $re->delete();
        $this->recursos_existentes = SesionRecurso::where('sesion_id', $this->sesionId)->get();
    }

    // --- PROPIEDADES ---
    public function getSeccionesProperty()
    {
        return Seccion::where('docente_id', Auth::id())->with(['curso.categoria', 'periodo'])->withCount('matriculas')->get();
    }

    public function getSeccionActivaProperty()
    {
        if (!$this->seccionSeleccionadaId) return null;
        return Seccion::with(['curso.modulos.sesiones.recursos', 'periodo', 'matriculas.alumnos.user'])->find($this->seccionSeleccionadaId);
    }

    public function render()
    {
        return view('livewire.docente.mis-cursos');
    }
}