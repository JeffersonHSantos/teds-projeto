<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Sala;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filtros = [
            'salas' => $request->input('salas', []),
        ];

        $query = Sala::query();

        if (!empty($filtros['salas'])) {
            $query->whereIn('id', $filtros['salas']);
        }

        $salas = $query->orderBy('nome')->get();
        $salaOptions = Sala::orderBy('nome')->get();

        return view('salas.index', compact('salas', 'filtros', 'salaOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('salas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        Sala::create($dados);

        return redirect()
            ->route('salas.index')
            ->with('success', 'Sala cadastrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sala $sala)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sala $sala)
    {
        return view('salas.edit', compact('sala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sala $sala)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        $sala->update($dados);

        return redirect()
            ->route('salas.index')
            ->with('success', 'Sala atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sala $sala)
    {
        if (Aula::query()
            ->where('sala_id', $sala->id)
            ->ativas()
            ->exists()) {
            return back()->with('popup_error', 'Não é possível excluir esta sala porque existem aulas agendadas ou em andamento vinculadas a ela.');
        }

        $sala->delete();

        return redirect()
            ->route('salas.index')
            ->with('success', 'Sala removida com sucesso.');
    }
}
