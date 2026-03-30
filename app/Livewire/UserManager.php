<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Livewire\Attributes\On;

class UserManager extends Component
{
    use WithPagination;

    // Propiedades de búsqueda y UI
    public $search = '';
    public $isOpen = false;
    public $all_roles;

    // Campos del formulario
    public $userId; // Si existe, es edición
    public $nombres, $apellido_paterno, $apellido_materno;
    public $tipo_documento, $numero_documento, $email, $activo = 1;
    public $roles_seleccionados = [];

    protected $queryString = ['search'];

    public function mount()
    {
        $this->all_roles = Role::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->reset(['userId', 'nombres', 'apellido_paterno', 'apellido_materno', 'tipo_documento', 'numero_documento', 'email', 'activo', 'roles_seleccionados']);

        if ($id) {
            $user = User::findOrFail($id);
            $this->userId = $user->id;
            $this->nombres = $user->nombres;
            $this->apellido_paterno = $user->apellido_paterno;
            $this->apellido_materno = $user->apellido_materno;
            $this->tipo_documento = $user->tipo_documento;
            $this->numero_documento = $user->numero_documento;
            $this->email = $user->email;
            $this->activo = $user->activo ? 1 : 0;
            $this->roles_seleccionados = $user->roles->pluck('name')->toArray();
        } else {
            $this->activo = 1;
        }

        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate([
            'nombres' => 'required|string|max:100',
            'tipo_documento' => 'required|in:DNI,CE',
            'numero_documento' => 'required|string|max:12|unique:users,numero_documento,' . $this->userId,
            'email' => 'required|email|max:320|unique:users,email,' . $this->userId,
            'roles_seleccionados' => 'required|array|min:1',
        ], [
            'numero_documento.unique' => 'El número de documento ya está registrado.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'roles_seleccionados.required' => 'Debes asignar al menos un rol.',
        ]);

        try {
            DB::transaction(function () {
                $data = [
                    'nombres' => mb_convert_case($this->nombres, MB_CASE_UPPER, "UTF-8"),
                    'apellido_paterno' => mb_convert_case($this->apellido_paterno, MB_CASE_UPPER, "UTF-8"),
                    'apellido_materno' => mb_convert_case($this->apellido_materno, MB_CASE_UPPER, "UTF-8"),
                    'tipo_documento' => $this->tipo_documento,
                    'numero_documento' => $this->numero_documento,
                    'email' => $this->email,
                    'activo' => $this->activo,
                    'role' => count($this->roles_seleccionados) > 0 ? $this->roles_seleccionados[0] : 'ALUMNO', // Fallback para campo legacy
                ];

                if (!$this->userId) {
                    $data['password'] = Hash::make($this->numero_documento);
                    $user = User::create($data);
                } else {
                    $user = User::find($this->userId);
                    $user->update($data);
                }

                // Sincronizar Roles de Spatie
                $user->syncRoles($this->roles_seleccionados);

                // Lógica de Docente
                if (in_array('docente', array_map('strtolower', $this->roles_seleccionados))) {
                    $user->docente()->updateOrCreate(['user_id' => $user->id]);
                    $user->update(['es_docente' => true]);
                } else {
                    $user->update(['es_docente' => false]);
                }
            });

            $this->isOpen = false;
            $this->dispatch('swal', ['icon' => 'success', 'title' => 'Éxito', 'text' => 'Usuario guardado correctamente.']);
            
        } catch (QueryException $e) {
            if ($e->getCode() === '23505') {
                $this->dispatch('swal', ['icon' => 'error', 'title' => 'Duplicado', 'text' => 'El documento o email ya existen.']);
            } else {
                $this->dispatch('swal', ['icon' => 'error', 'title' => 'Error', 'text' => 'Error de base de datos: ' . $e->getMessage()]);
            }
        }
    }

    #[On('deleteUser')]
    public function delete($id)
    {
        try {
            User::findOrFail($id)->delete();
            $this->dispatch('swal', ['icon' => 'success', 'title' => 'Eliminado', 'text' => 'Usuario borrado con éxito.']);
        } catch (QueryException $e) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'No permitido', 'text' => 'No se puede eliminar porque tiene registros vinculados.']);
        }
    }

    public function render()
    {
        $query = User::query()->with('roles');

        if ($this->search) {
            $s = $this->search;
            $query->where(function($q) use ($s) {
                $q->where('nombres', 'ilike', "%{$s}%")
                  ->orWhere('apellido_paterno', 'ilike', "%{$s}%")
                  ->orWhere('apellido_materno', 'ilike', "%{$s}%")
                  ->orWhere('email', 'ilike', "%{$s}%")
                  ->orWhere('numero_documento', 'ilike', "%{$s}%");
            });
        }

        return view('livewire.user-manager', [
            'users_list' => $query->orderBy('nombres', 'asc')->paginate(10)
        ]);
    }
}