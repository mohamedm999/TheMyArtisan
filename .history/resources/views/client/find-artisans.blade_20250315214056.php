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
                        <form id="search-form">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                    <input type="text" id="search" name="search" placeholder="Search artisans..."
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Craft
                                        Category</label>
                                    <select id="category" name="category"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        <option value="">All Categories</option>
                                        <option value="pottery">Pottery & Ceramics</option>
                                        <option value="textiles">Textiles & Carpet</option>
                                        <option value="woodwork">Woodwork</option>
                                        <option value="leather">Leather</option>
                                        <option value="metal">Metalwork</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <select id="location" name="location"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        <option value="">All Locations</option>
                                        <option value="marrakech">Marrakech</option>
                                        <option value="fes">Fes</option>
                                        <option value="casablanca">Casablanca</option>
                                        <option value="rabat">Rabat</option>
                                        <option value="tangier">Tangier</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Minimum
                                        Rating</label>
                                    <select id="rating" name="rating"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        <option value="">Any Rating</option>
                                        <option value="5">5 Stars</option>
                                        <option value="4">4+ Stars</option>
                                        <option value="3">3+ Stars</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button type="submit" id="search-button"
                                    class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    Search Artisans
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="text-center py-8 hidden">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-green-500"></div>
                        <p class="mt-2 text-gray-600">Loading artisans...</p>
                    </div>

                    <!-- Artisans Listing -->
                    <div id="artisans-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Artisan cards will be inserted here via JavaScript -->
                    </div>

                    <!-- No Results Message -->
                    <div id="no-results" class="text-center py-8 hidden">
                        <p class="text-gray-600">No artisans found matching your criteria.</p>
                    </div>

                    <!-- Pagination -->
                    <div id="pagination-container" class="mt-8 flex justify-center">
                        <!-- Pagination will be inserted here via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Artisan Card Template -->
    <template id="artisan-card-template">
        <div class="bg-white rounded-lg overflow-hidden shadow border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold mr-4 artisan-initials">
                    </div>
                    <div>
                        <h3 class="font-medium artisan-name"></h3>
                        <p class="text-sm text-gray-500 artisan-speciality"></p>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="flex text-amber-500 mb-1 artisan-rating">
                    </div>
                    <div class="text-sm text-gray-600 flex items-center">
                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                        <span class="artisan-location"></span>
                    </div>
                    <p class="mt-3 text-sm text-gray-600 line-clamp-2 artisan-description"></p>
                </div>
                <div class="mt-4 flex justify-between items-center">
                    <button class="text-sm text-amber-600 hover:text-amber-800 flex items-center save-artisan">
                        <i class="far fa-heart mr-1"></i> Save
                    </button>
                    <a href="#" class="artisan-profile-link px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                        View Profile
                    </a>
                </div>
            </div>
        </div>
    </template>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initial load
            fetchArtisans(1);

            // Setup event listeners
            document.getElementById('search-form').addEventListener('submit', function(e) {
                e.preventDefault();
                fetchArtisans(1);
            });

            // Function to fetch artisans with AJAX
            function fetchArtisans(page) {
                // Show loading indicator
                document.getElementById('loading-indicator').classList.remove('hidden');
                document.getElementById('artisans-container').classList.add('hidden');
                document.getElementById('no-results').classList.add('hidden');

                // Get form data
                const form = document.getElementById('search-form');
                const formData = new FormData(form);
                formData.append('page', page);

                // Convert FormData to URL params
                const params = new URLSearchParams(formData);

                // Fetch API request
                fetch('/api/artisans?' + params.toString(), {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Hide loading indicator
                    document.getElementById('loading-indicator').classList.add('hidden');

                    // Process the results
                    if (data.artisans.data.length > 0) {
                        document.getElementById('artisans-container').classList.remove('hidden');
                        renderArtisans(data.artisans.data);
                        renderPagination(data.artisans);
                    } else {
                        document.getElementById('no-results').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error fetching artisans:', error);
                    document.getElementById('loading-indicator').classList.add('hidden');
                    alert('Failed to load artisans. Please try again later.');
                });
            }

            // Function to render artisan cards
            function renderArtisans(artisans) {
                const container = document.getElementById('artisans-container');
                container.innerHTML = '';

                const template = document.getElementById('artisan-card-template');

                artisans.forEach(artisan => {
                    const card = template.content.cloneNode(true);

                    // Set artisan initials
                    const nameParts = artisan.name.split(' ');
                    const initials = nameParts.length > 1
                        ? (nameParts[0][0] + nameParts[1][0])
                        : artisan.name.substring(0, 2);
                    card.querySelector('.artisan-initials').textContent = initials;

                    // Set other artisan details
                    card.querySelector('.artisan-name').textContent = artisan.name;
                    card.querySelector('.artisan-speciality').textContent = artisan.specialty;
                    card.querySelector('.artisan-location').textContent = artisan.location;
                    card.querySelector('.artisan-description').textContent = artisan.description;

                    // Generate star ratings
                    const ratingContainer = card.querySelector('.artisan-rating');
                    ratingContainer.innerHTML = generateStarRating(artisan.rating) +
                        `<span class="ml-2 text-gray-600 text-sm">${artisan.rating} (${artisan.reviews_count} reviews)</span>`;

                    // Set profile link
                    card.querySelector('.artisan-profile-link').href = `/artisans/${artisan.id}`;

                    // Add save functionality
                    card.querySelector('.save-artisan').addEventListener('click', function() {
                        saveArtisan(artisan.id);
                    });

                    container.appendChild(card);
                });
            }

            // Function to generate star rating HTML
            function generateStarRating(rating) {
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= Math.floor(rating)) {
                        stars += '<i class="fas fa-star"></i>';
                    } else if (i - 0.5 <= rating) {
                        stars += '<i class="fas fa-star-half-alt"></i>';
                    } else {
                        stars += '<i class="far fa-star"></i>';
                    }
                }
                return stars;
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
                fetch(`/api/save-artisan/${artisanId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Artisan saved to favorites!');
                    } else {
                        alert(data.message || 'Could not save artisan.');
                    }
                })
                .catch(error => {
                    console.error('Error saving artisan:', error);
                    alert('Failed to save artisan. Please try again.');
                });
            }
        });
    </script>
    @endpush
@endsection
