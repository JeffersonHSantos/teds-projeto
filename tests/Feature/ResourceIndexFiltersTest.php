<?php

namespace Tests\Feature;

use App\Models\Curso;
use App\Models\Professor;
use App\Models\Sala;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourceIndexFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_professores_index_filtra_por_professor(): void
    {
        $user = User::factory()->create();
        $professor1 = Professor::create(['nome' => 'Professor 1']);
        $professor2 = Professor::create(['nome' => 'Professor 2']);

        $response = $this->actingAs($user)->get(route('professores.index', ['professores' => [$professor1->id]]));

        $response->assertOk();
        $response->assertViewHas('professores', function ($professores) use ($professor1) {
            return $professores->count() === 1 && (int) $professores->first()->id === $professor1->id;
        });
        $response->assertViewHas('filtros', function ($filtros) use ($professor1) {
            return $filtros['professores'] === [(string) $professor1->id];
        });
    }

    public function test_salas_index_filtra_por_sala(): void
    {
        $user = User::factory()->create();
        $sala1 = Sala::create(['nome' => 'Sala 1']);
        $sala2 = Sala::create(['nome' => 'Sala 2']);

        $response = $this->actingAs($user)->get(route('salas.index', ['salas' => [$sala1->id]]));

        $response->assertOk();
        $response->assertViewHas('salas', function ($salas) use ($sala1) {
            return $salas->count() === 1 && (int) $salas->first()->id === $sala1->id;
        });
        $response->assertViewHas('filtros', function ($filtros) use ($sala1) {
            return $filtros['salas'] === [(string) $sala1->id];
        });
    }

    public function test_cursos_index_filtra_por_curso(): void
    {
        $user = User::factory()->create();
        $curso1 = Curso::create(['nome' => 'Curso 1']);
        $curso2 = Curso::create(['nome' => 'Curso 2']);

        $response = $this->actingAs($user)->get(route('cursos.index', ['cursos' => [$curso1->id]]));

        $response->assertOk();
        $response->assertViewHas('cursos', function ($cursos) use ($curso1) {
            return $cursos->count() === 1 && (int) $cursos->first()->id === $curso1->id;
        });
        $response->assertViewHas('filtros', function ($filtros) use ($curso1) {
            return $filtros['cursos'] === [(string) $curso1->id];
        });
    }
}
