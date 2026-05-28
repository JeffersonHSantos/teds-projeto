<?php

namespace Tests\Feature;

use App\Models\Aula;
use App\Models\Curso;
use App\Models\Professor;
use App\Models\Sala;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_exibe_status_e_nao_mostra_botao_de_saida_em_tela_cheia(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 5, 27, 10, 30, 0));

        $user = User::factory()->create();
        $sala = Sala::create(['nome' => 'Sala 1']);
        $curso = Curso::create(['nome' => 'Curso 1']);
        $professor = Professor::create(['nome' => 'Professor 1']);

        Aula::create([
            'sala_id' => $sala->id,
            'curso_id' => $curso->id,
            'professor_id' => $professor->id,
            'materia' => 'Matematica',
            'data' => '2026-05-27',
            'horario' => '10:00 - 11:00',
            'horario_inicio' => '10:00:00',
            'horario_termino' => '11:00:00',
            'status' => Aula::STATUS_AGENDADA,
        ]);

        $response = $this->actingAs($user)->get('/dashboard?data=2026-05-27');

        $response->assertOk();
        $response->assertSee('Status');
        $response->assertSee('Em andamento');
        $response->assertDontSee('Sair da Tela Cheia');

        $this->assertSame(Aula::STATUS_EM_ANDAMENTO, Aula::first()->fresh()->status);

        Carbon::setTestNow();
    }
}