<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $filtros = [
            'cursos' => $request->input('cursos', []),
        ];

        $query = Curso::query();

        if (!empty($filtros['cursos'])) {
            $query->whereIn('id', $filtros['cursos']);
        }

        $cursos = $query->orderBy('nome')->get();
        $cursoOptions = Curso::orderBy('nome')->get();

        return view('cursos.index', compact('cursos', 'filtros', 'cursoOptions'));
    }

    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        Curso::create($dados);

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso criado com sucesso.');
    }

    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        $curso->update($dados);

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso atualizado com sucesso.');
    }

    public function destroy(Curso $curso)
    {
        if (Aula::query()
            ->where('curso_id', $curso->id)
            ->ativas()
            ->exists()) {
            return back()->with('popup_error', 'Não é possível excluir este curso porque existem aulas agendadas ou em andamento vinculadas a ele.');
        }

        $curso->delete();

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso removido com sucesso.');
    }
}