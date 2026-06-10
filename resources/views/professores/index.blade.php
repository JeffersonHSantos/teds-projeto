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

        <div class="relative mb-4 rounded-md border border-gray-300 bg-gray-50 p-4">
            <form method="GET" action="{{ route('professores.index') }}">
                <div id="professores-filter-panel" class="fixed z-[9999] hidden w-[min(90vw,18rem)] max-h-[80vh] overflow-y-auto rounded-md border border-gray-200 bg-white p-2.5 shadow-2xl">
                    <div data-filter-section="professores" class="hidden space-y-2">
                        <label class="mb-2 flex items-center gap-2 font-medium text-gray-700">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-select-all="professores" {{ count($filtros['professores']) === $professorOptions->count() ? 'checked' : '' }}>
                            Todos
                        </label>
                        <div class="max-h-56 space-y-2 overflow-y-auto pr-1">
                            @foreach($professorOptions as $professorOption)
                                <label class="flex items-center gap-2 text-gray-700">
                                    <input type="checkbox" name="professores[]" value="{{ $professorOption->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-filter-item="professores" {{ in_array((string) $professorOption->id, $filtros['professores'], true) ? 'checked' : '' }}>
                                    <span>{{ $professorOption->nome }}</span>
                                </label>
                            @endforeach
                        </div>

                        <div class="sticky bottom-0 mt-4 flex items-center gap-2 border-t border-gray-200 bg-white pt-3">
                            <button type="submit" class="inline-flex rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                                Aplicar
                            </button>
                            <a href="{{ route('professores.index') }}" class="inline-flex rounded-md border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                                Limpar
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="overflow-x-auto rounded-md border border-gray-300">
                    <table id="tabela-professores" class="min-w-full border-collapse text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">
                                    <div class="relative flex items-center justify-between gap-2">
                                        <span>Nome</span>
                                        <button type="button" class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 shadow-sm hover:bg-gray-100" data-open-filters="professores" aria-label="Abrir filtros do professor">
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
                            @forelse($professores as $professor)
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
                            @empty
                                <tr>
                                    <td colspan="2" class="border border-gray-300 px-4 py-6 text-center text-gray-500">
                                        Nenhum professor cadastrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const filterPanel = document.getElementById('professores-filter-panel');
                const filterSections = Array.from(document.querySelectorAll('[data-filter-section]'));
                const groups = ['professores'];
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

            $(document).ready(function() {
                $('#tabela-professores').DataTable({
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
                    },
                    paging: true,
                    pageLength: 10,
                    searching: true,
                    ordering: true,
                    info: true,
                    responsive: true
                });
            });
        </script>
    </x-ui.page-card>
</x-app-layout>