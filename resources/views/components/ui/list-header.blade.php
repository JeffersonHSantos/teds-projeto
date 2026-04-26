@props([
    'title',
    'createRoute',
    'createLabel',
])

<div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>

    <a href="{{ $createRoute }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        {{ $createLabel }}
    </a>
</div>
