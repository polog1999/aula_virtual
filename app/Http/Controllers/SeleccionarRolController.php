<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeleccionarRolController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $roles = $user->getRoleNames();

        // Si solo tiene un rol, no lo hagas elegir, mándalo directo
        if ($roles->count() === 1) {
            session(['active_role' => $roles->first()]);
            return $this->redirectUser($roles->first());
        }

        return view('auth.seleccionar-rol', compact('roles'));
    }

    public function select(Request $request)
    {
      
        // $role = $request->role;
        $role = $request->query('role');

        // Seguridad: Verificar que el usuario realmente tenga ese rol
        if (!auth()->user()->hasRole($role)) {
            abort(403);
        }

        // Guardar el rol activo en la sesión
        session(['active_role' => $role]);

        return $this->redirectUser($role);
    }

    private function redirectUser($role)
    {
        return match ($role) {
            'admin' => redirect()->route('portal.periodos.index'),
            'encargado_sede' => redirect()->route('portal.asistencias.index'),
            'docente' => redirect()->route('portal.misCursos'),
            default => redirect('/portal'),
        };
    }
}
