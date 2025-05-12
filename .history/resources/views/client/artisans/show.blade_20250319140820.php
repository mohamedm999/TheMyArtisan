<!-- filepath: c:\wamp64\www\MyArtisan-platform\resources\views\client\artisans\show.blade.php -->
@extends('layouts.client')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('client.artisans.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Artisans
        </a>
    </div>

    <!-- Artisan Profile Header -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="{{ $artisan->profile_photo ? asset('storage/'.$artisan->profile_photo) : asset('images/default-profile.jpg') }}"
                        class="rounded-circle img-fluid mb-3" alt="{{ $artisan->user->name }}" style="max-width: 180px;">
                </div>
                <div class="col-md-9">
                    <h1 class="mb-1">{{ $artisan->user->name }}</h1>
                    <div class="d-flex align-items-center mb-3">
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
                        <span class="text-muted">({{ $artisan->total_reviews }} reviews)</span>
                    </div>

                    <div class="d-flex flex-wrap mb-3">
                        <div class="me-4">
                            <i class="fas fa-map-marker-alt text-secondary me-1"></i>
                            <span>{{ $artisan->city }}, {{ $artisan->state }}</span>
                        </div>
                        <div class="me-4">
                            <i class="fas fa-briefcase text-secondary me-1"></i>
                            <span>{{ $artisan->years_experience }} years experience</span>
                        </div>
                        <div>
                            <i class="fas fa-car text-secondary me-1"></i>
                            <span>{{ $artisan->service_radius }} km radius</span>
                        </div>
                    </div>

                    <p class="mb-3">{{ $artisan->bio }}</p>

                    <div>
                        <h5 class="mb-2">Skills</h5>
                        <div class="d-flex flex-wrap gap-1">
                            @if(is_array($artisan->skills))
                                @foreach($artisan->skills as $skill)
                                    <span class="badge bg-secondary">{{ $skill }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Services Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h3 class="mb-0">Services</h3>
                </div>
                <div class="card-body">
                    @forelse($artisan->services as $service)
                        <div class="d-flex justify-content-between align-items-start mb-4 {{ !$loop->last ? 'pb-4 border-bottom' : '' }}">
                            <div>
                                <h5 class="mb-1">{{ $service->name }}</h5>
                                <p class="mb-2 text-muted">{{ $service->description }}</p>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light text-dark me-2">{{ $service->duration }} mins</span>
                                    @if($service->category)
                                        <span class="badge bg-secondary">{{ $service->category->name }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                <h5 class="mb-2">${{ number_format($service->price, 2) }}</h5>
                                <a href="{{ route('client.bookings.create', ['service' => $service->id]) }}" class="btn btn-primary btn-sm">Book Now</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No services available from this artisan yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Work Experience Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h3 class="mb-0">Work Experience</h3>
                </div>
                <div class="card-body">
                    @forelse($artisan->workExperiences->sortByDesc('start_date') as $experience)
                        <div class="mb-4 {{ !$loop->last ? 'pb-4
