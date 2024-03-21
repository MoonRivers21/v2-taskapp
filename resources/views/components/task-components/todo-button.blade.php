@php use App\Enums\TaskStatus; @endphp
@props(['taskId', 'isAuthorize'])
@php if ($isAuthorize){ @endphp
<div>
    <form
        action="{{ route('tasks.patch.status', ['id' => $taskId, 'progress' => TaskStatus::TODO]) }}"
        method="POST">
        @csrf
        @method('PATCH')
        <button
            type="submit"
            data-tooltip-target="tooltip-tasks-{{$taskId}}-todo"
            class="px-4 py-1 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-yellow-100 hover:text-yellow-700  focus:text-yellow-700 ">
            {{ $slot }}
        </button>
    </form>
    <x-hint
        btnType="todo"
        taskid="{{ $taskId }}">Set as To-do
    </x-hint>
</div>
@php } @endphp
