@php use App\Enums\TaskStatus; @endphp
@props(['taskId', 'isAuthorize'])
@php if ($isAuthorize){ @endphp

<div>
    <form
        action="{{ route('tasks.patch.status', ['id' => $taskId, 'progress' => TaskStatus::DONE]) }}"
        method="POST">
        @csrf
        @method('PATCH')
        <button
            data-tooltip-target="tooltip-tasks-{{$taskId}}-done"
            type="submit"
            class="px-4 py-1 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-green-200 hover:text-green-800  focus:text-green-800 ">
            {{ $slot }}
        </button>
    </form>
    <x-hint
        btnType="done"
        taskid="{{ $taskId }}">Set as done
    </x-hint>
</div>
@php } @endphp
