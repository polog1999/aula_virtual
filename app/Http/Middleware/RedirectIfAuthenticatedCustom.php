<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {
            
            // $role = Auth::user()->role->value;
            $user = Auth::user();
            // return redirect('/portal');
            if ($user->hasRole('admin')) return redirect()->route('portal.periodos.index');
            // if ($user->hasRole('docente')) return redirect('/docente');
            // if ($user->hasRole('alumno')) return redirect('/alumno');
            if ($user->hasRole('encargado_sede')) return redirect()->route('portal.asistencias.index');
            if ($user->hasRole('docente')) return redirect()->route('portal.misCursos');
        }

        return $next($request);
    }
}
