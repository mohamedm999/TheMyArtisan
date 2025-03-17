<!-- Add this somewhere prominent in the artisan profile -->
@if (isset($artisan->is_available))
    <div class="mb-4">
        @if ($artisan->is_available)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
                Available for Work
            </span>
        @else
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                <span class="w-2 h-2 mr-1 bg-gray-500 rounded-full"></span>
                Currently Unavailable
            </span>
        @endif
    </div>
@endif
