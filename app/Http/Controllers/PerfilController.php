<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
   public function index()
    {
        $user = Auth::user();
        return view('portal.perfil');
    }
    public function updatePassword(Request $request)
    {
        // 1. Validación de los campos
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Debe ingresar su contraseña actual.',
            'new_password.required' => 'Debe ingresar una nueva contraseña.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        $user = Auth::user();

        // 2. Verificar que la contraseña actual sea correcta en la BD
        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->with(['error' => 'La contraseña actual ingresada es incorrecta.'])
                ->withInput(); // Mantiene los datos en el form para no reescribir todo
        }

        // 3. Verificar que la nueva contraseña no sea igual a la actual (Opcional, buena práctica)
        if (Hash::check($request->new_password, $user->password)) {
            return back()
                ->with(['error' => 'La nueva contraseña no puede ser igual a la anterior.'])
                ->withInput();
        }

       

        // 4. Actualizar la contraseña
        $user->forceFill([
            'password' => $request->new_password,
        ])->save();

        // 5. Retornar con mensaje de éxito
        return back()->with('success', '¡Contraseña actualizada correctamente!');
    }
}
