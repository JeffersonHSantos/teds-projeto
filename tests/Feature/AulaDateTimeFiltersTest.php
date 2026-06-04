<?php

namespace Tests\Feature;

use App\Models\Aula;
use App\Models\Curso;
use App\Models\Professor;
use App\Models\Sala;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AulaDateTimeFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_filtra_por_data_e_horario(): void
    {
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

        Aula::create([
            'sala_id' => $sala->id,
            'curso_id' => $curso->id,
            'professor_id' => $professor->id,
            'materia' => 'Fisica',
            'data' => '2026-05-28',
            'horario' => '12:00 - 13:00',
            'horario_inicio' => '12:00:00',
            'horario_termino' => '13:00:00',
            'status' => Aula::STATUS_AGENDADA,
        ]);

        $response = $this->actingAs($user)->get(route('aulas.index', [
            'data_de' => '2026-05-27',
            'data_ate' => '2026-05-27',
            'horario_de' => '09:30',
            'horario_ate' => '10:30',
        ]));

        $response->assertOk();
        $response->assertViewHas('aulas', function ($aulas) {
            return $aulas->count() === 1 && $aulas->first()->materia === 'Matematica';
        });
    }
}
