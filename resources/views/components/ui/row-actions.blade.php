@props([
    'editRoute',
    'deleteRoute',
    'confirmMessage',
])

<div class="flex gap-2">
    <a href="{{ $editRoute }}" class="inline-flex items-center rounded-md bg-amber-500 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-amber-400">
        Editar
    </a>

    <form action="{{ $deleteRoute }}" method="POST" data-swal-confirm="{{ $confirmMessage }}">
        @csrf
        @method('DELETE')

        <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-red-500">
            Excluir
        </button>
    </form>
</div>
