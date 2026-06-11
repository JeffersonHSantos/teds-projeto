<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Professores</h2>
    </x-slot>

    <x-ui.page-card>
        <x-ui.list-header
            title="Lista de Professores"
            :create-route="route('professores.create')"
            create-label="Novo Professor"
        />

        <div class="overflow-x-auto rounded-md border border-gray-300">
            @if(count($professores) > 0)
                <table id="tabela-professores" class="min-w-full border-collapse text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Nome</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($professores as $professor)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-3">{{ $professor->nome }}</td>
                                <td class="border border-gray-300 px-4 py-3">
                                    <x-ui.row-actions
                                        :edit-route="route('professores.edit', $professor->id)"
                                        :delete-route="route('professores.destroy', $professor->id)"
                                        confirm-message="Deseja realmente excluir este professor?"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="py-12 text-center text-gray-500">
                    <p>Nenhum professor cadastrado.</p>
                </div>
            @endif
        </div>

        <script>
            $(document).ready(function() {
                $('#tabela-professores').DataTable({
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
                        { targets: 1, orderable: false, searchable: false }
                    ]
                });
            });
        </script>
    </x-ui.page-card>
</x-app-layout>
