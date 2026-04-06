<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Inscripcion;
use App\Models\Matricula;
use App\Models\User;
use App\Models\Seccion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;

class FormularioInscripcion extends Component
{
    public $seccion_id;

    // Campos del Formulario con Validación Livewire 3
    #[Validate('required|string|max:100')]
    public $nombres = '';
    
    #[Validate('required|string|max:100')]
    public $apellidos = '';

    #[Validate('required|digits:8')]
    public $dni = '';

    #[Validate('required|string|max:50')]
    public $colegiatura = '';

    #[Validate('required|email|max:255')]
    public $email = '';

    #[Validate('required')]
    public $profesion = '';

    #[Validate('required')]
    public $nivel = '';

    #[Validate('required')]
    public $region_vivienda = '';

    #[Validate('required')]
    public $diris_diresa = '';

    #[Validate('required')]
    public $establecimiento = '';

    // Listas dinámicas
    public $diris_options = [];

    public function mount($seccion_id)
    {
        $this->seccion_id = $seccion_id;
    }

    // Lógica de Dropdown Dependiente (Region -> DIRIS/DIRESA)
    public function updatedRegionVivienda($value)
    {
        $this->diris_diresa = ''; // Resetear selección anterior
        
        if ($value === 'LIMA' || $value === 'CALLAO') {
            $this->diris_options = [
                "DIRIS Lima Centro",
                "DIRIS Lima Este",
                "DIRIS Lima Sur",
                "DIRIS Lima Norte"
            ];
        } elseif ($value !== "") {
            $this->diris_options = ["DIRESA " . mb_convert_case($value, MB_CASE_TITLE, "UTF-8")];
        } else {
            $this->diris_options = [];
        }
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // 1. Crear Inscripción
            $inscripcion = new Inscripcion();
            $inscripcion->seccion_id = $this->seccion_id;
            $inscripcion->nombres = mb_strtoupper($this->nombres);
            $inscripcion->apellidos = mb_strtoupper($this->apellidos);
            $inscripcion->dni = $this->dni;
            $inscripcion->colegiatura = $this->colegiatura;
            $inscripcion->email = strtolower($this->email);
            $inscripcion->profesion = $this->profesion;
            $inscripcion->nivel_establecimiento = $this->nivel;
            $inscripcion->region = $this->region_vivienda;
            $inscripcion->diris_diresa = $this->diris_diresa;
            $inscripcion->establecimiento = $this->establecimiento;
            $inscripcion->save();

            // 2. Activar Matrícula (Lógica del controlador)
            $this->activarMatricula($inscripcion);

            DB::commit();

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => '¡Inscripción Exitosa!',
                'text' => 'Tus datos han sido procesados correctamente.'
            ]);

            return redirect()->route('index');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error Inscripcion: " . $e->getMessage());
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo completar el registro. Inténtelo más tarde.'
            ]);
        }
    }

    private function activarMatricula($inscripcion)
    {
        $alumno = User::firstOrCreate(['numero_documento' => $inscripcion->dni], [
            'nombres' => $inscripcion->nombres,
            'apellido_paterno' => $inscripcion->apellidos,
            'apellido_materno' => '',
            'telefono' => '',
            'direccion' => '',
            'email' => $inscripcion->email,
            'password' => Hash::make($inscripcion->dni),
            'role' => 'ALUMNO',
            'tipo_documento' => 'DNI'
        ]);
        $alumno->assignRole('alumno');

        $alumno->alumno()->firstOrCreate([]);

        Matricula::firstOrCreate(
            [
                'alumno_id' => $alumno->id,
                'seccion_id' => $inscripcion->seccion_id,
            ],
            [
                'orden_id' => $inscripcion->id,
                'estado' => 'ACTIVA',
            ]
        );
    }

    public function render()
    {
        return view('livewire.public.formulario-inscripcion')->layout('layouts.public');
    }
}