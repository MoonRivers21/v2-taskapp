@php use App\Enums\PublishStatus;use App\Enums\TaskStatus; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-4 gap-5">

                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700 col-span-4">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="todo-tab"
                                data-tabs-toggle="#todo-tab-content" role="tablist">
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="todo-tab"
                                            data-tabs-target="#todo" type="button" role="tab" aria-controls="todo"
                                            aria-selected="false">Todo {{'('.$countTodo.')' ?? null}}
                                    </button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        id="draft-tab" data-tabs-target="#Draft" type="button" role="tab"
                                        aria-controls="draft" aria-selected="false">
                                        Draft {{'('.$countDraft.')' ?? null}}
                                    </button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        id="inProgress-tab" data-tabs-target="#inProgress" type="button" role="tab"
                                        aria-controls="inProgress" aria-selected="false">
                                        In-progress {{'('.$countProgress.')' ?? null}}
                                    </button>
                                </li>

                            </ul>
                        </div>
                        <div id="default-tab-content" class="col-span-3">
                            <div class="hidden rounded-lg h-[1000px]" id="todo" role="tabpanel"
                                 aria-labelledby="todo-tab">
                                {{-- To do Tab List --}}
                                <div id="todolist"
                                     class=" w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                    <div class="flex items-center justify-between mb-4">
                                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white"><i
                                                class="far fa-clipboard-list-check fa-1x"></i>
                                            Todo
                                        </h5>
                                        <a href="{{ route('tasks.create') }}"
                                           class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Create new
                                        </a>
                                    </div>
                                    <div class="overflow-y-auto" style="max-height: 300px">
                                        <x-task-components.tab-todo :taskTodo="$todotask"/>

                                    </div>
                                </div>

                            </div>
                            <div class="hidden rounded-lg " id="Draft" role="tabpanel"
                                 aria-labelledby="Draft-tab">
                                {{-- Draft Tab List --}}
                                <div id="draftlist"
                                     class="col-span-3 w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                    <div class="flex items-center justify-between mb-4">
                                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">
                                            <i class="far fa-file-alt"></i>
                                            Draft

                                        </h5>
                                        <a href="{{ route('tasks.create') }}"
                                           class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Create new
                                        </a>
                                    </div>
                                    <div class="overflow-y-auto overflow-x-hidden" style="max-height: 350px">
                                        <x-task-components.tab-draft :taskDraft="$draftTasks"/>
                                    </div>
                                </div>
                            </div>

                            <div class="hidden rounded-lg " id="inProgress"
                                 role="tabpanel"
                                 aria-labelledby="inProgress-tab">
                                {{-- inProgress Tab List --}}
                                <div id="inProgresslist"
                                     class="col-span-3 w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                    <div class="flex items-center justify-between mb-4">
                                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">
                                            <i class="far fa-business-time"></i>
                                            In-progress

                                        </h5>
                                        <a href="{{ route('tasks.create') }}"
                                           class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Create new
                                        </a>
                                    </div>
                                    <div class="overflow-y-auto overflow-x-hidden" style="max-height: 350px">
                                        <x-task-components.tab-inprogress :taskProgress="$inProgressTasks"/>

                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Status Summary --}}
                        <div class="">
                            <div
                                class="col-span-3 p-4 w-full bg-white border border-gray-200 rounded-lg shadow grid grid-cols-2 mb-3">
                                <label class="col-span-2 font-extrabold">In-rogress
                                    <hr class="pb-5  mt-2"/>
                                </label>

                                <div><i class="fas fa-business-time fa-3x text-blue-500"></i></div>

                                <div class="text-right font-extrabold text-4xl">
                                    {{ $countProgress ?? 0 }}
                                </div>
                            </div>
                            <div
                                class="col-span-3 p-4 w-full bg-white border border-gray-200 rounded-lg shadow grid grid-cols-2 mb-3">
                                <label class="col-span-2 font-extrabold">Trash
                                    <hr class="pb-5  mt-2"/>
                                </label>

                                <div><i class="fal fa-trash fa-3x text-red-600"></i></div>
                                <div class="text-right font-extrabold text-4xl">
                                    {{ $countTrash ?? 0 }}
                                </div>
                            </div>

                            <div
                                class="col-span-3 p-4 w-full bg-white border border-gray-200 rounded-lg shadow grid grid-cols-2 mb-3">
                                <label class="col-span-2 font-extrabold">Done
                                    <hr class="pb-5  mt-2"/>
                                </label>

                                <div><i class="fas fa-clipboard-check text-green-400 fa-3x"></i></div>

                                <div class="text-right font-extrabold text-4xl">
                                    {{ $countDone ?? 0 }}
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
