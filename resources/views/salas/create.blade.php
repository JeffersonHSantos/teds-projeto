<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nova Sala</h2>
    </x-slot>

    <x-ui.page-card>
        <x-ui.validation-errors />

        <form action="{{ route('salas.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="nome" class="mb-2 block text-sm font-medium text-gray-700">Nome da sala</label>
                <input id="nome" type="text" name="nome" value="{{ old('nome') }}" placeholder="Digite o nome da sala" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <x-ui.form-actions
                submit-label="Salvar Sala"
                :cancel-route="route('salas.index')"
            />
        </form>
    </x-ui.page-card>
</x-app-layout>