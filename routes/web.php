<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\AulaController;
use App\Models\Aula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/readme', function () {
    return response()->file(base_path('README.md'), [
        'Content-Type' => 'text/markdown; charset=UTF-8',
    ]);
})->name('readme.view');

Route::get('/dashboard', function (Request $request) {
    $selectedDate = $request->query('data', now()->toDateString());

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selectedDate)) {
        $selectedDate = now()->toDateString();
    }

    Aula::atualizarStatusAutomatico();

    $aulasDoDia = Aula::with(['sala', 'curso', 'professor'])
        ->whereDate('data', $selectedDate)
        ->orderBy('horario_inicio')
        ->get();

    return view('dashboard', compact('aulasDoDia', 'selectedDate'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::resource('cursos', CursoController::class);
    Route::resource('professores', ProfessorController::class)->parameters(['professores' => 'professor']);
    Route::resource('salas', SalaController::class)->parameters(['salas' => 'sala']);
    Route::resource('aulas', AulaController::class)->parameters(['aulas' => 'aula']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
