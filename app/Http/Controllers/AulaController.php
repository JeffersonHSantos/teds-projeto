<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Sala;
use App\Models\Curso;
use App\Models\Professor;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aulas = Aula::with(['sala', 'curso', 'professor'])->get();
        return view('aulas.index', compact('aulas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $salas = Sala::all();
        $cursos = Curso::all();
        $professores = Professor::all();

        return view('aulas.create', compact('salas', 'cursos', 'professores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'sala_id' => 'required',
            'curso_id' => 'required',
            'professor_id' => 'required',
            'materia' => 'required',
            'data' => 'required|date',
            'horario' => 'required',
        ]);

        Aula::create($dados);

        return redirect()->route('aulas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aula $aula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aula $aula)
    {
        $salas = Sala::all();
        $cursos = Curso::all();
        $professores = Professor::all();

        return view('aulas.create', compact('aula', 'salas', 'cursos', 'professores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aula $aula)
    {
        $dados = $request->validate([
            'sala_id' => 'required',
            'curso_id' => 'required',
            'professor_id' => 'required',
            'materia' => 'required',
            'data' => 'required|date',
            'horario' => 'required',
        ]);

        $aula->update($dados);

        return redirect()->route('aulas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aula $aula)
    {
        $aula->delete();

    return redirect()->route('aulas.index');
    }
}
