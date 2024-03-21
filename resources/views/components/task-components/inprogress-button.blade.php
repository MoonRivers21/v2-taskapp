@php use App\Enums\TaskStatus; @endphp
@props(['taskId', 'isAuthorize'])
@php if ($isAuthorize){ @endphp
<div>
    <form
        action="{{ route('tasks.patch.status', ['id' => $taskId, 'progress' => TaskStatus::IN_PROGRESS]) }}"
        method="POST">
        @csrf
        @method('PATCH')
        <button
            type="submit"
            data-tooltip-target="tooltip-tasks-{{$taskId}}-inprogress"
            class="px-4 py-1 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-green-100 hover:text-green-700  focus:text-green-700 ">
            {{ $slot }}
        </button>
    </form>
    <x-hint
        btnType="inprogress"
        taskid="{{ $taskId }}">Set as In-progress
    </x-hint>
</div>
@php } @endphp
