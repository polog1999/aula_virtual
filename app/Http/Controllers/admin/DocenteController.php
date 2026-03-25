<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index(Request $request){
        $query = User::query();

        $query->where('es_docente',true)->with(['docente','docente.secciones','docente.secciones.curso', 'docente.secciones.curso.categoria'])->orderBy('updated_at','desc')->get();
        // dd($users->toArray());
        if($request->filled('search')){
            $search = $request->search;
            $query->where('nombres', 'ilike',"%{$search}%")
            ->orWhereHas('docente.secciones.curso', function ($q) use($search){
                $q->where('nombre','ilike', "%{$search}%");
            })
            ->orWhereHas('docente.secciones', function ($q) use($search){
                $q->where('nombre','ilike', "%{$search}%");
            });
        }
        $users = $query->paginate(5)->withQueryString();
        return view('portal.docentes', compact('users'));
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
            ->with('success', 'Docente actualizado correctamente');
    }
    // public function destroy($id){
    //     $docente = User::find($id);
    //     $docente->delete();
    //     return redirect('admin/docentes');
        
    // }
}
