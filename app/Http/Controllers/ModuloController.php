<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use Illuminate\Http\Request;

class ModuloController extends Controller
{
    public function index(){

    }
    public function store(Request $request){
        $disciplina = Modulo::create([
            'curso_id' => $request->input('curso_id'),
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            // 'categoria_id' => $request->categoria_id,
            'orden' => $request->orden,
            'prerequisito_id' => $request->selectModule,
            'disponible_desde' => $request->disponible_desde,
            'activo' => $request->activo
        
            // 'cod_serv' => $request->createCodServ
        ]);
        return redirect()->back();
    }
}
