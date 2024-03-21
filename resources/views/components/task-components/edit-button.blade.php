@props(['taskId' , 'isAuthorize'])
@php if ($isAuthorize){ @endphp

<a href="{{ route('tasks.edit', $taskId) }}"
   data-tooltip-target="tooltip-tasks-{{$taskId}}-edit"
    {{ $attributes->merge(['class' => 'px-4 py-1 text-sm font-medium text-gray-900 bg-white border border-gray-200  hover:bg-blue-100 hover:text-blue-700  focus:text-blue-700']) }}
>
    {{ $slot }}
</a>
<x-hint
    btnType="edit"
    taskid="{{ $taskId }}">Edit
</x-hint>

@php } @endphp
