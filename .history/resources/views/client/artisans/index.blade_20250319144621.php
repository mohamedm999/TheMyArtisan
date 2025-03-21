
@extends('layouts.client')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Artisans Available</h1>
        <div>
            <form action="{{ route('client.artisans.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by name or skill" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($artisans as $artisan)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="text-center pt-3">
                        <img src="{{ $artisan->profile_photo ? asset('storage/'.$artisan->profile_photo) : asset('images/default-profile.jpg') }}"
                            class="rounded-circle" alt="{{ $artisan->user->name }}" width="100" height="100">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">{{ $artisan->user->name }}</h5>
                        <div class="d-flex justify-content-center mb-2">
                            <div class="text-warning me-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $artisan->average_rating)
                                        <i class="fas fa-star"></i>
                                    @elseif ($i - 0.5 <= $artisan->average_rating)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-muted small">({{ $artisan->total_reviews }})</span>
                        </div>

                        <p class="card-text text-center mb-3">{{ Str::limit($artisan->bio, 100) }}</p>

                        <div class="mb-3">
                            <h6 class="card-subtitle mb-2 text-muted">Services:</h6>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($artisan->services->take(3) as $service)
                                    <span class="badge bg-light text-dark">{{ $service->name }}</span>
                                @endforeach
                                @if($artisan->services->count() > 3)
                                    <span class="badge bg-primary">+{{ $artisan->services->count() - 3 }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <h6 class="card-subtitle mb-2 text-muted">Skills:</h6>
                            <div class="d-flex flex-wrap gap-1">
                                @if(is_array($artisan->skills))
                                    @foreach($artisan->skills as $skill)
                                        <span class="badge bg-light text-dark">{{ $skill }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <i class="fas fa-map-marker-alt text-secondary"></i>
                                <span class="small">{{ $artisan->city }}</span>
                            </div>
                            <div>
                                <i class="fas fa-briefcase text-secondary"></i>
                                <span class="small">{{ $artisan->years_experience }} yrs exp.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-center">
                        <a href="{{ route('client.artisans.show', $artisan->id) }}" class="btn btn-primary">View Profile</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No artisans found at the moment. Please check back later.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
