<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filtros = [
            'professores' => $request->input('professores', []),
        ];

        $query = Professor::query();

        if (!empty($filtros['professores'])) {
            $query->whereIn('id', $filtros['professores']);
        }

        $professores = $query->orderBy('nome')->get();
        $professorOptions = Professor::orderBy('nome')->get();

        return view('professores.index', compact('professores', 'filtros', 'professorOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('professores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        Professor::create($dados);

        return redirect()
            ->route('professores.index')
            ->with('success', 'Professor cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Professor $professor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Professor $professor)
    {
        return view('professores.edit', compact('professor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Professor $professor)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        $professor->update($dados);

        return redirect()
            ->route('professores.index')
            ->with('success', 'Professor atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Professor $professor)
    {
        if (Aula::query()
            ->where('professor_id', $professor->id)
            ->ativas()
            ->exists()) {
            return back()->with('popup_error', 'Não é possível excluir este professor porque existem aulas agendadas ou em andamento vinculadas a ele.');
        }

        $professor->delete();

        return redirect()
            ->route('professores.index')
            ->with('success', 'Professor removido com sucesso.');
    }
}
