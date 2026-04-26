@props([
    'submitLabel',
    'cancelRoute',
    'cancelLabel' => 'Cancelar',
])

<div class="flex items-center gap-3">
    <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        {{ $submitLabel }}
    </button>

    <a href="{{ $cancelRoute }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
        {{ $cancelLabel }}
    </a>
</div>
