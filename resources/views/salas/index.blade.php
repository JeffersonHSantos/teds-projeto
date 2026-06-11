<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Salas</h2>
    </x-slot>

    <x-ui.page-card>
        <x-ui.list-header
            title="Lista de Salas"
            :create-route="route('salas.create')"
            create-label="Nova Sala"
        />

        <div class="overflow-x-auto rounded-md border border-gray-300">
            @if(count($salas) > 0)
                <table id="tabela-salas" class="min-w-full border-collapse text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Nome</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salas as $sala)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-3">{{ $sala->nome }}</td>
                                <td class="border border-gray-300 px-4 py-3">
                                    <x-ui.row-actions
                                        :edit-route="route('salas.edit', $sala->id)"
                                        :delete-route="route('salas.destroy', $sala->id)"
                                        confirm-message="Deseja realmente excluir esta sala?"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="py-12 text-center text-gray-500">
                    <p>Nenhuma sala cadastrada.</p>
                </div>
            @endif
        </div>

        <script>
            $(document).ready(function() {
                $('#tabela-salas').DataTable({
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
