@extends('layouts.client')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="fw-bold">Find Artisans</h1>
            <p class="text-muted">Discover skilled artisans for your next project</p>
        </div>
    </div>

    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Filter Artisans</h5>
                    <form action="{{ route('client.artisans.search') }}" method="GET">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" 
                                   value="{{ request('location') }}" placeholder="City or address">
                        </div>
                        
                        <div class="mb-3">
                            <label for="rating" class="form-label">Minimum Rating</label>
                            <select class="form-select" id="rating" name="rating">
                                <option value="">Any Rating</option>
                                <option value="5" {{ request('rating') == 5 ? 'selected' : '' }}>5 Stars</option>
                                <option value="4" {{ request('rating') == 4 ? 'selected' : '' }}>4+ Stars</option>
                                <option value="3" {{ request('rating') == 3 ? 'selected' : '' }}>3+ Stars</option>
                                <option value="2" {{ request('rating') == 2 ? 'selected' : '' }}>2+ Stars</option>
                                <option value="1" {{ request('rating') == 1 ? 'selected' : '' }}>1+ Stars</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="sort" class="form-label">Sort By</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Artisans List -->
        <div class="col-lg-9">
            <div class="row">
                @if($artisans->count() > 0)
                    @foreach($artisans as $artisan)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative">
                                    @if($artisan->profile_photo)
                                        <img src="{{ asset('storage/' . $artisan->profile_photo) }}" 
                                             class="card-img-top" alt="{{ $artisan->user->firstname ?? 'Artisan' }}"
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('images/default-profile.jpg') }}" 
                                             class="card-img-top" alt="Default Profile"
                                             style="height: 200px; object-fit: cover;">
                                    @endif
                                    
                                    @if($artisan->reviews->count() > 0)
                                        <div class="position-absolute top-0 end-0 bg-primary text-white px-2 py-1 m-2 rounded-pill">
                                            <i class="bi bi-star-fill me-1"></i>
                                            {{ number_format($artisan->reviews->avg('rating'), 1) }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="card-title">
                                        {{ $artisan->user->firstname ?? '' }} {{ $artisan->user->lastname ?? '' }}
                                    </h5>
                                    <p class="card-text text-muted mb-1">
                                        {{ $artisan->profession ?? 'Artisan' }}
                                    </p>
                                    <p class="small mb-2">
                                        <i class="bi bi-geo-alt"></i> 
                                        {{ $artisan->city ?? 'Location not specified' }}
                                    </p>
                                    
                                    @if($artisan->services->count() > 0)
                                        <p class="card-text fw-bold">
                                            From {{ $artisan->services->min('price') }} MAD
                                        </p>
                                    @endif
                                    
                                    <a href="{{ route('client.artisans.show', $artisan->id) }}" 
                                       class="btn btn-outline-primary w-100 mt-2">View Profile</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info">
                            No artisans found matching your criteria.
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $artisans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
