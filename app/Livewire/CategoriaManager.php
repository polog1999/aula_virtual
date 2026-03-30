<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Categoria;
use Illuminate\Database\QueryException;
use Livewire\Attributes\On;

class CategoriaManager extends Component
{
    use WithPagination;

    // Propiedades
    public $search = '';
    public $isModalOpen = false;
    
    // Campos del Formulario
    public $categoriaId;
    public $nombre;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->reset(['nombre', 'categoriaId']);

        if ($id) {
            $this->categoriaId = $id;
            $categoria = Categoria::findOrFail($id);
            $this->nombre = $categoria->nombre;
        }

        $this->isModalOpen = true;
    }

    public function save()
    {
        // Validación Robusta
        $rules = [
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
        ];

        $messages = [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Ya existe una categoría con este nombre.',
        ];

        $this->validate($rules, $messages);

        try {
            if ($this->categoriaId) {
                Categoria::find($this->categoriaId)->update([
                    'nombre' => mb_convert_case($this->nombre, MB_CASE_UPPER, "UTF-8")
                ]);
                $msg = 'Categoría actualizada correctamente.';
            } else {
                Categoria::create([
                    'nombre' => mb_convert_case($this->nombre, MB_CASE_UPPER, "UTF-8")
                ]);
                $msg = 'Categoría creada correctamente.';
            }

            $this->isModalOpen = false;
            $this->dispatch('swal', ['icon' => 'success', 'title' => 'Éxito', 'text' => $msg]);

        } catch (\Exception $e) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Error', 'text' => 'Ocurrió un error inesperado.']);
        }
    }

    #[On('deleteCategoria')]
    public function delete($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();
            $this->dispatch('swal', ['icon' => 'success', 'title' => 'Eliminado', 'text' => 'Registro borrado con éxito.']);
        } catch (QueryException $e) {
            if ($e->getCode() == "23503") { // Error de llave foránea en Postgres/MySQL
                $this->dispatch('swal', [
                    'icon' => 'error', 
                    'title' => 'No permitido', 
                    'text' => 'No se puede eliminar la categoría porque tiene cursos asociados.'
                ]);
            } else {
                $this->dispatch('swal', ['icon' => 'error', 'title' => 'Error', 'text' => 'No se pudo eliminar el registro.']);
            }
        }
    }

    public function render()
    {
        $categorias = Categoria::where('nombre', 'ilike', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.categoria-manager', [
            'categorias_list' => $categorias
        ]);
    }
}