<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $cursoOptions = Curso::query()
            ->orderBy('nome')
            ->get();

        $filtros = [
            'cursos' => $this->normalizarSelecao($request->query('cursos'), $cursoOptions->pluck('id')->all()),
        ];

        $query = Curso::query()->latest();
        $this->aplicarFiltros($query, $filtros);

        $cursos = $query->get();

        return view('cursos.index', compact('cursos', 'cursoOptions', 'filtros'));
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

    private function aplicarFiltros($query, array $filtros): void
    {
        if (! empty($filtros['cursos'])) {
            $query->whereIn('id', $filtros['cursos']);
        }
    }

    private function normalizarSelecao(mixed $selecionados, array $opcoes): array
    {
        if (is_null($selecionados)) {
            return array_map('strval', $opcoes);
        }

        $selecionados = is_array($selecionados) ? $selecionados : [$selecionados];
        $selecionados = array_values(array_unique(array_map('strval', $selecionados)));

        return empty($selecionados) ? array_map('strval', $opcoes) : $selecionados;
    }
}