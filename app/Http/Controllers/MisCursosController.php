<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sesion;
use App\Models\Taller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MisCursosController extends Controller
{
    public function index()
    {

        $usuario = Auth::user();
        $secciones = Auth::user()->docente?->secciones()->with(['lugares','periodo:id,anio,ciclo','talleres.disciplina','talleres.categoria','horarios', 'matriculas.alumnos.user:id,nombres,apellido_paterno,apellido_materno,numero_documento,fecha_nacimiento', 'matriculas.alumnos.padre.user'])->get() ?? [];
    
        // $fechaHoy = today()->toDateString();
       
        return view('portal.mis-cursos', compact('secciones', 'usuario'));
    }

    
   
}
