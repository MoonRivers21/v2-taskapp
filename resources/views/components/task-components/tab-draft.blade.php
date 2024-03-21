@php use App\Enums\PublishStatus;use App\Enums\TaskStatus; @endphp
@props(['taskDraft'])

<ul role="list"
    class="divide-y divide-gray-200 dark:divide-gray-700 border rounded-lg">
    @php $i = 1 @endphp
    @forelse($taskDraft as $draft)
        <li class="py-3 sm:py-4 hover:bg-gray-100 hover:rounded-md p-2">
            <div class="flex items-center ">
                <div class="pr-3 font-light text-xs text-slate-400">{{ $i }}.
                </div>
                <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full"
                         src="{{ $draft->imagePath }}"
                         alt="Bonnie image">
                </div>
                <div class="flex-1 min-w-0 ms-4">
                    <p class="text-xs mb-2 text-yellow-500">
                        <span
                            class="{{ TaskStatus::fromValue($draft->status)->color($draft->status) }}">{{ $draft->status }}</span>
                    </p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $draft->limitedTitle }}
                    </p>
                    <p class="text-sm text-gray-700">
                        {{ $draft->limitedContent }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $draft->diffTime }}
                    </p>
                </div>
                <div
                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">

                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        {{-- View Button--}}
                        <x-taskComponents.view-button taskId="{{$draft->id}}">
                            <i class="far fa-eye"></i>
                        </x-taskComponents.view-button>


                        {{-- Edit Button--}}
                        <x-taskComponents.edit-button taskId="{{$draft->id}}"
                                                      isAuthorize="{{$draft->isAuthorizeToEdit($draft)}}">
                            <i class="fas fa-edit"></i>
                        </x-taskComponents.edit-button>

                        {{-- Publish Button--}}
                        <x-taskComponents.publish-button taskId="{{$draft->id}}">
                            <i class="fas fa-globe-asia"></i>
                        </x-taskComponents.publish-button>

                        <!-- Delete button with modal trigger -->
                        <button
                            data-modal-target="confirm-delete-modal-{{ $draft->id }}"
                            data-modal-toggle="confirm-delete-modal-{{ $draft->id }}"
                            data-tooltip-target="tooltip-tasks-{{$draft->id}}-trash"
                            class="px-4 py-1 text-sm font-medium text-gray-900 bg-white border border-gray-200  hover:bg-red-100 hover:text-red-700  focus:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                        <x-hint
                            btnType="trash"
                            taskid="{{ $draft->id }}">Move to trash
                        </x-hint>
                        <!-- Modal Confirmation -->
                        <x-delete-modal-confirm taskid="{{ $draft->id }}"/>
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
