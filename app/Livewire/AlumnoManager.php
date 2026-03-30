<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class AlumnoManager extends Component
{
    use WithPagination;

    // Propiedades de búsqueda y estado
    public $search = '';
    public $isModalOpen = false;

    // Campos del formulario
    public $alumnoId;
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
        
        $this->alumnoId = $user->id;
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
            'editDocumento' => 'required|string|max:12|unique:users,numero_documento,' . $this->alumnoId,
        ], [
            'editDocumento.unique' => 'Este número de documento ya pertenece a otro usuario.'
        ]);

        try {
            $user = User::findOrFail($this->alumnoId);
            $user->update([
                'nombres' => mb_convert_case($this->editNombre, MB_CASE_UPPER, "UTF-8"),
                'apellido_paterno' => mb_convert_case($this->editApPaterno, MB_CASE_UPPER, "UTF-8"),
                'apellido_materno' => mb_convert_case($this->editApMaterno, MB_CASE_UPPER, "UTF-8"),
                'tipo_documento' => $this->editTipo,
                'numero_documento' => $this->editDocumento
            ]);

            $this->isModalOpen = false;
            $this->dispatch('swal', ['icon' => 'success', 'title' => 'Actualizado', 'text' => 'Datos del alumno actualizados con éxito.']);
        } catch (\Exception $e) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Error', 'text' => 'No se pudo procesar la solicitud.']);
        }
    }

    // Aunque no estaba activo en tu controlador, dejo el delete listo por si se habilita
    #[On('deleteAlumno')]
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            $this->dispatch('swal', ['icon' => 'success', 'title' => 'Eliminado', 'text' => 'Registro eliminado.']);
        } catch (\Exception $e) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Error', 'text' => 'El alumno tiene registros de matrícula activos.']);
        }
    }

    public function render()
    {
        $query = User::query()->has('alumno');

        if ($this->search) {
            $s = $this->search;
            $query->where(function($q) use ($s) {
                $q->where('nombres', 'ilike', "%{$s}%")
                  ->orWhere('apellido_paterno', 'ilike', "%{$s}%")
                  ->orWhere('apellido_materno', 'ilike', "%{$s}%")
                  ->orWhere('numero_documento', 'ilike', "%{$s}%");
            });
        }

        $users = $query->with(['alumno.matricula.seccion.curso.categoria'])
                      ->orderBy('nombres', 'asc')
                      ->paginate(10);

        return view('livewire.alumno-manager', [
            'users_list' => $users
        ]);
    }
}