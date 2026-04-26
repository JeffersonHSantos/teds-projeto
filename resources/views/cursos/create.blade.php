<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Novo Curso</h2>
    </x-slot>

    <x-ui.page-card>
        <x-ui.validation-errors />

        <form action="{{ route('cursos.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="nome" class="mb-2 block text-sm font-medium text-gray-700">Nome do curso</label>
                <input id="nome" type="text" name="nome" value="{{ old('nome') }}" placeholder="Digite o nome do curso" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <x-ui.form-actions
                submit-label="Salvar Curso"
                :cancel-route="route('cursos.index')"
            />
        </form>
    </x-ui.page-card>
</x-app-layout>