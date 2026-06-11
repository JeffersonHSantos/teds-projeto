<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    // Model: representa uma aula e contém regras de negócio relacionadas ao agendamento.
    public const STATUS_AGENDADA = 'AGENDADA';
    public const STATUS_EM_ANDAMENTO = 'EM_ANDAMENTO';
    public const STATUS_REALIZADA = 'REALIZADA';
    public const STATUS_CANCELADA = 'CANCELADA';

    // Campos permitidos para preenchimento em massa (mass assignment).
    protected $fillable = [
        'sala_id',
        'curso_id',
        'professor_id',
        'materia',
        'data',
        'horario',
        'horario_inicio',
        'horario_termino',
        'status',
    ];

    // Atributos virtuais adicionados ao modelo ao serializar ou acessar.
    protected $appends = [
        'horario_formatado',
        'status_label',
    ];

    public static function statusOptions(): array
    {
        return [
            self::STATUS_AGENDADA => 'Agendada',
            self::STATUS_EM_ANDAMENTO => 'Em andamento',
            self::STATUS_REALIZADA => 'Realizada',
            self::STATUS_CANCELADA => 'Cancelada',
        ];
    }

    public static function statusesAtivas(): array
    {
        return [
            self::STATUS_AGENDADA,
            self::STATUS_EM_ANDAMENTO,
        ];
    }

    // Atualiza os status das aulas com base na data e horário atuais.
    public static function atualizarStatusAutomatico(): void
    {
        $agora = Carbon::now();

        self::query()
            ->where(function (Builder $query): void {
                $query->whereNull('status')
                    ->orWhere('status', '!=', self::STATUS_CANCELADA);
            })
            ->orderBy('data')
            ->orderBy('horario_inicio')
            ->chunkById(100, function ($aulas) use ($agora): void {
                /** @var self $aula */
                foreach ($aulas as $aula) {
                    $statusAtualizado = $aula->statusAtual($agora);

                    if ($statusAtualizado !== $aula->status) {
                        $aula->forceFill(['status' => $statusAtualizado])->save();
                    }
                }
            });
    }

    // Determina o status atual de uma aula sem salvar nada.
    public function statusAtual(?Carbon $momento = null): string
    {
        $momento ??= Carbon::now();

        if ($this->status === self::STATUS_CANCELADA) {
            return self::STATUS_CANCELADA;
        }

        if (empty($this->data) || empty($this->horario_inicio) || empty($this->horario_termino)) {
            return $this->status ?? self::STATUS_AGENDADA;
        }

        $inicio = Carbon::createFromFormat('Y-m-d H:i:s', $this->data . ' ' . $this->horario_inicio);
        $termino = Carbon::createFromFormat('Y-m-d H:i:s', $this->data . ' ' . $this->horario_termino);

        if ($momento->greaterThanOrEqualTo($termino)) {
            return self::STATUS_REALIZADA;
        }

        if ($momento->greaterThanOrEqualTo($inicio)) {
            return self::STATUS_EM_ANDAMENTO;
        }

        return self::STATUS_AGENDADA;
    }

    // Escopo local para listar apenas aulas que ainda estão ativas.
    public function scopeAtivas($query)
    {
        return $query->where(function ($query) {
            $query->whereNull('status')
                ->orWhereIn('status', self::statusesAtivas());
        });
    }

    // Relações Eloquent com outras entidades do sistema.
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

    // Acessor para exibir horário de forma legível na view.
    public function getHorarioFormatadoAttribute(): string
    {
        if ($this->horario_inicio && $this->horario_termino) {
            return substr($this->horario_inicio, 0, 5) . ' - ' . substr($this->horario_termino, 0, 5);
        }

        if (!empty($this->horario)) {
            return substr($this->horario, 0, 5);
        }

        return '-';
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusOptions()[$this->statusAtual()] ?? 'Agendada';
    }
}
