@php use App\Enums\TaskStatus; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">
                    <div class="py-4 flex justify-end gap-x-3">
                        {{-- Filter options --}}
                        <x-task-components.filter-status/>

                        {{-- Create Button --}}
                        <div class="flex items-center">
                            <a href="{{ route('tasks.create') }}"
                               class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <i class="fas fa-plus"></i> Create
                            </a>
                        </div>

                    </div>
                    <div class="grid grid-cols-2">
                        {{-- Label Indicator  --}}
                        <x-task-components.label-indicator/>

                        {{--  Search Textbox  --}}
                        <x-task-components.search-textbox/>
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                <span
                                    class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">#</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                <span
                                    class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Img</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                  <span
                                      class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('tasks.index', ['sort' => 'title', 'order' => (Request::input('sort') == 'title' && Request::input('order') == 'asc') ? 'desc' : 'asc', 'status' => Request::input('status'), 'per_page' => $tasks->perPage()]) }}">
                                            Title
                                            @if (Request::input('sort') == 'title')
                                                @if (Request::input('order') == 'asc')
                                                    <i class="fas fa-sort-up"></i>
                                                @else
                                                    <i class="fas fa-sort-down"></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </a>
                               </span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Content</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                <span
                                    class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                         <a href="{{ route('tasks.index', ['sort' => 'created_at', 'order' => ($sortColumn == 'created_at' && $sortOrder == 'asc') ? 'desc' : 'asc', 'status' => $status, 'per_page' => $tasks->perPage()]) }}">
                                            Date Created
                                            @if ($sortColumn == 'created_at')
                                                 @if ($sortOrder == 'asc')
                                                     <i class="fas fa-sort-up"></i>
                                                 @else
                                                     <i class="fas fa-sort-down"></i>
                                                 @endif
                                             @else
                                                 <i class="fas fa-sort"></i>
                                             @endif
                                         </a>
                                </span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                <span
                                    class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Draft/Published</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                <span
                                    class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                <span
                                    class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></span>
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                            @php($num = 1)
                            @forelse($tasks as $task)

                                <tr class="bg-white">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ $num }}.
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        <img src="{{ $task->image_path }}"
                                             class="h-auto max-w-full"
                                             width="40"/>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ $task->limitedTitle }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ $task->limitedContent  }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ $task->formattedDate  }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ $task->publishedStr  }}
                                    </td>
                                    <td class="whitespace-no-wrap text-sm text-center text-yellow-500">
                                        <span
                                            class="{{ TaskStatus::fromValue($task->status)->color($task->status) }}">{{ $task->status }}</span>

                                    </td>


                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        <div class="inline-flex rounded-md shadow-sm" role="group">
                                            {{-- View Button--}}
                                            <x-task-components.view-button taskId="{{$task->id}}">
                                                <i class="far fa-eye"></i>
                                            </x-task-components.view-button>

                                            {{-- Edit Button--}}
                                            <x-task-components.edit-button taskId="{{$task->id}}"
                                                                          isAuthorize="{{$task->isAuthorizeToEdit($task)}}">
                                                <i class="fas fa-edit"></i>
                                            </x-task-components.edit-button>

                                            {{-- To-do Button--}}
                                            <x-task-components.todo-button taskId="{{$task->id}}"
                                                                          isAuthorize="{{$task->handlePolicyMarkAsTodo($task)}}">
                                                <i class="far fa-clipboard-list-check"></i>
                                            </x-task-components.todo-button>

                                            {{-- In Progress Button--}}
                                            <x-task-components.inprogress-button taskId="{{$task->id}}"
                                                                                isAuthorize="{{$task->handlePolicyMarkInProgress($task)}}">
                                                <i class="far fa-business-time"></i>
                                            </x-task-components.inprogress-button>

                                            {{-- Done Button--}}
                                            <x-task-components.done-button taskId="{{$task->id}}"
                                                                          isAuthorize="{{$task->handlePolicyMarkDone($task)}}">
                                                <i class="fas fa-clipboard-check text-green-900"></i>
                                            </x-task-components.done-button>

                                            <!-- Trash button with modal trigger -->
                                            <x-task-components.trash-button taskId="{{$task->id}}">
                                                <i class="fas fa-trash"></i>
                                            </x-task-components.trash-button>
                                        </div>

                                    </td>
                                </tr>
                                @php($num++)
                            @empty
                                <tr class="bg-white">
                                    <td colspan="9"
                                        class="text-center px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500 ">

                                        @if(!empty(request('search')))
                                            No result found for <b>{{request('search')}}</b>

                                        @elseif(!empty(request('status')))
                                            No result found for status :<b>{{request('status')}}</b>

                                        @else
                                            Create new to get started.
                                            <div class="flex justify-center py-2">
                                                <a href="{{ route('tasks.create') }}"
                                                   class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <i class="fas fa-plus"></i> Create
                                                </a>
                                            </div>
                                        @endif

                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2 mx-auto">
                        {{
                                $tasks->appends([
                                    'sort' =>request('sort') ?? null,
                                    'order' =>request('order') ?? null,
                                    'status' => request('status') ?? null,
                                    'per_page' => $tasks->perPage()
                                ])->links()
                        }}

                        @if($tasks->total() > 5)
                            <form class="form-inline" method="GET" action="{{ url()->current() }}">
                                <div class="flex justify-center">
                                    <label for="perPage"
                                           class="text-sm text-gray-700 leading-5 dark:text-gray-400 self-center">Display
                                        per page</label>
                                    <select
                                        class="text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300"
                                        id="perPage" name="per_page" onchange="this.form.submit()">
                                        <option value="5" {{ $tasks->perPage() == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ $tasks->perPage() == 10 ? 'selected' : '' }}>10</option>
                                        <option value="15" {{ $tasks->perPage() == 15 ? 'selected' : '' }}>15</option>
                                        <option value="20" {{ $tasks->perPage() == 20 ? 'selected' : '' }}>20</option>
                                        <option value="25" {{ $tasks->perPage() == 25 ? 'selected' : '' }}>25</option>
                                    </select>
                                </div>
                            </form>
                        @endif

                    </div>

                </div>


            </div>
        </div>
    </div>


    <script>
        document.getElementById('perPage').addEventListener('change', function () {
            this.form.submit();
        });


        document.addEventListener('alpine:init', () => {
            Alpine.data('modal', () => ({
                showModal: false,
                openModal() {
                    this.showModal = true;
                },
                closeModal() {
                    this.showModal = false;
                },
            }));
        });

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('popup-modal');
            const toggleBtn = document.querySelector('[data-modal-toggle="popup-modal"]');
            const closeBtn = document.querySelector('[data-modal-hide="popup-modal"]');

            toggleBtn.addEventListener('click', () => {
                modal.classList.toggle('hidden');
            });

            closeBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>
