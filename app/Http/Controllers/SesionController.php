<?php

namespace App\Http\Controllers;

use App\Models\Sesion;
use Illuminate\Http\Request;

class SesionController extends Controller
{
    public function index(){

    }
    public function store(Request $request){
        $disciplina = Sesion::create([
            'modulo_id' => $request->input('modulo_id'),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            // 'categoria_id' => $request->categoria_id,
            // 'fecha' => $request->fecha,
            // 'link_reunion' => $request->link_reunion,
            'es_evaluacion' => $request->es_evaluacion,
            // 'estado' => $request->activo
        
            // 'cod_serv' => $request->createCodServ
        ]);
        return redirect()->back();
    }
}
