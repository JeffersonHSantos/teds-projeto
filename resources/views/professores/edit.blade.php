<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Professor</h2>
    </x-slot>

    <x-ui.page-card>
        <x-ui.validation-errors />

        <form action="{{ route('professores.update', $professor->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nome" class="mb-2 block text-sm font-medium text-gray-700">Nome do professor</label>
                <input id="nome" type="text" name="nome" value="{{ old('nome', $professor->nome) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <x-ui.form-actions
                submit-label="Atualizar Professor"
                :cancel-route="route('professores.index')"
            />
        </form>
    </x-ui.page-card>
</x-app-layout>