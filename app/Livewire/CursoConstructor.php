<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Sesion;
use App\Models\Categoria;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class CursoConstructor extends Component
{
    use WithFileUploads;

    public $cursos, $categorias;
    public $cursoSeleccionadoId;

    public $isCourseModalOpen = false;
    public $isModuleModalOpen = false;
    public $isSessionModalOpen = false;

    // Form Curso
    public $curso_id, $nombre, $descripcion, $categoria_id, $activo = 1, $imagen;
    // Form Módulo
    public $modulo_id, $mod_nombre, $mod_descripcion, $mod_orden, $mod_disponible, $mod_activo = 1;
    // Form Sesión (Simplificado a molde)
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
        $this->reset(['curso_id', 'nombre', 'descripcion', 'categoria_id', 'activo', 'imagen']);
        if ($id) {
            $curso = Curso::find($id);
            $this->curso_id = $id;
            $this->nombre = $curso->nombre;
            $this->descripcion = $curso->descripcion;
            $this->categoria_id = $curso->categoria_id;
            $this->activo = $curso->activo;
        }
        $this->isCourseModalOpen = true;
    }

    public function saveCurso()
    {
        $this->validate([
            'nombre' => 'required|max:200|unique:cursos,nombre,' . $this->curso_id,
            'descripcion' => 'required',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $data = [
            'nombre' => mb_strtoupper($this->nombre),
            'descripcion' => $this->descripcion,
            'categoria_id' => $this->categoria_id,
            'activo' => $this->activo,
        ];

        if ($this->imagen) {
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
        $curso->delete();
        $this->cursoSeleccionadoId = null;
        $this->loadCursos();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Curso eliminado']);
    }

    // --- ACCIONES DE MÓDULO ---
    public function openModuleModal($id = null)
    {
        $this->reset(['modulo_id', 'mod_nombre', 'mod_descripcion', 'mod_orden', 'mod_disponible', 'mod_activo']);
        if ($id) {
            $mod = Modulo::find($id);
            $this->modulo_id = $id;
            $this->mod_nombre = $mod->nombre;
            $this->mod_descripcion = $mod->descripcion;
            $this->mod_orden = $mod->orden;
            $this->mod_disponible = $mod->disponible_desde;
            $this->mod_activo = $mod->activo;
        } else {
            $this->mod_orden = (Modulo::where('curso_id', $this->cursoSeleccionadoId)->max('orden') ?? 0) + 1;
        }
        $this->isModuleModalOpen = true;
    }

    public function saveModulo()
    {
        $this->validate([
            'mod_nombre' => 'required|max:100',
            'mod_descripcion' => 'required',
            'mod_orden' => 'required|integer',
            'mod_disponible' => 'required|date',
        ]);

        $data = [
            'curso_id' => $this->cursoSeleccionadoId,
            'nombre' => mb_strtoupper($this->mod_nombre),
            'descripcion' => $this->mod_descripcion,
            'orden' => $this->mod_orden,
            'disponible_desde' => $this->mod_disponible,
            'activo' => $this->mod_activo
        ];

        if ($this->modulo_id) {
            Modulo::find($this->modulo_id)->update($data);
        } else {
            Modulo::create($data);
        }

        $this->isModuleModalOpen = false;
        $this->loadCursos(); 
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Unidad guardada']);
    }

    #[On('deleteModulo')]
    public function deleteModulo($id)
    {
        $modulo = Modulo::withCount('sesiones')->find($id);
        if (!$modulo) return;
        if ($modulo->sesiones_count > 0) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'No permitido', 'text' => 'La unidad tiene sesiones asociadas.']);
            return;
        }
        $modulo->delete();
        $this->loadCursos();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Unidad eliminada']);
    }

    // --- ACCIONES DE SESIÓN (MOLDE) ---
    public function openSessionModal($moduloId, $sesionId = null)
    {
        $this->reset(['sesion_id', 'ses_titulo', 'ses_activo']);
        $this->ses_modulo_id = $moduloId;
        if ($sesionId) {
            $ses = Sesion::find($sesionId);
            $this->sesion_id = $sesionId;
            $this->ses_titulo = $ses->titulo;
            $this->ses_activo = $ses->activo;
        }
        $this->isSessionModalOpen = true;
    }

    public function saveSesion()
    {
        $this->validate(['ses_titulo' => 'required|max:255']);

        $data = [
            'modulo_id' => $this->ses_modulo_id,
            'titulo' => mb_strtoupper($this->ses_titulo),
            'activo' => $this->ses_activo,
            // Valores por defecto para el molde
            'descripcion' => 'Pendiente de contenido por el docente',
            'es_evaluacion' => false, 
        ];

        if ($this->sesion_id) {
            Sesion::find($this->sesion_id)->update($data);
        } else {
            Sesion::create($data);
        }

        $this->isSessionModalOpen = false;
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Estructura de sesión creada']);
    }

    #[On('deleteSesion')]
    public function deleteSesion($id)
    {
        $sesion = Sesion::find($id);
        if ($sesion) {
            $sesion->delete();
            $this->dispatch('swal', ['icon' => 'success', 'title' => 'Sesión eliminada']);
        }
    }

    public function render()
    {
        return view('livewire.curso-constructor');
    }
}