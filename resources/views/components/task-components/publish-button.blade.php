@php use App\Enums\PublishStatus; @endphp
@props(['taskId'])

<div>
    <form
        action="{{ route('tasks.patch.status', ['id' => $taskId, 'progress' => PublishStatus::PUBLISHED]) }}"
        method="POST">
        @csrf
        @method('PATCH')
        <button
            type="submit"
            data-tooltip-target="tooltip-tasks-{{$taskId}}-publish"
            class="px-4 py-1 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-green-100 hover:text-green-700  focus:text-green-700 ">
            {{$slot}}
        </button>
        <x-hint
            btnType="publish"
            taskid="{{ $taskId }}">Published this task
        </x-hint>
    </form>

</div>
