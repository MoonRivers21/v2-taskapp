@php use App\Enums\TaskStatus; @endphp
<div class="flex">
    <form action="{{ route('tasks.index') }}" method="GET"
          class="flex gap-1">
        <div class="flex items-center">
            <label for="status"
                   class="block font-medium text-sm text-gray-700 ">Filter Status:</label>
        </div>
        <div class="flex items-center">
            <select id="status" name="status"
                    class="text-sm font-medium text-gray-700 bg-white border border-gray-300  rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 ">
                <option value="">All</option>
                @foreach(TaskStatus::toSelectArray() as $key => $value)
                    <option
                        value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center">
            <button type="submit"
                    class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <i class="fal fa-filter"></i> Apply Filter
            </button>
        </div>
        <div class="flex items-center">
            <a href="{{ route('tasks.index') }}"
               data-tooltip-target="tooltip-refresh"
               class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <i class="fal fa-sync"></i>
            </a>
            <div id="tooltip-refresh" role="tooltip"
                 class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Reset / Clear
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>

        </div>
    </form>
</div>
