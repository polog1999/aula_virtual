<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Curso;
use App\Models\Seccion;
use App\Models\Categoria;
use Livewire\WithPagination;

class SeccionesCurso extends Component
{
    use WithPagination;

    public $disciplina; // El curso seleccionado
    public $search = '';
    public $selectedCategory = 'todos';

    public function mount(Curso $disciplina)
    {
        $this->disciplina = $disciplina;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Seccion::query()
            ->with(['curso.categoria', 'docentes.user', 'periodo', 'horarios'])
            ->withCount(['matriculas as matriculas_activas_count' => function ($q) {
                $q->where('estado', 'ACTIVA');
            }])
            ->where('curso_id', $this->disciplina->id)
            ->where('activo', true);

        // Filtro por nombre de sección o curso
        if ($this->search) {
            $query->where('nombre', 'ilike', '%' . $this->search . '%');
        }

        // Filtro por Categoría
        if ($this->selectedCategory !== 'todos') {
            $query->whereHas('curso', function ($q) {
                $q->where('categoria_id', $this->selectedCategory);
            });
        }

        $secciones = $query->orderBy('nombre', 'asc')->paginate(12);
        $categorias = Categoria::select('id', 'nombre')->get();

        return view('livewire.public.secciones-curso', [
            'secciones' => $secciones,
            'categorias' => $categorias
        ])->layout('layouts.public');
    }
}