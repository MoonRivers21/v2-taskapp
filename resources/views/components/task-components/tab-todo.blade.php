@php use App\Enums\TaskStatus; @endphp
@props(['taskTodo'])

<ul role="list"
    class="divide-y divide-gray-200 dark:divide-gray-700 border rounded-lg">
    @php $i = 1 @endphp
    @forelse($taskTodo as $todo)
        <li class="py-3 sm:py-4 hover:bg-gray-100 hover:rounded-md p-2">
            <div class="flex items-center ">
                <div class="pr-3 font-light text-xs text-slate-400">{{ $i }}.
                </div>
                <div class="flex-shrink-0 rounded-sm">
                    <img class="w-8 h-8 "
                         src="{{ $todo->imagePath }}"
                         alt="Bonnie image">
                </div>
                <div class="flex-1 min-w-0 ms-4">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $todo->limitedTitle }}
                    </p>
                    <p class="text-sm text-gray-700">
                        {{ $todo->limitedContent }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $todo->diffTime }}
                    </p>
                </div>
                <div
                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">

                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        {{-- View Button--}}
                        <x-taskComponents.view-button
                            taskId="{{$todo->id}}">
                            <i class="far fa-eye"></i>
                        </x-taskComponents.view-button>

                        {{-- Edit Button--}}
                        <x-taskComponents.edit-button
                            taskId="{{$todo->id}}"
                            isAuthorize="{{$todo->isAuthorizeToEdit($todo)}}">
                            <i class=" far fa-edit"></i>
                        </x-taskComponents.edit-button>

                        {{-- In Progress Button--}}
                        <x-taskComponents.inprogress-button
                            taskId="{{$todo->id}}"
                            isAuthorize="{{$todo->isAuthorizeToEdit($todo)}}">
                            <i class="far fa-business-time"></i>
                        </x-taskComponents.inprogress-button>

                        {{-- Done Button--}}
                        <x-taskComponents.done-button
                            taskId="{{$todo->id}}"
                            isAuthorize="{{$todo->isAuthorizeToEdit($todo)}}">
                            <i class="fas fa-clipboard-check text-green-900"></i>
                        </x-taskComponents.done-button>


                        <!-- Delete button with modal trigger -->
                        <x-taskComponents.trash-button taskId="{{$todo->id}}">
                            <i class="fas fa-trash"></i>
                        </x-taskComponents.trash-button>
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
