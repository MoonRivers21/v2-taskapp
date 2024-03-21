@php use App\Enums\PublishStatus;use App\Enums\TaskStatus; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task details') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-6">
                    <div class="py-4 flex justify-start px-5 col-span-4">
                        <a href="{{ url()->previous() ?? route('tasks.index') }}"
                           class="px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg focus:outline-none  ">
                            <i class="fal fa-arrow-left"></i> Back
                        </a>
                    </div>
                    <div class="text-right py-5 px-8 ">
                        <label class="inline-flex items-center">
                            <div
                                class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span
                                class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ PublishStatus::fromValue($task->published)->label($task->published) }}</span>
                            <input type="checkbox" value="1" name="published" disabled
                                   class="sr-only peer" {{ $task->published == 1 ? 'checked': null }} />

                        </label>
                    </div>
                    <div class=" py-5 px-8 ">
                        <div class="flex flex-col">
                            <label for="status"
                                   class="text-sm font-medium text-gray-900 dark:text-white align-middle">Status:

                            </label>
                            <span
                                class="{{ TaskStatus::fromValue($task->status)->color($task->status) }}">{{ $task->status }}</span>

                        </div>
                    </div>
                </div>

                <div class="p-6 text-gray-900 ">

                    <div class="grid grid-cols-3">
                        <div class="col-span-2 w-auto">
                            <div class="mb-5">
                                <label for="title"
                                       class="font-extrabold block mb-2 text-sm text-gray-900 dark:text-white">Title</label>
                                <label>
                                    {{ $task->title }}
                                </label>

                            </div>
                            <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                            <div class="mb-5  relative overflow-x-auto max-h-[448px]">
                                <label for="content"
                                       class="block mb-2 text-sm  font-medium text-gray-900 dark:text-white">Content</label>
                                <label class="text-justify">
                                    {{ $task->content }}

                                </label>

                            </div>
                        </div>
                        <div class="col-span-1 ">
                            <div class="flex-col space-y-3">
                                <div class="flex justify-center mb-3  ">
                                    <img src="{{ $task->image_path }}" width="130"
                                         class="h-auto max-w-full rounded-lg"/>

                                </div>


                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</x-app-layout>
