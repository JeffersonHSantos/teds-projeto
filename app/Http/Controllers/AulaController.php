<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Sala;
use App\Models\Curso;
use App\Models\Professor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Aula::atualizarStatusAutomatico();

        $salas = Sala::orderBy('nome')->get();
        $cursos = Curso::orderBy('nome')->get();
        $professores = Professor::orderBy('nome')->get();
        $materias = Aula::query()
            ->whereNotNull('materia')
            ->where('materia', '!=', '')
            ->distinct()
            ->orderBy('materia')
            ->pluck('materia')
            ->values();
        $statusOptions = Aula::statusOptions();

        $filtros = [
            'salas' => $this->normalizarSelecao($request->query('salas'), $salas->pluck('id')->all()),
            'cursos' => $this->normalizarSelecao($request->query('cursos'), $cursos->pluck('id')->all()),
            'professores' => $this->normalizarSelecao($request->query('professores'), $professores->pluck('id')->all()),
            'materias' => $this->normalizarSelecao($request->query('materias'), $materias->all()),
            'status' => $this->normalizarSelecao($request->query('status'), array_keys($statusOptions)),
            'data_de' => $this->normalizarData($request->query('data_de')),
            'data_ate' => $this->normalizarData($request->query('data_ate')),
            'horario_de' => $this->normalizarHorario($request->query('horario_de')),
            'horario_ate' => $this->normalizarHorario($request->query('horario_ate')),
        ];

        $query = Aula::with(['sala', 'curso', 'professor'])
            ->orderBy('data')
            ->orderBy('horario_inicio');

        $this->aplicarFiltros($query, $filtros);

        $aulas = $query->get();

        return view('aulas.index', compact('aulas', 'salas', 'cursos', 'professores', 'materias', 'statusOptions', 'filtros'));
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
            'horario_inicio' => 'required|date_format:H:i',
            'horario_termino' => 'required|date_format:H:i|after:horario_inicio',
        ]);

        if ($mensagem = $this->validarConflitosHorario($dados)) {
            return back()->withInput()->with('popup_error', $mensagem);
        }

        $dados['horario_inicio'] = Carbon::createFromFormat('H:i', $dados['horario_inicio'])->format('H:i:s');
        $dados['horario_termino'] = Carbon::createFromFormat('H:i', $dados['horario_termino'])->format('H:i:s');
        $dados['horario'] = substr($dados['horario_inicio'], 0, 5) . ' - ' . substr($dados['horario_termino'], 0, 5);

        Aula::create($dados);

        return redirect()
            ->route('aulas.index')
            ->with('success', 'Aula cadastrada com sucesso.');
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
            'horario_inicio' => 'required|date_format:H:i',
            'horario_termino' => 'required|date_format:H:i|after:horario_inicio',
        ]);

        if ($mensagem = $this->validarConflitosHorario($dados, $aula->id)) {
            return back()->withInput()->with('popup_error', $mensagem);
        }

        $dados['horario_inicio'] = Carbon::createFromFormat('H:i', $dados['horario_inicio'])->format('H:i:s');
        $dados['horario_termino'] = Carbon::createFromFormat('H:i', $dados['horario_termino'])->format('H:i:s');
        $dados['horario'] = substr($dados['horario_inicio'], 0, 5) . ' - ' . substr($dados['horario_termino'], 0, 5);

        $aula->update($dados);

        return redirect()
            ->route('aulas.index')
            ->with('success', 'Aula atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aula $aula)
    {
        Aula::destroy($aula->id);

        return redirect()
            ->route('aulas.index')
            ->with('success', 'Aula removida com sucesso.');
    }

    private function validarConflitosHorario(array $dados, ?int $aulaId = null): ?string
    {
        $inicio = Carbon::createFromFormat('H:i', $dados['horario_inicio'])->format('H:i:s');
        $termino = Carbon::createFromFormat('H:i', $dados['horario_termino'])->format('H:i:s');

        $baseQuery = Aula::query()
            ->where('data', $dados['data'])
            ->when($aulaId, fn ($query) => $query->where('id', '!=', $aulaId))
            ->where('horario_inicio', '<', $termino)
            ->where('horario_termino', '>', $inicio);

        if ((clone $baseQuery)->where('professor_id', $dados['professor_id'])->exists()) {
            return 'Este professor já tem aula cadastrada nesta data e hora.';
        }

        if ((clone $baseQuery)->where('sala_id', $dados['sala_id'])->exists()) {
            return 'Esta sala já possui aula cadastrada nesta data e hora.';
        }

        return null;
    }

    private function aplicarFiltros($query, array $filtros): void
    {
        $query->whereIn('sala_id', $filtros['salas']);
        $query->whereIn('curso_id', $filtros['cursos']);
        $query->whereIn('professor_id', $filtros['professores']);
        $query->whereIn('materia', $filtros['materias']);
        $query->whereIn('status', $filtros['status']);

        if ($filtros['data_de']) {
            $query->whereDate('data', '>=', $filtros['data_de']);
        }

        if ($filtros['data_ate']) {
            $query->whereDate('data', '<=', $filtros['data_ate']);
        }

        if ($filtros['horario_de']) {
            $query->where('horario_termino', '>', $filtros['horario_de']);
        }

        if ($filtros['horario_ate']) {
            $query->where('horario_inicio', '<', $filtros['horario_ate']);
        }
    }

    private function normalizarSelecao(mixed $selecionados, array $opcoes): array
    {
        $selecionados = is_array($selecionados) ? $selecionados : [];

        $selecionados = array_values(array_intersect(
            array_map(static fn ($valor) => (string) $valor, $selecionados),
            array_map(static fn ($valor) => (string) $valor, $opcoes),
        ));

        if ($selecionados === []) {
            return array_map(static fn ($valor) => (string) $valor, $opcoes);
        }

        return $selecionados;
    }

    private function normalizarData(mixed $valor): ?string
    {
        if (! is_string($valor) || ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $valor)) {
            return null;
        }

        return $valor;
    }

    private function normalizarHorario(mixed $valor): ?string
    {
        if (! is_string($valor) || ! preg_match('/^\d{2}:\d{2}$/', $valor)) {
            return null;
        }

        return $valor . ':00';
    }
}
