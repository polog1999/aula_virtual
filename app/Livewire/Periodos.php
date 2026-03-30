<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Periodo;
use Livewire\Attributes\On;

class Periodos extends Component
{
    use WithPagination;

    // Propiedades para el formulario
    public $periodoId, $anio, $ciclo, $fecha_inicio, $fecha_fin;
    public $search = '';
    public $isModalOpen = false;

    // Resetear paginación cuando se busca
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        if ($id) {
            $p = Periodo::find($id);
            $this->periodoId = $id;
            $this->anio = $p->anio;
            $this->ciclo = $p->ciclo;
            $this->fecha_inicio = $p->fecha_inicio->format('Y-m-d');
            $this->fecha_fin = $p->fecha_fin->format('Y-m-d');
        } else {
            $this->reset(['periodoId', 'anio', 'ciclo', 'fecha_inicio', 'fecha_fin']);
        }
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'anio' => 'required|numeric',
            'ciclo' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        Periodo::updateOrCreate(['id' => $this->periodoId], [
            'anio' => $this->anio,
            'ciclo' => $this->ciclo,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ]);

        $this->isModalOpen = false;
        // ESTO ACTIVA EL SWEETALERT SIN RECARGAR
        // Sintaxis recomendada para Livewire 3
        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => '¡Buen trabajo!',
            'text'  => 'El periodo se guardó correctamente.',
        ]);
        // session()->flash('message', $this->periodoId ? 'Actualizado' : 'Creado');
    }
       #[On('doDelete')] 
    public function delete($id)
    {
        // Aquí puedes poner tu lógica de "No permitir eliminar si tiene alumnos"
        $periodo = Periodo::find($id);
        // if ($periodo->matriculas()->count() > 0) {
            // $this->dispatch('show-alert', ['msg' => 'No se puede eliminar, tiene alumnos.']);
            // return;
        // }
        $periodo->delete();
        
        $this->dispatch('swal', icon: 'success', title: 'Eliminado', text: 'Registro borrado.');
        

    }
    

    public function render()
    {
        return view('livewire.periodos', [
            'periodos' => Periodo::where('ciclo', 'ilike', "%{$this->search}%")
                ->orderBy('id', 'desc')
                ->paginate(1)
        ]);
    }
}
