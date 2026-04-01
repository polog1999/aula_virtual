<?php

namespace App\Livewire\Docente;

use Livewire\Component;
use App\Models\Seccion;
use App\Models\Sesion;
use App\Models\SesionRecurso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class MisCursos extends Component
{
    use WithFileUploads;

    public $secciones;
    public $seccionSeleccionadaId;
    public $isAlumnosModalOpen = false;
    public $isEditSesionModalOpen = false;

    // Datos Sesión
    public $sesionId;
    public $ses_titulo, $ses_descripcion, $ses_evaluacion, $ses_activo;
    
    // Gestión de Recursos Nuevos
    public $tipo_recurso_nuevo = 'ARCHIVO'; // ARCHIVO o LINK
    public $nombre_recurso_nuevo;
    public $archivo_nuevo;
    public $link_nuevo;
    
    public $recursos_existentes = [];

    public function mount() { $this->loadSecciones(); }

    public function loadSecciones() {
        $this->secciones = Seccion::where('docente_id', Auth::id())
            ->with(['curso.categoria', 'periodo'])
            ->withCount('matriculas')->get();
    }

    public function selectSeccion($id) {
        $this->seccionSeleccionadaId = ($this->seccionSeleccionadaId == $id) ? null : $id;
    }

    public function editSesion($sesionId) {
        $sesion = Sesion::with('recursos')->findOrFail($sesionId);
        $this->sesionId = $sesionId;
        $this->ses_titulo = $sesion->titulo;
        $this->ses_descripcion = $sesion->descripcion;
        $this->ses_evaluacion = $sesion->es_evaluacion;
        $this->ses_activo = $sesion->activo;
        
        $this->recursos_existentes = $sesion->recursos;
        $this->reset(['nombre_recurso_nuevo', 'archivo_nuevo', 'link_nuevo']);
        $this->isEditSesionModalOpen = true;
    }

    // Agregar recurso inmediatamente a la sesión
    public function addRecurso() {
        $this->validate([
            'nombre_recurso_nuevo' => 'required|string|max:100',
            'tipo_recurso_nuevo' => 'required|in:ARCHIVO,LINK',
            'archivo_nuevo' => 'required_if:tipo_recurso_nuevo,ARCHIVO|max:10240', // 10MB
            'link_nuevo' => 'required_if:tipo_recurso_nuevo,LINK|nullable|url',
        ]);

        if ($this->tipo_recurso_nuevo === 'ARCHIVO') {
            $path = $this->archivo_nuevo->store('recursos_clases', 'public');
            $url = $path;
        } else {
            $url = $this->link_nuevo;
        }

        SesionRecurso::create([
            'sesion_id' => $this->sesionId,
            'nombre' => mb_strtoupper($this->nombre_recurso_nuevo),
            'url_path' => $url,
            'tipo' => $this->tipo_recurso_nuevo
        ]);

        $this->reset(['nombre_recurso_nuevo', 'archivo_nuevo', 'link_nuevo']);
        $this->recursos_existentes = SesionRecurso::where('sesion_id', $this->sesionId)->get();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Recurso Agregado']);
    }

    public function deleteRecurso($recursoId) {
        $recurso = SesionRecurso::find($recursoId);
        if ($recurso->tipo === 'ARCHIVO') {
            Storage::disk('public')->delete($recurso->url_path);
        }
        $recurso->delete();
        $this->recursos_existentes = SesionRecurso::where('sesion_id', $this->sesionId)->get();
    }

    public function saveSesion() {
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
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Sesión Actualizada']);
    }

    public function getSeccionActivaProperty() {
        if (!$this->seccionSeleccionadaId) return null;
        return Seccion::with(['curso.modulos.sesiones.recursos', 'periodo'])->find($this->seccionSeleccionadaId);
    }

    public function render() { return view('livewire.docente.mis-cursos'); }
}