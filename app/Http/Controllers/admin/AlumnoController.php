<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index(Request $request){
        $query = User::query();
        $query->has('alumno')->with(['alumno.matricula.seccion.curso','alumno.matricula.seccion.curso.categoria'])->orderBy('nombres','asc');
        // dd($users->toArray());
        if($request->filled('search')){
            $search = $request->search;
            $query->where('nombres','ilike', "%{$search}%")
            ->orWhere('apellido_paterno','ilike', "%{$search}%")///error matricula no leer propiedad null
            ->orWhere('apellido_materno','ilike', "%{$search}%");///error
        }
        $users = $query->paginate(5)->withQueryString();
        return view('portal.alumnos', compact('users'));
    }
    public function update(Request $request,$id){
        $user = User::find($id);
        $user->update([
            'nombres' => $request->editNombre,
            'apellido_paterno' => $request->editApPaterno,
            'apellido_materno' => $request->editApMaterno,
            'tipo_documento' => $request->editTipo,
            'numero_documento' => $request->editDocumento
        ]);
        return redirect()
                ->back()
                ->with('success', 'Alumno actualizado correctamente.');
    }
    // public function destroy($id){
    //     $docente = User::find($id);
    //     $docente->delete();
    //     return redirect('admin/alumnos');
        
    // }
}
