@if ($artisans->count() > 0)
    <div class="mb-4 flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Found {{ $artisans->count() }} artisans matching your criteria
        </div>
    </div>

    <!-- Grid View -->
    <div id="grid-view" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($artisans as $artisan)
            <div
                class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition duration-300">
                <a href="{{ route('client.artisans.show', $artisan->id) }}" class="block">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                        @if ($artisan->profile_photo)
                            <img src="{{ asset('storage/' . $artisan->profile_photo) }}"
                                alt="{{ $artisan->user->firstname }}" class="object-cover w-full h-48">
                        @else
                            <div
                                class="w-full h-48 bg-gradient-to-r from-green-400 to-blue-500 flex justify-center items-center">
                                <span
                                    class="text-4xl font-bold text-white">{{ substr($artisan->user->firstname, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-5">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $artisan->user->firstname }}
                                {{ $artisan->user->lastname }}</h3>
                            @if ($artisan->is_featured)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="mr-1 h-2 w-2 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Featured
                                </span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-500 mb-3">{{ $artisan->profession ?? 'Artisan' }}</p>

                        <!-- Rating section -->
                        <div class="flex items-center mb-3">
                            <div class="flex items-center">
                                @if ($artisan->reviews->count() > 0)
                                    <span
                                        class="text-sm font-medium text-gray-900">{{ number_format($artisan->reviews->avg('rating') ?? 0, 1) }}</span>
                                    <div class="ml-1 flex">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= round($artisan->reviews->avg('rating') ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-1 text-sm text-gray-500">({{ $artisan->reviews->count() }})</span>
                                @else
                                    <span class="text-sm text-gray-500">No reviews yet</span>
                                @endif
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $artisan->city ?? 'Morocco' }}
                        </div>

                        <!-- Experience -->
                        @if ($artisan->years_experience)
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                </svg>
                                {{ $artisan->years_experience }}
                                {{ $artisan->years_experience == 1 ? 'year' : 'years' }} experience
                            </div>
                        @endif

                        <!-- Services -->
                        @if ($artisan->services->count() > 0)
                            <div class="flex flex-wrap gap-1 mt-3">
                                @foreach ($artisan->services->take(2) as $service)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ Str::limit($service->name, 15) }}
                                    </span>
                                @endforeach
                                @if ($artisan->services->count() > 2)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        +{{ $artisan->services->count() - 2 }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
                        <div class="text-sm font-medium text-green-600 hover:text-green-700 flex items-center">
                            View Profile
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- List View -->
    <div id="list-view" class="hidden">
        <div class="bg-white shadow rounded-md overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @foreach ($artisans as $artisan)
                    <li class="hover:bg-gray-50">
                        <a href="{{ route('client.artisans.show', $artisan->id) }}" class="block">
                            <div class="px-4 py-4 sm:px-6">
                                <!-- List view content -->
                                <div class="flex items-center">
                                    <!-- ... list content copied from main view ... -->
                                    <div
                                        class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-full overflow-hidden border border-gray-200">
                                        @if ($artisan->profile_photo)
                                            <img src="{{ asset('storage/' . $artisan->profile_photo) }}"
                                                alt="{{ $artisan->user->firstname }}"
                                                class="h-full w-full object-cover">
                                        @else
                                            <div
                                                class="h-full w-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center">
                                                <span
                                                    class="text-lg font-bold text-white">{{ substr($artisan->user->firstname, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4 flex-1">
                                        <!-- ... rest of list view content ... -->
                                        <div class="flex items-center justify-between">
                                            <!-- ... user details ... -->
                                            <div>
                                                <h3 class="text-base font-medium text-gray-900 flex items-center">
                                                    {{ $artisan->user->firstname }}
                                                    {{ $artisan->user->lastname }}
                                                    @if ($artisan->is_featured)
                                                        <span
                                                            class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <svg class="mr-0.5 h-2 w-2 text-green-500"
                                                                fill="currentColor" viewBox="0 0 8 8">
                                                                <circle cx="4" cy="4" r="3" />
                                                            </svg>
                                                            Featured
                                                        </span>
                                                    @endif
                                                </h3>
                                                <p class="text-sm text-gray-500">
                                                    {{ $artisan->profession ?? 'Artisan' }}</p>
                                            </div>
                                            <!-- ... ratings ... -->
                                            <div class="flex items-center">
                                                @if ($artisan->reviews->count() > 0)
                                                    <div class="flex items-center">
                                                        <span
                                                            class="text-sm font-medium text-gray-900">{{ number_format($artisan->reviews->avg('rating') ?? 0, 1) }}</span>
                                                        <div class="flex items-center ml-1">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <svg class="w-4 h-4 {{ $i <= round($artisan->reviews->avg('rating') ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                        <span
                                                            class="text-sm text-gray-500 ml-1">({{ $artisan->reviews->count() }})</span>
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-500">No reviews yet</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Location and experience -->
                                        <div class="mt-2 sm:flex sm:justify-between">
                                            <!-- ... location and experience ... -->
                                            <div class="sm:flex">
                                                <p class="flex items-center text-sm text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $artisan->city ?? 'Morocco' }}
                                                </p>
                                                @if ($artisan->years_experience)
                                                    <p
                                                        class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                                                clip-rule="evenodd" />
                                                            <path
                                                                d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                                        </svg>
                                                        {{ $artisan->years_experience }}
                                                        {{ $artisan->years_experience == 1 ? 'year' : 'years' }}
                                                        experience
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Services -->
                                            <div class="mt-2 flex items-center text-sm sm:mt-0">
                                                @if ($artisan->services->count() > 0)
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach ($artisan->services->take(2) as $service)
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ Str::limit($service->name, 15) }}
                                                            </span>
                                                        @endforeach
                                                        @if ($artisan->services->count() > 2)
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                +{{ $artisan->services->count() - 2 }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ml-4">
                                        <div class="text-green-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $artisans->links() }}
    </div>
@else
    <div class="bg-white rounded-lg shadow-sm p-8 text-center">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-50 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="text-xl font-medium text-gray-900">No artisans found</h3>
        <p class="mt-2 text-gray-500 max-w-md mx-auto">Try adjusting your search criteria or check back later
            as new artisans join our platform.</p>
        <div class="mt-6">
            <a href="{{ route('client.artisans.index') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Clear All Filters
            </a>
        </div>
    </div>
@endif
