<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {

        
        $user = $request->user();
        $user->getRoleNames()->first();
            return redirect()->route('seleccionar.rol');
        // switch ($user->getRoleNames()->first()) {
        //     case 'admin':
        //         return redirect()->route('portal.dashboard');

        //     case 'docente':
        //         return redirect()->route('portal.misCursos');

        //     // case 'alumno':
        //     //     return redirect('/alumno');

        //     case 'encargado_sede':
        //         return redirect()->route('portal.asistencias.index');

        //     // case 'PADRE':
        //     //     return redirect('/apoderado');
        // }
    }
}
