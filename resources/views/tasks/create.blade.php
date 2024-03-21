@php use App\Enums\TaskStatus; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Task') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-4 flex justify-start px-5">
                    <a href="{{ url()->previous() ?? route('tasks.index') }}"
                       class="px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300  ">
                        <i class="fal fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="p-6 text-gray-900 ">


                    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <div class="mb-5">
                                    <label for="title"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                                    <textarea rows="4" name="title"
                                              class="form-input w-full rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                              required>{{ old('title') }}</textarea>
                                    @error('title')
                                    <x-flash-error-msg>{{ $message }}</x-flash-error-msg>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="content"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content</label>
                                    <textarea rows="6" name="content"
                                              class="form-input w-full rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                              required>{{ old('content') }}</textarea>
                                    @error('content')
                                    <x-flash-error-msg>{{ $message }}</x-flash-error-msg>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-1 flex-col justify-between items-center p-3">
                                <div class="container mb-10">
                                    <label for="filepond"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choose
                                        Image <span class="text-slate-400">(Optional)</span></label>
                                    <input type="file" name="image" accept="image/*">
                                    @error('image')
                                    <x-flash-error-msg>{{ $message }}</x-flash-error-msg>
                                    @enderror
                                </div>

                                <div class="py-5">
                                    <label for="status"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                    <select id="status" name="status"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        @foreach(TaskStatus::toSelectArray() as $status)
                                            <option value="{{$status}}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="py-5">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="1" name="published" class="sr-only peer" checked>
                                        <div
                                            class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Published</span>
                                    </label>
                                </div>

                            </div>


                            <div class="mt-5 col-span-3 flex justify-center">
                                <button type="submit"
                                        class="px-5 py-2 text-medium font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
