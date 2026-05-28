<x-app-layout>
    @php
        $dataSelecionada = \Carbon\Carbon::parse($selectedDate);
        $statusClasses = [
            'AGENDADA' => 'bg-gradient-to-r from-sky-100 via-cyan-100 to-sky-50 text-sky-800 border-sky-200',
            'EM_ANDAMENTO' => 'bg-amber-100 text-amber-800 border-amber-200',
            'REALIZADA' => 'bg-gradient-to-r from-emerald-100 via-lime-100 to-emerald-50 text-emerald-800 border-emerald-200',
            'CANCELADA' => 'bg-gray-200 text-gray-700 border-gray-300',
        ];
        $rowClasses = [
            'AGENDADA' => 'status-row-status-agendada',
            'EM_ANDAMENTO' => 'status-row-status-em-andamento',
            'REALIZADA' => 'status-row-status-realizada',
            'CANCELADA' => 'status-row-status-cancelada',
        ];
        $cellClasses = [
            'AGENDADA' => 'status-cell-status-agendada',
            'EM_ANDAMENTO' => 'status-cell-status-em-andamento',
            'REALIZADA' => 'status-cell-status-realizada',
            'CANCELADA' => 'status-cell-status-cancelada',
        ];
        $rowStyles = [
            'AGENDADA' => 'background-color: #eff6ff;',
            'EM_ANDAMENTO' => 'background-color: #fef3c7;',
            'REALIZADA' => 'background-color: #ecfdf5;',
            'CANCELADA' => 'background-color: #f3f4f6;',
        ];
        $cellStyles = [
            'AGENDADA' => 'background-color: #dbeafe;',
            'EM_ANDAMENTO' => 'background-color: #fde68a;',
            'REALIZADA' => 'background-color: #d1fae5;',
            'CANCELADA' => 'background-color: #e5e7eb;',
        ];
        $diasSemana = [
            'Domingo',
            'Segunda-feira',
            'Terca-feira',
            'Quarta-feira',
            'Quinta-feira',
            'Sexta-feira',
            'Sabado',
        ];
        $nomeDiaSemana = $diasSemana[$dataSelecionada->dayOfWeek] ?? '';
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Painel</h2>
    </x-slot>

    <style>
        #painel-tv:fullscreen {
            background-color: #ffffff;
            padding: 1.5rem;
            overflow: auto;
        }

        #painel-tv:fullscreen .tv-hide-in-fullscreen {
            display: none;
        }

        .tv-show-in-fullscreen {
            display: none;
        }

        #painel-tv:fullscreen .tv-show-in-fullscreen {
            display: block;
        }

        @keyframes statusPulseSoft {
            0%,
            100% {
                box-shadow: inset 0 0 0 1px rgba(251, 191, 36, 0.35);
            }

            50% {
                box-shadow: inset 0 0 0 1px rgba(251, 191, 36, 0.7), 0 0 0 4px rgba(251, 191, 36, 0.08);
            }
        }

        @keyframes statusColorShiftAgendada {
            0%,
            100% {
                background-color: #eff6ff;
            }

            50% {
                background-color: #dbeafe;
            }
        }

        @keyframes statusColorShiftRealizada {
            0%,
            100% {
                background-color: #ecfdf5;
            }

            50% {
                background-color: #d1fae5;
            }
        }

        @keyframes statusColorShiftEmAndamento {
            0%,
            100% {
                background-color: #fef3c7;
            }

            50% {
                background-color: #fde68a;
            }
        }

        .status-row-status-agendada,
        .status-cell-status-agendada {
            animation: statusColorShiftAgendada 7s ease-in-out infinite;
        }

        .status-row-status-em-andamento,
        .status-cell-status-em-andamento {
            animation: statusColorShiftEmAndamento 4.5s ease-in-out infinite;
        }

        .status-row-status-realizada,
        .status-cell-status-realizada {
            animation: statusColorShiftRealizada 7s ease-in-out infinite;
        }

        .status-row-status-cancelada,
        .status-cell-status-cancelada {
            background-color: #e5e7eb;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="painel-tv" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between mb-6">
                        <div class="tv-hide-in-fullscreen">
                            <h3 class="text-lg font-semibold text-gray-800">Aulas por Data</h3>
                            <p class="text-sm text-gray-600">Selecione uma data para visualizar as aulas agendadas.</p>
                        </div>

                        <div class="tv-show-in-fullscreen">
                            <h3 class="text-3xl font-bold text-gray-900">{{ $nomeDiaSemana }}</h3>
                            <p class="text-base text-gray-600">{{ $dataSelecionada->format('d/m/Y') }}</p>
                        </div>

                        <form action="{{ route('dashboard') }}" method="GET" class="tv-hide-in-fullscreen flex items-end gap-3">
                            <div>
                                <label for="data" class="mb-2 block text-sm font-medium text-gray-700">Data</label>
                                <input
                                    id="data"
                                    type="date"
                                    name="data"
                                    value="{{ $selectedDate }}"
                                    class="block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Filtrar
                            </button>

                            <button id="tv-fullscreen-button" type="button" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2">
                                Tela Cheia (TV)
                            </button>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-md border border-gray-300">
                        <table class="min-w-full border-collapse text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Horário</th>
                                    <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Matéria</th>
                                    <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Curso</th>
                                    <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Professor</th>
                                    <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Sala</th>
                                    <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody id="dashboard-aulas-tbody">
                                @forelse($aulasDoDia as $aula)
                                    @php
                                        $statusAtual = $aula->statusAtual();
                                    @endphp
                                    <tr class="{{ $rowClasses[$statusAtual] ?? 'status-row-status-agendada' }} transition-colors duration-300" style="{{ $rowStyles[$statusAtual] ?? 'background-color: #eff6ff;' }}">
                                        <td class="border border-gray-300 px-4 py-3" style="{{ $cellStyles[$statusAtual] ?? 'background-color: #dbeafe;' }}">{{ $aula->horario_formatado }}</td>
                                        <td class="border border-gray-300 px-4 py-3 {{ $cellClasses[$statusAtual] ?? 'status-cell-status-agendada' }}" style="{{ $cellStyles[$statusAtual] ?? 'background-color: #dbeafe;' }}">{{ $aula->materia }}</td>
                                        <td class="border border-gray-300 px-4 py-3 {{ $cellClasses[$statusAtual] ?? 'status-cell-status-agendada' }}" style="{{ $cellStyles[$statusAtual] ?? 'background-color: #dbeafe;' }}">{{ $aula->curso->nome }}</td>
                                        <td class="border border-gray-300 px-4 py-3 {{ $cellClasses[$statusAtual] ?? 'status-cell-status-agendada' }}" style="{{ $cellStyles[$statusAtual] ?? 'background-color: #dbeafe;' }}">{{ $aula->professor->nome }}</td>
                                        <td class="border border-gray-300 px-4 py-3 {{ $cellClasses[$statusAtual] ?? 'status-cell-status-agendada' }}" style="{{ $cellStyles[$statusAtual] ?? 'background-color: #dbeafe;' }}">{{ $aula->sala->nome }}</td>
                                        <td class="border border-gray-300 px-4 py-3 {{ $cellClasses[$statusAtual] ?? 'status-cell-status-agendada' }}" style="{{ $cellStyles[$statusAtual] ?? 'background-color: #dbeafe;' }}">
                                            <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold {{ $statusClasses[$statusAtual] ?? 'bg-sky-100 text-sky-800 border-sky-200' }}">
                                                {{ $aula->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border border-gray-300 px-4 py-6 text-center text-gray-500">
                                            Nenhuma aula encontrada para esta data.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const painel = document.getElementById('painel-tv');
            const fullscreenButton = document.getElementById('tv-fullscreen-button');
            const refreshUrl = @json(route('dashboard', ['data' => $selectedDate]));
            const tbody = document.getElementById('dashboard-aulas-tbody');
            let refreshTimer = null;
            let refreshTimeout = null;
            let refreshInProgress = false;

            if (!painel || !fullscreenButton || !tbody) {
                return;
            }

            const atualizarTabelaAulas = async function () {
                if (refreshInProgress) {
                    return;
                }

                refreshInProgress = true;

                try {
                    const response = await fetch(`${refreshUrl}&_=${Date.now()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Cache-Control': 'no-cache',
                        },
                        cache: 'no-store',
                    });

                    if (!response.ok) {
                        return;
                    }

                    const html = await response.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const novoTbody = doc.getElementById('dashboard-aulas-tbody');

                    if (novoTbody) {
                        tbody.innerHTML = novoTbody.innerHTML;
                    }
                } catch (error) {
                    console.error('Falha ao atualizar o painel de aulas.', error);
                } finally {
                    refreshInProgress = false;
                }
            };

            const agendarAtualizacao = function () {
                const agora = new Date();
                const segundosAteProximoMinuto = (60 - agora.getSeconds()) * 1000 - agora.getMilliseconds();

                window.clearTimeout(refreshTimeout);
                window.clearInterval(refreshTimer);

                refreshTimeout = window.setTimeout(async function () {
                    await atualizarTabelaAulas();
                    refreshTimer = window.setInterval(atualizarTabelaAulas, 60000);
                }, segundosAteProximoMinuto > 0 ? segundosAteProximoMinuto : 1000);
            };

            fullscreenButton.addEventListener('click', async function () {
                if (!document.fullscreenElement) {
                    try {
                        await painel.requestFullscreen();
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Falha ao ativar a tela cheia',
                            text: 'Nao foi possivel ativar a tela cheia neste navegador.',
                            confirmButtonText: 'Entendi',
                        });
                    }
                }
            });

            atualizarTabelaAulas();
            agendarAtualizacao();

            // Ativa/desativa tela cheia ao pressionar F11.
            document.addEventListener('keydown', function (e) {
                const key = e.key || e.code || e.keyCode;
                const isF11 = key === 'F11' || key === 'OSF11' || key === 122 || key === 'F11';
                if (!isF11) return;

                // Tenta prevenir o comportamento nativo do navegador
                try { e.preventDefault(); } catch (err) {}

                if (!document.fullscreenElement) {
                    fullscreenButton.click();
                } else {
                    document.exitFullscreen();
                }
            });
        });
    </script>
</x-app-layout>
