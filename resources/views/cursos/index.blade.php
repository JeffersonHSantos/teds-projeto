<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cursos</h2>
    </x-slot>

    <x-ui.page-card>
        <x-ui.list-header
            title="Lista de Cursos"
            :create-route="route('cursos.create')"
            create-label="Novo Curso"
        />

        <div class="overflow-x-auto rounded-md border border-gray-300">
            <table class="min-w-full border-collapse text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Nome</th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cursos as $curso)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-3">{{ $curso->nome }}</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <x-ui.row-actions
                                    :edit-route="route('cursos.edit', $curso->id)"
                                    :delete-route="route('cursos.destroy', $curso->id)"
                                    confirm-message="Deseja realmente excluir este curso?"
                                />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="border border-gray-300 px-4 py-6 text-center text-gray-500">
                                Nenhum curso cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.page-card>
</x-app-layout>