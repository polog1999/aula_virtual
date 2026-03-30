<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Curso;
use Livewire\WithPagination;

class CatalogoCursos extends Component
{
    use WithPagination;

    public $search = '';

    // Resetear página cuando se busca
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Curso::query()
            ->where('activo', true)
            ->withCount(['secciones as talleres_count' => function($q) {
                $q->where('activo', true);
            }])
            ->whereHas('secciones', function($q) {
                $q->where('activo', true);
            });

        if ($this->search) {
            $query->where('nombre', 'ilike', '%' . $this->search . '%');
        }

        $disciplinas = $query->orderBy('nombre', 'asc')->paginate(12);

        return view('livewire.public.catalogo-cursos', [
            'disciplinas' => $disciplinas
        ])->layout('layouts.public'); // <--- ESTA LÍNEA ES LA CLAVE;
        // ->layout('layouts.public'); // Asumiendo que tienes un layout público
    }
}