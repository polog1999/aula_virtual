<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Taller;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    public function index(){
        $disciplinas = Curso::select('id','nombre','imagen','activo')
        ->where('activo',true)
        ->withCount('secciones as talleres_count')
    //     ->addSelect(['edad_minima' => Taller::selectRaw('min(categorias.edad_min)')
    //     ->join('categorias', 'talleres.categoria_id', '=', 'categorias.id') // Ajusta los nombres de tablas/llaves según tu DB
    //     ->whereColumn('talleres.disciplina_id', 'disciplinas_deportivas.id')
    // ])
    ->whereHas('secciones', function($q){
        $q->where('activo',true);
    })
        ->whereHas('secciones')
        ->orderBy('nombre','asc')
        ->get();
        return view('disciplinas', compact('disciplinas'));
    }
}
