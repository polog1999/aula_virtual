<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion; // Recuerda crear el modelo
use App\Models\Matricula;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class InscripcionController extends Controller
{
    /**
     * Guarda los datos del formulario e inicia el proceso de pago.
     */
    public function store(Request $request)
    {
        // 1. Validación de los datos del formulario HTML
        $validated = $request->validate([
            'nombres'         => 'required|string|max:255',
            'apellidos'         => 'required|string|max:255',
            'dni'             => 'required|numeric|digits:8',
            'colegiatura'     => 'required|string',
            'email'           => 'required|email',
            'profesion'       => 'required|string',
            'nivel'           => 'required|string',
            'region_vivienda' => 'required|string',
            'diris_diresa'    => 'required|string',
            'establecimiento' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // 2. Crear el registro en la base de datos
            // Generamos un número de compra único para Niubiz
            $purchaseNumber = time() . $request->dni;

            $inscripcion = new Inscripcion();
            $inscripcion->seccion_id=$request->seccion_id;
            $inscripcion->nombres = $validated['nombres'];
            $inscripcion->apellidos = $validated['apellidos'];
            $inscripcion->dni = $validated['dni'];
            $inscripcion->colegiatura = $validated['colegiatura'];
            $inscripcion->email = $validated['email'];
            $inscripcion->profesion = $validated['profesion'];
            $inscripcion->nivel_establecimiento = $validated['nivel'];
            $inscripcion->region = $validated['region_vivienda'];
            $inscripcion->diris_diresa = $validated['diris_diresa'];
            $inscripcion->establecimiento = $validated['establecimiento'];

            // $inscripcion->purchase_number = $purchaseNumber;
            // $inscripcion->amount = 50.00; // O el monto que definas para el curso
            // $inscripcion->status = 'PENDING';
            $inscripcion->save();
            $this->activarMatricula($inscripcion->id);
            DB::commit();

            // 3. Retornar a la vista con la data para el botón de Niubiz
            // Aquí enviarías el purchaseNumber y el monto al componente Alpine.js
            return redirect()->route('index')->with('success', '¡Registro exitoso! Los datos han sido enviados al sistema académico del INSN Breña.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al registrar inscripción: " . $e->getMessage());
            return redirect()->route('index')->with('error', 'No se pudo procesar el registro');
        }
    }
    private function activarMatricula($inscripcionId)
    {
        // $usuarioResponsable = null;
        // $perfilAlumno = null;

        $inscripcion = Inscripcion::findOrFail($inscripcionId);
      


            $alumno= User::firstOrCreate(['numero_documento' => $inscripcion->dni], [
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


            $alumno->alumno()->firstOrCreate([]);

  
        // Crear la Matrícula
        $matricula = Matricula::firstOrCreate(
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


    public function form($seccion_id)
    {
        return view('inscripciones',compact('seccion_id'));
    }
}
