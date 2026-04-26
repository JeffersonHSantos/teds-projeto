<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Aulas</h2>
    </x-slot>

    <x-ui.page-card>
        <x-ui.list-header
            title="Lista de Aulas"
            :create-route="route('aulas.create')"
            create-label="Nova Aula"
        />

        <div class="overflow-x-auto rounded-md border border-gray-300">
            <table class="min-w-full border-collapse text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Sala</th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Curso</th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Professor</th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Matéria</th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Data</th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Horário</th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aulas as $aula)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-3">{{ $aula->sala->nome }}</td>
                            <td class="border border-gray-300 px-4 py-3">{{ $aula->curso->nome }}</td>
                            <td class="border border-gray-300 px-4 py-3">{{ $aula->professor->nome }}</td>
                            <td class="border border-gray-300 px-4 py-3">{{ $aula->materia }}</td>
                            <td class="border border-gray-300 px-4 py-3">{{ \Carbon\Carbon::parse($aula->data)->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-4 py-3">{{ $aula->horario }}</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <x-ui.row-actions
                                    :edit-route="route('aulas.edit', $aula->id)"
                                    :delete-route="route('aulas.destroy', $aula->id)"
                                    confirm-message="Deseja realmente excluir esta aula?"
                                />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border border-gray-300 px-4 py-6 text-center text-gray-500">
                                Nenhuma aula cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.page-card>
</x-app-layout>