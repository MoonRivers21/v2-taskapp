<div class="p-3">
    @if(request('status'))
        <span
            class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded  border border-blue-400">Filtered status by: {{request('status')}}</span>
    @endif
    @if(request('sort') == 'title')
        <span
            class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded  border border-green-400">Sorted title by: {{request('order') === 'asc' ? 'A-Z' : 'Z-A'}}</span>
    @endif
    @if(request('sort') == 'created_at')
        <span
            class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded  border border-green-400">Sorted date by: {{request('order') === 'asc' ? 'ascending' : 'descending'}}</span>
    @endif
    @if(!empty(request('search')))
        <span
            class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded  border border-blue-400">Searching: <span
                class="font-extrabold"> {{request('search')}}</span></span>
    @endif

</div>
