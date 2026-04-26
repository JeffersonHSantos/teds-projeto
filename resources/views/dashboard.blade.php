<x-app-layout>
    @php
        $dataSelecionada = \Carbon\Carbon::parse($selectedDate);
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

        #painel-tv:fullscreen .tv-exit-button {
            display: inline-flex;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="painel-tv" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex justify-end">
                        <button
                            id="tv-exit-fullscreen"
                            type="button"
                            class="tv-exit-button hidden items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                        >
                            Sair da Tela Cheia
                        </button>
                    </div>

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
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($aulasDoDia as $aula)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-3">{{ substr($aula->horario, 0, 5) }}</td>
                                        <td class="border border-gray-300 px-4 py-3">{{ $aula->materia }}</td>
                                        <td class="border border-gray-300 px-4 py-3">{{ $aula->curso->nome }}</td>
                                        <td class="border border-gray-300 px-4 py-3">{{ $aula->professor->nome }}</td>
                                        <td class="border border-gray-300 px-4 py-3">{{ $aula->sala->nome }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border border-gray-300 px-4 py-6 text-center text-gray-500">
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
            const exitFullscreenButton = document.getElementById('tv-exit-fullscreen');

            if (!painel || !fullscreenButton || !exitFullscreenButton) {
                return;
            }

            fullscreenButton.addEventListener('click', async function () {
                if (!document.fullscreenElement) {
                    try {
                        await painel.requestFullscreen();
                    } catch (error) {
                        alert('Nao foi possivel ativar a tela cheia neste navegador.');
                    }
                }
            });

            exitFullscreenButton.addEventListener('click', async function () {
                if (document.fullscreenElement) {
                    await document.exitFullscreen();
                }
            });
        });
    </script>
</x-app-layout>
