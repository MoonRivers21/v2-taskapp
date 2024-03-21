@php use App\Enums\TaskStatus; @endphp
@props(['taskProgress'])

<ul role="list"
    class="divide-y divide-gray-200 dark:divide-gray-700 border rounded-lg">
    @php $i = 1 @endphp
    @forelse($taskProgress as $inProgress)
        <li class="py-3 sm:py-4 hover:bg-gray-100 hover:rounded-md p-2">
            <div class="flex items-center ">
                <div class="pr-3 font-light text-xs text-slate-400">{{ $i }}.
                </div>
                <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full"
                         src="{{ $inProgress->imagePath }}"
                         alt="Bonnie image">
                </div>
                <div class="flex-1 min-w-0 ms-4">
                    <p class="text-xs mb-2 text-yellow-500">
                        <span
                            class="{{ TaskStatus::fromValue($inProgress->status)->color($inProgress->status) }}">{{ $inProgress->status }}</span>
                    </p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $inProgress->limitedTitle }}
                    </p>
                    <p class="text-sm text-gray-700">
                        {{ $inProgress->limitedContent }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $inProgress->diffTime }}
                    </p>
                </div>
                <div
                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">

                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        {{-- View Button--}}
                        <x-task-components.view-button
                            taskId="{{$inProgress->id}}">
                            <i class="far fa-eye"></i>
                        </x-task-components.view-button>

                        {{-- Edit Button--}}
                        <x-task-components.edit-button
                            taskId="{{$inProgress->id}}"
                            isAuthorize="{{$inProgress->isAuthorizeToEdit($inProgress)}}">
                            <i class="fas fa-edit"></i>
                        </x-task-components.edit-button>

                        {{-- To-do Button--}}
                        <x-task-components.todo-button taskId="{{$inProgress->id}}"
                                                      isAuthorize="{{$inProgress->handlePolicyMarkAsTodo($inProgress)}}">
                            <i class="far fa-clipboard-list-check"></i>
                        </x-task-components.todo-button>

                        {{-- Done Button--}}
                        <x-task-components.done-button
                            taskId="{{$inProgress->id}}"
                            isAuthorize="{{$inProgress->handlePolicyMarkDone($inProgress)}}">
                            <i class="fas fa-clipboard-check text-green-900"></i>
                        </x-task-components.done-button>

                        <!-- Delete button with modal trigger -->
                        <x-task-components.trash-button
                            taskId="{{$inProgress->id}}">
                            <i class="fas fa-trash"></i>
                        </x-task-components.trash-button>
                    </div>

                </div>
            </div>
        </li>
        @php $i++ @endphp
    @empty
        <div
            class="text-center text-lg font-extrabold align-middle p-10 text-gray-500">
            No task today.
        </div>
    @endforelse


</ul>
