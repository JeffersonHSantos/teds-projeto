<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ isset($aula) ? 'Editar Aula' : 'Nova Aula' }}</h2>
    </x-slot>

    <x-ui.page-card>
        <x-ui.validation-errors />

        <form action="{{ isset($aula) ? route('aulas.update', $aula->id) : route('aulas.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($aula))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="sala_id" class="mb-2 block text-sm font-medium text-gray-700">Sala</label>
                    <select id="sala_id" name="sala_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($salas as $sala)
                            <option value="{{ $sala->id }}" {{ old('sala_id', $aula->sala_id ?? '') == $sala->id ? 'selected' : '' }}>{{ $sala->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="curso_id" class="mb-2 block text-sm font-medium text-gray-700">Curso</label>
                    <select id="curso_id" name="curso_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}" {{ old('curso_id', $aula->curso_id ?? '') == $curso->id ? 'selected' : '' }}>{{ $curso->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="professor_id" class="mb-2 block text-sm font-medium text-gray-700">Professor</label>
                    <select id="professor_id" name="professor_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($professores as $professor)
                            <option value="{{ $professor->id }}" {{ old('professor_id', $aula->professor_id ?? '') == $professor->id ? 'selected' : '' }}>{{ $professor->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="materia" class="mb-2 block text-sm font-medium text-gray-700">Matéria</label>
                    <input id="materia" type="text" name="materia" placeholder="Digite a matéria" value="{{ old('materia', $aula->materia ?? '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="data" class="mb-2 block text-sm font-medium text-gray-700">Data</label>
                    <input id="data" type="date" name="data" value="{{ old('data', $aula->data ?? '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="horario_inicio" class="mb-2 block text-sm font-medium text-gray-700">Horário de início</label>
                    <input id="horario_inicio" type="time" name="horario_inicio" value="{{ old('horario_inicio', isset($aula) && ($aula->horario_inicio || $aula->horario) ? \Carbon\Carbon::parse($aula->horario_inicio ?? $aula->horario)->format('H:i') : '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="horario_termino" class="mb-2 block text-sm font-medium text-gray-700">Horário de término</label>
                    <input id="horario_termino" type="time" name="horario_termino" value="{{ old('horario_termino', isset($aula) && $aula->horario_termino ? \Carbon\Carbon::parse($aula->horario_termino)->format('H:i') : '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <x-ui.form-actions
                :submit-label="isset($aula) ? 'Atualizar Aula' : 'Salvar Aula'"
                :cancel-route="route('aulas.index')"
            />
        </form>

    </x-ui.page-card>
</x-app-layout>