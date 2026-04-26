<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    protected $fillable = [
        'sala_id',
        'curso_id',
        'professor_id',
        'materia',
        'data',
        'horario'
    ];

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}
