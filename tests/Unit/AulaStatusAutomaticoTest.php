<?php

namespace Tests\Unit;

use App\Models\Aula;
use App\Models\Curso;
use App\Models\Professor;
use App\Models\Sala;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AulaStatusAutomaticoTest extends TestCase
{
    use RefreshDatabase;

    public function test_aplicacao_usa_o_timezone_local_por_padrao(): void
    {
        $this->assertSame('America/Sao_Paulo', config('app.timezone'));
    }

    public function test_atualiza_status_da_aula_conforme_o_horario_atual(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 5, 27, 10, 0, 0));

        $sala = Sala::create(['nome' => 'Sala 1']);
        $curso = Curso::create(['nome' => 'Curso 1']);
        $professor = Professor::create(['nome' => 'Professor 1']);

        $aulaAgendada = Aula::create([
            'sala_id' => $sala->id,
            'curso_id' => $curso->id,
            'professor_id' => $professor->id,
            'materia' => 'Matematica',
            'data' => '2026-05-27',
            'horario' => '11:00 - 12:00',
            'horario_inicio' => '11:00:00',
            'horario_termino' => '12:00:00',
            'status' => Aula::STATUS_AGENDADA,
        ]);

        $aulaEmAndamento = Aula::create([
            'sala_id' => $sala->id,
            'curso_id' => $curso->id,
            'professor_id' => $professor->id,
            'materia' => 'Fisica',
            'data' => '2026-05-27',
            'horario' => '09:00 - 11:00',
            'horario_inicio' => '09:00:00',
            'horario_termino' => '11:00:00',
            'status' => Aula::STATUS_AGENDADA,
        ]);

        $aulaRealizada = Aula::create([
            'sala_id' => $sala->id,
            'curso_id' => $curso->id,
            'professor_id' => $professor->id,
            'materia' => 'Historia',
            'data' => '2026-05-27',
            'horario' => '08:00 - 09:00',
            'horario_inicio' => '08:00:00',
            'horario_termino' => '09:00:00',
            'status' => Aula::STATUS_EM_ANDAMENTO,
        ]);

        $aulaFuturaComStatusIncorreto = Aula::create([
            'sala_id' => $sala->id,
            'curso_id' => $curso->id,
            'professor_id' => $professor->id,
            'materia' => 'Geografia',
            'data' => '2026-05-27',
            'horario' => '11:30 - 12:30',
            'horario_inicio' => '11:30:00',
            'horario_termino' => '12:30:00',
            'status' => Aula::STATUS_REALIZADA,
        ]);

        $aulaCancelada = Aula::create([
            'sala_id' => $sala->id,
            'curso_id' => $curso->id,
            'professor_id' => $professor->id,
            'materia' => 'Quimica',
            'data' => '2026-05-27',
            'horario' => '13:00 - 14:00',
            'horario_inicio' => '13:00:00',
            'horario_termino' => '14:00:00',
            'status' => Aula::STATUS_CANCELADA,
        ]);

        Aula::atualizarStatusAutomatico();

        $this->assertSame(Aula::STATUS_AGENDADA, $aulaAgendada->fresh()->status);
        $this->assertSame(Aula::STATUS_EM_ANDAMENTO, $aulaEmAndamento->fresh()->status);
        $this->assertSame(Aula::STATUS_REALIZADA, $aulaRealizada->fresh()->status);
        $this->assertSame(Aula::STATUS_AGENDADA, $aulaFuturaComStatusIncorreto->fresh()->status);
        $this->assertSame(Aula::STATUS_CANCELADA, $aulaCancelada->fresh()->status);
        $this->assertSame('Em andamento', $aulaEmAndamento->fresh()->status_label);

        Carbon::setTestNow();
    }
}
