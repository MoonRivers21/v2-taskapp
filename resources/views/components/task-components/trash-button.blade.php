@props(['taskId'])

<div>
    <button data-tooltip-target="tooltip-tasks-{{$taskId}}-trash"
            data-modal-target="confirm-delete-modal-{{ $taskId }}"
            data-modal-toggle="confirm-delete-modal-{{ $taskId }}"
            class="px-4 py-1 text-sm font-medium text-gray-900 bg-white border border-gray-200  hover:bg-red-100 hover:text-red-700  focus:text-red-700">
        {{ $slot }}
    </button>
    <!-- Modal Confirmation -->
    <x-delete-modal-confirm taskid="{{ $taskId }}"/>

    <x-hint
        btnType="trash"
        taskid="{{ $taskId }}">Move to trash
    </x-hint>
</div>
