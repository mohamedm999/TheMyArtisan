@extends('layouts.client')

@section('title', 'Find Artisans')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Find Artisans</h1>

                    <!-- Search and Filter Section -->
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" id="search" placeholder="Search artisans..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Craft
                                    Category</label>
                                <select id="category"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <select id="location"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    <option value="">All Locations</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}">{{ $location }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Minimum
                                    Rating</label>
                                <select id="rating"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    <option value="">Any Rating</option>
                                    <option value="5">5 Stars</option>
                                    <option value="4">4+ Stars</option>
                                    <option value="3">3+ Stars</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="button" id="search-btn"
                                class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Search Artisans
                            </button>
                        </div>
                    </div>

                    <!-- Artisans Listing -->
                    <div id="artisans-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Artisan cards will be loaded here via JavaScript -->
                        <div id="loading" class="col-span-3 text-center py-8">
                            <i class="fas fa-spinner fa-spin text-green-500 text-2xl"></i>
                            <p class="mt-2 text-gray-600">Loading artisans...</p>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div id="pagination-container" class="mt-8 flex justify-center">
                        <!-- Pagination will be loaded here via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initial load of artisans
                fetchArtisans();

                // Event listener for search button
                document.getElementById('search-btn').addEventListener('click', function() {
                    fetchArtisans(1);
                });

                // Event listeners for enter key in search field
                document.getElementById('search').addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        fetchArtisans(1);
                    }
                });
            });

            // Function to fetch artisans data
            function fetchArtisans(page = 1) {
                const search = document.getElementById('search').value;
                const category = document.getElementById('category').value;
                const location = document.getElementById('location').value;
                const rating = document.getElementById('rating').value;

                // Show loading indicator
                document.getElementById('loading').style.display = 'block';
                document.getElementById('artisans-container').innerHTML = '<div id="loading" class="col-span-3 text-center py-8"><i class="fas fa-spinner fa-spin text-green-500 text-2xl"></i><p class="mt-2 text-gray-600">Loading artisans...</p></div>';

                // Build query string
                const params = new URLSearchParams();
                if (search) params.append('search', search);
                if (category) params.append('category', category);
                if (location) params.append('location', location);
                if (rating) params.append('rating', rating);
                params.append('page', page);

                // Fetch data from API
                fetch(`{{ route('api.artisans') }}?${params.toString()}`)
                    .then(response => response.json())
                    .then(data => {
                        renderArtisans(data.data);
                        renderPagination(data);
                    })
                    .catch(error => {
                        console.error('Error fetching artisans:', error);
                        document.getElementById('artisans-container').innerHTML = '<div class="col-span-3 text-center py-8"><p class="text-red-500">Error loading artisans. Please try again.</p></div>';
                    })
                    .finally(() => {
                        document.getElementById('loading').style.display = 'none';
                    });
            }

            // Function to render artisans cards
            function renderArtisans(artisans) {
                const container = document.getElementById('artisans-container');
                container.innerHTML = '';

                if (artisans.length === 0) {
                    container.innerHTML = '<div class="col-span-3 text-center py-8"><p class="text-gray-500">No artisans found matching your criteria.</p></div>';
                    return;
                }

                artisans.forEach(artisan => {
                    // Generate initials for avatar
                    const nameParts = artisan.user.name.split(' ');
                    const initials = nameParts.map(part => part.charAt(0).toUpperCase()).join('');

                    // Generate star rating HTML
                    let starsHtml = '';
                    const fullStars = Math.floor(artisan.rating);
                    const hasHalfStar = artisan.rating % 1 >= 0.5;

                    for (let i = 1; i <= 5; i++) {
                        if (i <= fullStars) {
                            starsHtml += '<i class="fas fa-star"></i>';
                        } else if (i === fullStars + 1 && hasHalfStar) {
                            starsHtml += '<i class="fas fa-star-half-alt"></i>';
                        } else {
                            starsHtml += '<i class="far fa-star"></i>';
                        }
                    }

                    // Create artisan card HTML
                    const artisanCard = document.createElement('div');
                    artisanCard.className = 'bg-white rounded-lg overflow-hidden shadow border border-gray-200 hover:shadow-lg transition-shadow';
                    artisanCard.innerHTML = `
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold mr-4">
                                    ${initials}
                                </div>
                                <div>
                                    <h3 class="font-medium">${artisan.user.name}</h3>
                                    <p class="text-sm text-gray-500">${artisan.category ? artisan.category.name : 'Artisan'}</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="flex text-amber-500 mb-1">
                                    ${starsHtml}
                                    <span class="ml-2 text-gray-600 text-sm">${artisan.rating.toFixed(1)} (${artisan.reviews_count || 0} reviews)</span>
                                </div>
                                <div class="text-sm text-gray-600 flex items-center">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i> ${artisan.city || 'Location not specified'}
                                </div>
                                <p class="mt-3 text-sm text-gray-600 line-clamp-2">${artisan.description || 'No description available.'}</p>
                            </div>
                            <div class="mt-4 flex justify-between items-center">
                                <button class="text-sm text-amber-600 hover:text-amber-800 flex items-center save-artisan" data-id="${artisan.id}">
                                    <i class="far fa-heart mr-1"></i> Save
                                </button>
                                <a href="{{ url('/artisans') }}/${artisan.id}" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">View Profile</a>
                            </div>
                        </div>
                    `;

                    container.appendChild(artisanCard);
                });

                // Add event listeners to save buttons
                document.querySelectorAll('.save-artisan').forEach(button => {
                    button.addEventListener('click', function() {
                        saveArtisan(this.getAttribute('data-id'));
                    });
                });
            }

            // Function to render pagination
            function renderPagination(paginationData) {
                const container = document.getElementById('pagination-container');
                container.innerHTML = '';

                if (paginationData.last_page <= 1) {
                    return;
                }

                // Create pagination nav
                const nav = document.createElement('nav');
                nav.className = 'relative z-0 inline-flex rounded-md shadow-sm -space-x-px';
                nav.setAttribute('aria-label', 'Pagination');

                // Previous button
                const prevLink = document.createElement('a');
                prevLink.href = '#';
                prevLink.className = 'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50';
                prevLink.innerHTML = '<span class="sr-only">Previous</span><i class="fas fa-chevron-left"></i>';
                if (paginationData.current_page > 1) {
                    prevLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        fetchArtisans(paginationData.current_page - 1);
                    });
                } else {
                    prevLink.classList.add('cursor-not-allowed', 'opacity-50');
                }
                nav.appendChild(prevLink);

                // Page links
                const maxVisiblePages = 5;
                let startPage = Math.max(1, paginationData.current_page - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(paginationData.last_page, startPage + maxVisiblePages - 1);

                // Adjust if we're near the end
                if (endPage - startPage + 1 < maxVisiblePages && startPage > 1) {
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }

                // Show first page if not already included
                if (startPage > 1) {
                    const pageLink = createPageLink(1, paginationData.current_page);
                    nav.appendChild(pageLink);

                    if (startPage > 2) {
                        const ellipsis = document.createElement('span');
                        ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
                        ellipsis.textContent = '...';
                        nav.appendChild(ellipsis);
                    }
                }

                // Page links
                for (let i = startPage; i <= endPage; i++) {
                    const pageLink = createPageLink(i, paginationData.current_page);
                    nav.appendChild(pageLink);
                }

                // Show last page if not already included
                if (endPage < paginationData.last_page) {
                    if (endPage < paginationData.last_page - 1) {
                        const ellipsis = document.createElement('span');
                        ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
                        ellipsis.textContent = '...';
                        nav.appendChild(ellipsis);
                    }

                    const pageLink = createPageLink(paginationData.last_page, paginationData.current_page);
                    nav.appendChild(pageLink);
                }

                // Next button
                const nextLink = document.createElement('a');
                nextLink.href = '#';
                nextLink.className = 'relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50';
                nextLink.innerHTML = '<span class="sr-only">Next</span><i class="fas fa-chevron-right"></i>';
                if (paginationData.current_page < paginationData.last_page) {
                    nextLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        fetchArtisans(paginationData.current_page + 1);
                    });
                } else {
                    nextLink.classList.add('cursor-not-allowed', 'opacity-50');
                }
                nav.appendChild(nextLink);

                container.appendChild(nav);
            }

            // Helper to create page link
            function createPageLink(pageNumber, currentPage) {
                const pageLink = document.createElement('a');
                pageLink.href = '#';
                pageLink.textContent = pageNumber;

                if (pageNumber === currentPage) {
                    pageLink.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-green-50 text-sm font-medium text-green-600 hover:bg-green-100';
                } else {
                    pageLink.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50';
                    pageLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        fetchArtisans(pageNumber);
                    });
                }

                return pageLink;
            }

            // Function to save/favorite an artisan
            function saveArtisan(artisanId) {
                fetch(`{{ url('/artisans') }}/${artisanId}/save`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the button to show saved state
                        const button = document.querySelector(`.save-artisan[data-id="${artisanId}"]`);
                        button.innerHTML = '<i class="fas fa-heart mr-1 text-red-500"></i> Saved';
                        button.disabled = true;
                    } else {
                        alert('You must be logged in to save artisans');
                    }
                })
                .catch(error => {
                    console.error('Error saving artisan:', error);
                });
            }
        </script>
    @endpush
@endsection
