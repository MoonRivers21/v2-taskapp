@props(['taskId'])

<a href="{{ route('tasks.show', $taskId) }}"
   data-tooltip-target="tooltip-tasks-{{$taskId}}-view"
    {{ $attributes->merge(['class' => 'px-4 py-1 text-sm font-medium text-gray-900 bg-white border border-gray-200  hover:bg-blue-100 hover:text-blue-700  focus:text-blue-700 ']) }}
>
    {{ $slot }}

</a>
<x-hint
    btnType="view"
    taskid="{{ $taskId }}">View more details
</x-hint>

