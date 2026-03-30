<?php

namespace App\Livewire\Asistencia;

use Livewire\Component;
use App\Models\Periodo;

class CentralReportes extends Component
{
    public $periodo_id;

    public function descargarExcel()
    {
        $this->validate(['periodo_id' => 'required']);
        // Retornamos el redirect a la ruta del controlador tradicional para la descarga
        return redirect()->route('encargadoSede.reportes.asistencias', ['periodo_id' => $this->periodo_id]);
    }

    public function render()
    {
        return view('livewire.asistencia.central-reportes', [
            'periodos' => Periodo::orderBy('anio', 'desc')->get()
        ]);
    }
}