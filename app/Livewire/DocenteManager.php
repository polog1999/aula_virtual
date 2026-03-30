<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class DocenteManager extends Component
{
    use WithPagination;

    // Propiedades de búsqueda
    public $search = '';
    public $isModalOpen = false;

    // Campos del formulario (exactamente los de tu vista)
    public $docenteId;
    public $editNombre;
    public $editApPaterno;
    public $editApMaterno;
    public $editTipo;
    public $editDocumento;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal($id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);
        
        $this->docenteId = $user->id;
        $this->editNombre = $user->nombres;
        $this->editApPaterno = $user->apellido_paterno;
        $this->editApMaterno = $user->apellido_materno;
        $this->editTipo = $user->tipo_documento;
        $this->editDocumento = $user->numero_documento;

        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'editNombre' => 'required|string|max:100',
            'editApPaterno' => 'required|string|max:100',
            'editApMaterno' => 'required|string|max:100',
            'editTipo' => 'required|in:DNI,CE',
            'editDocumento' => 'required|string|max:12|unique:users,numero_documento,' . $this->docenteId,
        ], [
            'editDocumento.unique' => 'Este número de documento ya está registrado.'
        ]);

        try {
            $user = User::findOrFail($this->docenteId);
            $user->update([
                'nombres' => mb_convert_case($this->editNombre, MB_CASE_UPPER, "UTF-8"),
                'apellido_paterno' => mb_convert_case($this->editApPaterno, MB_CASE_UPPER, "UTF-8"),
                'apellido_materno' => mb_convert_case($this->editApMaterno, MB_CASE_UPPER, "UTF-8"),
                'tipo_documento' => $this->editTipo,
                'numero_documento' => $this->editDocumento
            ]);

            $this->isModalOpen = false;
            $this->dispatch('swal', ['icon' => 'success', 'title' => 'Éxito', 'text' => 'Docente actualizado correctamente.']);
        } catch (\Exception $e) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Error', 'text' => 'No se pudo actualizar al docente.']);
        }
    }

    #[On('deleteDocente')]
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            // Si el docente tiene secciones, la base de datos lanzará error por FK 
            // a menos que esté en cascade. El try-catch lo maneja.
            $user->delete();
            $this->dispatch('swal', ['icon' => 'success', 'title' => 'Eliminado', 'text' => 'Docente eliminado correctamente.']);
        } catch (\Exception $e) {
            $this->dispatch('swal', [
                'icon' => 'error', 
                'title' => 'No permitido', 
                'text' => 'No se puede eliminar al docente porque tiene secciones o registros asociados.'
            ]);
        }
    }

    public function render()
    {
        $query = User::query()->where('es_docente', true);

        if ($this->search) {
            $s = $this->search;
            $query->where(function($q) use ($s) {
                $q->where('nombres', 'ilike', "%{$s}%")
                  ->orWhere('apellido_paterno', 'ilike', "%{$s}%")
                  ->orWhere('apellido_materno', 'ilike', "%{$s}%")
                  ->orWhereHas('docente.secciones.curso', function ($sub) use ($s) {
                      $sub->where('nombre', 'ilike', "%{$s}%");
                  })
                  ->orWhereHas('docente.secciones', function ($sub) use ($s) {
                      $sub->where('nombre', 'ilike', "%{$s}%");
                  });
            });
        }

        $users = $query->with(['docente.secciones.curso.categoria'])
                      ->orderBy('updated_at', 'desc')
                      ->paginate(10);

        return view('livewire.docente-manager', [
            'users_list' => $users
        ]);
    }
}