<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Aulas</h2>
    </x-slot>

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

        <form method="GET" action="{{ route('aulas.index') }}">
            <div class="relative mb-4 rounded-md border border-gray-300 bg-gray-50 p-4">
                <div id="aulas-filter-panel" class="fixed z-[9999] hidden w-[min(90vw,18rem)] max-h-[80vh] overflow-y-auto rounded-md border border-gray-200 bg-white p-2.5 shadow-2xl">
                    <div data-filter-section="salas" class="hidden">
                        <label class="mb-2 flex items-center gap-2 font-medium text-gray-700">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-select-all="salas" {{ count($filtros['salas']) === $salas->count() ? 'checked' : '' }}>
                            Todos
                        </label>
                        <div class="max-h-56 space-y-2 overflow-y-auto pr-1">
                            @foreach($salas as $sala)
                                <label class="flex items-center gap-2 text-gray-700">
                                    <input type="checkbox" name="salas[]" value="{{ $sala->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-filter-item="salas" {{ in_array((string) $sala->id, $filtros['salas'], true) ? 'checked' : '' }}>
                                    <span>{{ $sala->nome }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div data-filter-section="cursos" class="hidden">
                        <label class="mb-2 flex items-center gap-2 font-medium text-gray-700">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-select-all="cursos" {{ count($filtros['cursos']) === $cursos->count() ? 'checked' : '' }}>
                            Todos
                        </label>
                        <div class="max-h-56 space-y-2 overflow-y-auto pr-1">
                            @foreach($cursos as $curso)
                                <label class="flex items-center gap-2 text-gray-700">
                                    <input type="checkbox" name="cursos[]" value="{{ $curso->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-filter-item="cursos" {{ in_array((string) $curso->id, $filtros['cursos'], true) ? 'checked' : '' }}>
                                    <span>{{ $curso->nome }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div data-filter-section="professores" class="hidden">
                        <label class="mb-2 flex items-center gap-2 font-medium text-gray-700">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-select-all="professores" {{ count($filtros['professores']) === $professores->count() ? 'checked' : '' }}>
                            Todos
                        </label>
                        <div class="max-h-56 space-y-2 overflow-y-auto pr-1">
                            @foreach($professores as $professor)
                                <label class="flex items-center gap-2 text-gray-700">
                                    <input type="checkbox" name="professores[]" value="{{ $professor->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-filter-item="professores" {{ in_array((string) $professor->id, $filtros['professores'], true) ? 'checked' : '' }}>
                                    <span>{{ $professor->nome }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div data-filter-section="materias" class="hidden">
                        <label class="mb-2 flex items-center gap-2 font-medium text-gray-700">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-select-all="materias" {{ count($filtros['materias']) === $materias->count() ? 'checked' : '' }}>
                            Todos
                        </label>
                        <div class="max-h-56 space-y-2 overflow-y-auto pr-1">
                            @foreach($materias as $materia)
                                <label class="flex items-center gap-2 text-gray-700">
                                    <input type="checkbox" name="materias[]" value="{{ $materia }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-filter-item="materias" {{ in_array((string) $materia, $filtros['materias'], true) ? 'checked' : '' }}>
                                    <span>{{ $materia }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div data-filter-section="data" class="hidden space-y-3">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700" for="data_de">Data de</label>
                            <input id="data_de" name="data_de" type="date" value="{{ $filtros['data_de'] ?? '' }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700" for="data_ate">Data até</label>
                            <input id="data_ate" name="data_ate" type="date" value="{{ $filtros['data_ate'] ?? '' }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div data-filter-section="horario" class="hidden space-y-3">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700" for="horario_de">Horário de</label>
                            <input id="horario_de" name="horario_de" type="time" value="{{ isset($filtros['horario_de']) ? substr($filtros['horario_de'], 0, 5) : '' }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700" for="horario_ate">Horário até</label>
                            <input id="horario_ate" name="horario_ate" type="time" value="{{ isset($filtros['horario_ate']) ? substr($filtros['horario_ate'], 0, 5) : '' }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div data-filter-section="status" class="hidden">
                        <label class="mb-2 flex items-center gap-2 font-medium text-gray-700">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-select-all="status" {{ count($filtros['status']) === count($statusOptions) ? 'checked' : '' }}>
                            Todos
                        </label>
                        <div class="max-h-56 space-y-2 overflow-y-auto pr-1">
                            @foreach($statusOptions as $statusValue => $statusLabel)
                                <label class="flex items-center gap-2 text-gray-700">
                                    <input type="checkbox" name="status[]" value="{{ $statusValue }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-filter-item="status" {{ in_array($statusValue, $filtros['status'], true) ? 'checked' : '' }}>
                                    <span>{{ $statusLabel }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="sticky bottom-0 mt-4 flex items-center gap-2 border-t border-gray-200 bg-white pt-3">
                        <button type="submit" class="inline-flex rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                            Aplicar
                        </button>
                        <a href="{{ route('aulas.index') }}" class="inline-flex rounded-md border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                            Limpar
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-md border border-gray-300">
                <table class="min-w-full border-collapse text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">
                            <div class="relative flex items-center justify-between gap-2">
                                <span>Sala</span>
                                <button type="button" class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 shadow-sm hover:bg-gray-100" data-open-filters="salas" aria-label="Abrir filtros da sala">
                                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-4 w-4">
                                        <path d="M3.172 4A2 2 0 0 1 4.586 3.414h10.828A2 2 0 0 1 17 5.828L12.5 10.328V15a1 1 0 0 1-1.447.894l-2-1A1 1 0 0 1 8 14V10.328L3.172 5.5A2 2 0 0 1 3.172 4Z" />
                                    </svg>
                                </button>
                            </div>
                        </th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">
                            <div class="relative flex items-center justify-between gap-2">
                                <span>Curso</span>
                                <button type="button" class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 shadow-sm hover:bg-gray-100" data-open-filters="cursos" aria-label="Abrir filtros do curso">
                                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-4 w-4">
                                        <path d="M3.172 4A2 2 0 0 1 4.586 3.414h10.828A2 2 0 0 1 17 5.828L12.5 10.328V15a1 1 0 0 1-1.447.894l-2-1A1 1 0 0 1 8 14V10.328L3.172 5.5A2 2 0 0 1 3.172 4Z" />
                                    </svg>
                                </button>
                            </div>
                        </th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">
                            <div class="relative flex items-center justify-between gap-2">
                                <span>Professor</span>
                                <button type="button" class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 shadow-sm hover:bg-gray-100" data-open-filters="professores" aria-label="Abrir filtros do professor">
                                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-4 w-4">
                                        <path d="M3.172 4A2 2 0 0 1 4.586 3.414h10.828A2 2 0 0 1 17 5.828L12.5 10.328V15a1 1 0 0 1-1.447.894l-2-1A1 1 0 0 1 8 14V10.328L3.172 5.5A2 2 0 0 1 3.172 4Z" />
                                    </svg>
                                </button>
                            </div>
                        </th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">
                            <div class="relative flex items-center justify-between gap-2">
                                <span>Matéria</span>
                                <button type="button" class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 shadow-sm hover:bg-gray-100" data-open-filters="materias" aria-label="Abrir filtros da matéria">
                                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-4 w-4">
                                        <path d="M3.172 4A2 2 0 0 1 4.586 3.414h10.828A2 2 0 0 1 17 5.828L12.5 10.328V15a1 1 0 0 1-1.447.894l-2-1A1 1 0 0 1 8 14V10.328L3.172 5.5A2 2 0 0 1 3.172 4Z" />
                                    </svg>
                                </button>
                            </div>
                        </th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">
                            <div class="relative flex items-center justify-between gap-2">
                                <span>Data</span>
                                <button type="button" class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 shadow-sm hover:bg-gray-100" data-open-filters="data" aria-label="Abrir filtros de data">
                                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-4 w-4">
                                        <path d="M3.172 4A2 2 0 0 1 4.586 3.414h10.828A2 2 0 0 1 17 5.828L12.5 10.328V15a1 1 0 0 1-1.447.894l-2-1A1 1 0 0 1 8 14V10.328L3.172 5.5A2 2 0 0 1 3.172 4Z" />
                                    </svg>
                                </button>
                            </div>
                        </th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">
                            <div class="relative flex items-center justify-between gap-2">
                                <span>Horário</span>
                                <button type="button" class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 shadow-sm hover:bg-gray-100" data-open-filters="horario" aria-label="Abrir filtros de horário">
                                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-4 w-4">
                                        <path d="M3.172 4A2 2 0 0 1 4.586 3.414h10.828A2 2 0 0 1 17 5.828L12.5 10.328V15a1 1 0 0 1-1.447.894l-2-1A1 1 0 0 1 8 14V10.328L3.172 5.5A2 2 0 0 1 3.172 4Z" />
                                    </svg>
                                </button>
                            </div>
                        </th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">
                            <div class="relative flex items-center justify-between gap-2">
                                <span>Status</span>
                                <button type="button" class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 shadow-sm hover:bg-gray-100" data-open-filters="status" aria-label="Abrir filtros do status">
                                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-4 w-4">
                                        <path d="M3.172 4A2 2 0 0 1 4.586 3.414h10.828A2 2 0 0 1 17 5.828L12.5 10.328V15a1 1 0 0 1-1.447.894l-2-1A1 1 0 0 1 8 14V10.328L3.172 5.5A2 2 0 0 1 3.172 4Z" />
                                    </svg>
                                </button>
                            </div>
                        </th>
                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aulas as $aula)
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
                    @empty
                        <tr>
                            <td colspan="8" class="border border-gray-300 px-4 py-6 text-center text-gray-500">
                                Nenhuma aula cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const filterPanel = document.getElementById('aulas-filter-panel');
                const filterSections = Array.from(document.querySelectorAll('[data-filter-section]'));
                const groups = ['salas', 'cursos', 'professores', 'materias', 'status'];
                const floatingMenus = Array.from(document.querySelectorAll('[data-open-filters]'));

                const hideAllSections = () => {
                    filterSections.forEach((section) => {
                        section.classList.add('hidden');
                    });
                };

                const hideFilterPanel = () => {
                    if (!filterPanel) {
                        return;
                    }

                    filterPanel.classList.add('hidden');
                };

                const openSection = (group, button) => {
                    if (!filterPanel) {
                        return;
                    }

                    const bounds = button.getBoundingClientRect();

                    hideAllSections();
                    const section = filterPanel.querySelector(`[data-filter-section="${group}"]`);

                    if (!section) {
                        return;
                    }

                    section.classList.remove('hidden');
                    filterPanel.classList.remove('hidden');

                    const panelWidth = Math.max(240, Math.min(window.innerWidth - 32, 300));
                    const left = Math.min(
                        window.innerWidth - panelWidth - 16,
                        Math.max(16, bounds.right - panelWidth)
                    );
                    const top = Math.min(window.innerHeight - 32, bounds.bottom + 6);

                    filterPanel.style.width = `${panelWidth}px`;
                    filterPanel.style.left = `${Math.max(16, left)}px`;
                    filterPanel.style.top = `${Math.max(16, top)}px`;

                    const firstInput = section.querySelector('input');
                    if (firstInput) {
                        firstInput.focus();
                    }
                };

                floatingMenus.forEach((button) => {
                    button.addEventListener('click', (event) => {
                        event.preventDefault();
                        const group = button.dataset.openFilters;
                        openSection(group, button);
                    });
                });

                document.addEventListener('click', (event) => {
                    if (!filterPanel || filterPanel.classList.contains('hidden')) {
                        return;
                    }

                    if (filterPanel.contains(event.target) || event.target.closest('[data-open-filters]')) {
                        return;
                    }

                    filterPanel.classList.add('hidden');
                });

                window.addEventListener('scroll', hideFilterPanel, { passive: true });
                window.addEventListener('resize', hideFilterPanel);

                groups.forEach((group) => {
                    const selectAll = document.querySelector(`[data-select-all="${group}"]`);
                    const items = Array.from(document.querySelectorAll(`[data-filter-item="${group}"]`));

                    if (!selectAll || items.length === 0) {
                        return;
                    }

                    const syncSelectAll = () => {
                        selectAll.checked = items.every((item) => item.checked);
                    };

                    selectAll.addEventListener('change', () => {
                        items.forEach((item) => {
                            item.checked = selectAll.checked;
                        });
                    });

                    items.forEach((item) => {
                        item.addEventListener('change', syncSelectAll);
                    });

                    syncSelectAll();
                });
            });
        </script>
    </x-ui.page-card>
</x-app-layout>