<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // $users = User::paginate(10);

        $query = User::query();
        $query->orderBy('nombres', 'asc')
            
            // ->where('es_docente', false)
            ->where(function ($q) {
                $q->whereNotNull('email')->orWhereNot('email', '');
            })->with('roles');
            $all_roles = Role::all(); // Todos los roles de Spatie

    
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where('nombres', 'ilike', "%{$search}%")
                ->orWhere('apellido_paterno', 'ilike', "%{$search}%")
                ->orWhere('apellido_materno', 'ilike', "%{$search}%")
                ->orWhere('email', 'ilike', "%{$search}%")
                ->orWhere('numero_documento', 'ilike', "%{$search}%")
                ->orWhere('role', 'ilike', "%{$search}%")
                ->orWhere('activo', 'ilike', "%{$search}%");

            // Lógica para la columna booleana 'activo'
            $termino = strtolower(trim($search));
            if ($termino === 'activo' || $termino === 'activos') {
                $query->orWhere('activo', true);
            } elseif ($termino === 'inactivo' || $termino === 'inactivos') {
                $query->orWhere('activo', false);
            }
        }

        $users = $query->paginate(10)->withQueryString();
        return view('portal.users', compact('users', 'all_roles'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
    public function store(Request $request)
    {
        try {
            $user = User::create([
                'nombres' => $request->createNombre,
                'apellido_paterno' => $request->createApPaterno,
                'apellido_materno' => $request->createApMaterno,
                'tipo_documento' => $request->createTipo,
                'numero_documento' => $request->createDocumento,
                'email' => $request->createEmail,
                'password' => Hash::make($request->createDocumento),
                'role' => $request->createRole,
                'activo' => $request->createEstado,
            ]);
            $user->assignRole($request->roles);
            // $user->assignRole('alumno'); // Ahora tiene ambos
            foreach ($user->getRoleNames() as $rol) {
                if ($rol == 'docente') {
                    $user->docente()->create([]);
                    $user->es_docente = true;
                    $user->save();
                }
            }
        } catch (QueryException $e) {
            if ($e->getCode() === '23505') {
                return redirect()
                    ->back()
                    ->with('error', 'Ya existe un usuario con este email o numero de documento.');
            }
        }
        return redirect()
            ->back()
            ->with('success', 'Usuario creado correctamente');
    }
    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->update([
            'nombres' => $request->editNombre,
            'apellido_paterno' => $request->editApPaterno,
            'apellido_materno' => $request->editApMaterno,
            'tipo_documento' => $request->editTipo,
            'numero_documento' => $request->editDocumento,
            'email' => $request->editEmail,
            'activo' => $request->editEstado
        ]);
        $user->syncRoles($request->roles ?? []);
        foreach ($user->getRoleNames() as $rol) {
                if ($rol == 'docente') {
                    $user->docente()->updateOrcreate([]);
                    $user->es_docente = true;
                    $user->save();
                }
            }
        return redirect()
            ->back()
            ->with('success', 'Usuario actualizado correctamente');
            
        // return redirect('admin/usuarios');
    }
    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();

            return redirect()
                ->back()
                ->with('success', 'Usuario eliminada correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23503') { // código de violación de FK en PostgreSQL
                return redirect()
                    ->back()
                    ->with('error', 'No se puede eliminar este usuario.');
            }

            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al eliminar el taller.');
        }
    }
}
