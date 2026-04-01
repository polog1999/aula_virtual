<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Sesion;
use App\Models\Categoria;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class CursoConstructor extends Component
{
    use WithFileUploads;

    public $cursos, $categorias;
    public $cursoSeleccionadoId;

    public $isCourseModalOpen = false;
    public $isModuleModalOpen = false;
    public $isSessionModalOpen = false;

    // Form Curso
    public $curso_id, $nombre, $descripcion, $categoria_id, $activo = 1, $imagen, $imagen_actual;
    
    // Form Módulo
    public $modulo_id, $mod_nombre, $mod_descripcion, $mod_orden, $mod_disponible, $mod_activo = 1;
    
    // Form Sesión
    public $sesion_id, $ses_modulo_id, $ses_titulo, $ses_activo = 1;

    public function mount($curso_id = null)
    {
        $this->categorias = Categoria::all();
        $this->loadCursos();
        if ($curso_id) { $this->selectCurso($curso_id); }
    }

    public function loadCursos()
    {
        $this->cursos = Curso::withCount('modulos')->get();
    }

    public function selectCurso($id)
    {
        $this->cursoSeleccionadoId = $id;
    }

    public function getCursoSeleccionadoProperty()
    {
        if (!$this->cursoSeleccionadoId) return null;
        return Curso::with(['modulos' => function($q) {
            $q->orderBy('orden', 'asc')->with('sesiones');
        }, 'categoria'])->find($this->cursoSeleccionadoId);
    }

    // --- ACCIONES DE CURSO ---
    public function openCourseModal($id = null)
    {
        $this->reset(['curso_id', 'nombre', 'descripcion', 'categoria_id', 'activo', 'imagen', 'imagen_actual']);
        if ($id) {
            $curso = Curso::find($id);
            $this->curso_id = $id;
            $this->nombre = $curso->nombre;
            $this->descripcion = $curso->descripcion;
            $this->categoria_id = $curso->categoria_id;
            $this->activo = $curso->activo;
            $this->imagen_actual = $curso->imagen; // Guardamos la ruta actual para mostrarla
        }
        $this->isCourseModalOpen = true;
    }

    public function saveCurso()
    {
        $this->validate([
            'nombre' => 'required|max:200|unique:cursos,nombre,' . $this->curso_id,
            'descripcion' => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $data = [
            'nombre' => mb_strtoupper($this->nombre),
            'descripcion' => $this->descripcion,
            'categoria_id' => $this->categoria_id,
            'activo' => $this->activo,
        ];

        // Manejo de Imagen
        if ($this->imagen) {
            // Si existe una imagen anterior, la borramos del disco
            if ($this->imagen_actual) {
                Storage::disk('public')->delete($this->imagen_actual);
            }
            // Guardamos la nueva imagen con nombre único generado por Laravel
            $data['imagen'] = $this->imagen->store('cursos', 'public');
        }

        if ($this->curso_id) {
            Curso::find($this->curso_id)->update($data);
        } else {
            Curso::create($data);
        }

        $this->isCourseModalOpen = false;
        $this->loadCursos();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Curso Guardado']);
    }

    #[On('deleteCurso')] 
    public function deleteCurso($id)
    {
        $curso = Curso::withCount('modulos')->find($id);
        if (!$curso) return;
        if ($curso->modulos_count > 0) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'No permitido', 'text' => 'El curso tiene unidades asociadas.']);
            return;
        }

        // Borrar imagen del disco antes de borrar el registro
        if ($curso->imagen) {
            Storage::disk('public')->delete($curso->imagen);
        }

        $curso->delete();
        $this->cursoSeleccionadoId = null;
        $this->loadCursos();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Curso eliminado']);
    }

    // --- MÉTODOS DE MÓDULO Y SESIÓN (SIN CAMBIOS RESPECTO AL ANTERIOR) ---
    public function openModuleModal($id = null) {
        $this->reset(['modulo_id', 'mod_nombre', 'mod_descripcion', 'mod_orden', 'mod_disponible', 'mod_activo']);
        if ($id) {
            $mod = Modulo::find($id);
            $this->modulo_id = $id; $this->mod_nombre = $mod->nombre;
            $this->mod_orden = $mod->orden; $this->mod_disponible = $mod->disponible_desde; $this->mod_activo = $mod->activo;
        } else {
            $siguiente = (Modulo::where('curso_id', $this->cursoSeleccionadoId)->max('orden') ?? 0) + 1;
            $this->mod_orden = $siguiente; $this->mod_nombre = "UNIDAD " . $siguiente; $this->mod_activo = 1;
        }
        $this->isModuleModalOpen = true;
    }

    public function saveModulo() {
        $this->validate(['mod_disponible' => 'required|date']);
        $data = ['curso_id' => $this->cursoSeleccionadoId, 'nombre' => $this->mod_nombre, 'descripcion' => 'Estructura automática', 'orden' => $this->mod_orden, 'disponible_desde' => $this->mod_disponible, 'activo' => $this->mod_activo];
        if ($this->modulo_id) { Modulo::find($this->modulo_id)->update($data); } else { Modulo::create($data); }
        $this->isModuleModalOpen = false; $this->loadCursos();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Unidad guardada']);
    }

    #[On('deleteModulo')]
    public function deleteModulo($id) {
        $modulo = Modulo::withCount('sesiones')->find($id);
        if (!$modulo || $modulo->sesiones_count > 0) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Error', 'text' => 'La unidad tiene sesiones.']); return;
        }
        $modulo->delete(); $this->loadCursos();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Unidad eliminada']);
    }

    public function openSessionModal($moduloId, $sesionId = null) {
        $this->reset(['sesion_id', 'ses_titulo', 'ses_activo']);
        $this->ses_modulo_id = $moduloId;
        if ($sesionId) {
            $ses = Sesion::find($sesionId);
            $this->sesion_id = $sesionId; $this->ses_titulo = $ses->titulo; $this->ses_activo = $ses->activo;
        }
        $this->isSessionModalOpen = true;
    }

    public function saveSesion() {
        $this->validate(['ses_titulo' => 'required|max:255']);
        $data = ['modulo_id' => $this->ses_modulo_id, 'titulo' => mb_strtoupper($this->ses_titulo), 'activo' => $this->ses_activo, 'descripcion' => 'Pendiente...', 'es_evaluacion' => false];
        if ($this->sesion_id) { Sesion::find($this->sesion_id)->update($data); } else { Sesion::create($data); }
        $this->isSessionModalOpen = false;
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Sesión configurada']);
    }

    #[On('deleteSesion')]
    public function deleteSesion($id) {
        $ses = Sesion::find($id); if ($ses) $ses->delete();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Sesión eliminada']);
    }

    public function render()
    {
        return view('livewire.curso-constructor');
    }
}