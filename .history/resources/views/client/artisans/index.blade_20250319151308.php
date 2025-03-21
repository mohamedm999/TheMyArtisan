@extends('layouts.client')

@section('title', 'Find Artisans')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Find Talented Artisans</h1>
            <p class="text-muted">Browse through our selection of professional artisans for your projects</p>
        </div>
        <div class="col-md-4">
            <form action="{{ route('client.artisans.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search artisans..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="filters d-flex flex-wrap gap-2">
                <div class="dropdown me-2">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Filter by Category
                    </button>
                    <ul class="dropdown-menu">
                        @foreach($categories ?? [] as $category)
                            <li><a class="dropdown-item" href="{{ route('client.artisans.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="dropdown me-2">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Sort By
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('client.artisans.index', ['sort' => 'rating']) }}">Rating</a></li>
                        <li><a class="dropdown-item" href="{{ route('client.artisans.index', ['sort' => 'projects']) }}">Projects Completed</a></li>
                        <li><a class="dropdown-item" href="{{ route('client.artisans.index', ['sort' => 'newest']) }}">Newest</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($artisans ?? [] as $artisan)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="position-relative">
                        <img src="{{ $artisan->profile_image ?? asset('images/default-profile.jpg') }}"
                             alt="{{ $artisan->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @if($artisan->is_verified)
                            <span class="position-absolute badge bg-success" style="top: 10px; right: 10px;">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $artisan->name }}</h5>
                        <p class="card-text text-muted">{{ $artisan->specialty }}</p>

                        <div class="d-flex align-items-center mb-2">
                            <div class="ratings">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($artisan->average_rating ?? 0))
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="ms-2 text-muted">{{ $artisan->average_rating ?? 0 }} ({{ $artisan->reviews_count ?? 0 }} reviews)</span>
                        </div>

                        <p class="card-text"><small><i class="fas fa-map-marker-alt"></i> {{ $artisan->location ?? 'Location not specified' }}</small></p>
                        <p class="card-text"><small><i class="fas fa-briefcase"></i> {{ $artisan->completed_projects_count ?? 0 }} Projects Completed</small></p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('client.artisans.show', $artisan->id) }}" class="btn btn-primary w-100">View Profile</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No artisans found. Please try a different search or filter.
                </div>
            </div>
        @endforelse
    </div>

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            @if(method_exists($artisans, 'links'))
                {{ $artisans->links() }}
            @endif
        </div>
    </div>
</div>
@endsection
