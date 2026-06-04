<?php

namespace Tests\Feature;

use App\Models\Aula;
use App\Models\Curso;
use App\Models\Professor;
use App\Models\Sala;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AulaFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_filtra_por_sala_e_mantem_os_demais_filtros_como_todos(): void
    {
        $user = User::factory()->create();
        $sala1 = Sala::create(['nome' => 'Sala 1']);
        $sala2 = Sala::create(['nome' => 'Sala 2']);
        $curso = Curso::create(['nome' => 'Curso 1']);
        $professor = Professor::create(['nome' => 'Professor 1']);

        Aula::create([
            'sala_id' => $sala1->id,
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
            'sala_id' => $sala2->id,
            'curso_id' => $curso->id,
            'professor_id' => $professor->id,
            'materia' => 'Fisica',
            'data' => '2026-05-27',
            'horario' => '11:00 - 12:00',
            'horario_inicio' => '11:00:00',
            'horario_termino' => '12:00:00',
            'status' => Aula::STATUS_AGENDADA,
        ]);

        $response = $this->actingAs($user)->get(route('aulas.index', ['salas' => [$sala1->id]]));

        $response->assertOk();
        $response->assertViewHas('aulas', function ($aulas) use ($sala1) {
            return $aulas->count() === 1 && (int) $aulas->first()->sala_id === $sala1->id;
        });
        $response->assertViewHas('filtros', function ($filtros) use ($sala1) {
            return $filtros['salas'] === [(string) $sala1->id];
        });
    }
}
