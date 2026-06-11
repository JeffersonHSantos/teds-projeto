<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Aulas</h2>
    </x-slot>

    {{-- View da lista de aulas, com dados carregados pelo controlador. --}}
    @php
        $statusClasses = [
            'AGENDADA' => 'bg-blue-100 text-blue-800',
            'EM_ANDAMENTO' => 'bg-amber-100 text-amber-800',
            'REALIZADA' => 'bg-emerald-100 text-emerald-800',
            'CANCELADA' => 'bg-gray-200 text-gray-700',
        ];
    @endphp

    <x-ui.page-card>
        <x-ui.list-header
            title="Lista de Aulas"
            :create-route="route('aulas.create')"
            create-label="Nova Aula"
        />

        <div class="overflow-x-auto rounded-md border border-gray-300">
            @if(count($aulas) > 0)
                {{-- Tabela que exibe as aulas com ações de edição e exclusão. --}}
                <table id="tabela-aulas" class="min-w-full border-collapse text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Sala</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Curso</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Professor</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Matéria</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Data</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Horário</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aulas as $aula)
                            <tr class="hover:bg-gray-50">
                                @php
                                    $statusAtual = $aula->statusAtual();
                                @endphp
                                <td class="border border-gray-300 px-4 py-3">{{ $aula->sala->nome }}</td>
                                <td class="border border-gray-300 px-4 py-3">{{ $aula->curso->nome }}</td>
                                <td class="border border-gray-300 px-4 py-3">{{ $aula->professor->nome }}</td>
                                <td class="border border-gray-300 px-4 py-3">{{ $aula->materia }}</td>
                                <td class="border border-gray-300 px-4 py-3">{{ \Carbon\Carbon::parse($aula->data)->format('d/m/Y') }}</td>
                                <td class="border border-gray-300 px-4 py-3">{{ $aula->horario_formatado }}</td>
                                <td class="border border-gray-300 px-4 py-3">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses[$statusAtual] ?? 'bg-blue-100 text-blue-800' }}">
                                        {{ $aula->status_label }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-4 py-3">
                                    <x-ui.row-actions
                                        :edit-route="route('aulas.edit', $aula->id)"
                                        :delete-route="route('aulas.destroy', $aula->id)"
                                        confirm-message="Deseja realmente excluir esta aula?"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="py-12 text-center text-gray-500">
                    <p>Nenhuma aula cadastrada.</p>
                </div>
            @endif
        </div>

        {{-- Configuração de DataTables para melhorar a navegação na listagem. --}}
        <script>
            $(document).ready(function() {
                $('#tabela-aulas').DataTable({
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
                    },
                    paging: true,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    responsive: false,
                    columnDefs: [
                        { targets: 7, orderable: false, searchable: false }
                    ]
                });
            });
        </script>
    </x-ui.page-card>
</x-app-layout>
