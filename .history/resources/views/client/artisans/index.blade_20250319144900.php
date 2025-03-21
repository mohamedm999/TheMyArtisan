@extends('layouts.client')

@section('content')
    <style>
        .artisan-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 10px;
            overflow: hidden;
            border: none;
        }

        .artisan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .profile-img-container {
            position: relative;
            padding-top: 30px;
            padding-bottom: 20px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }

        .profile-img {
            border: 4px solid white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        .skill-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            background-color: #f8f9fa;
            color: #495057;
            border: 1px solid #e9ecef;
        }

        .service-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            background-color: #e7f5ff;
            color: #1971c2;
            border: 1px solid #d0ebff;
        }

        .info-icon {
            width: 20px;
            color: #6c757d;
        }

        .view-profile-btn {
            border-radius: 20px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .view-profile-btn:hover {
            transform: scale(1.05);
        }

        .rating-stars {
            font-size: 1.1rem;
        }
    </style>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Artisans Available</h1>
            <div>
                <form action="{{ route('client.artisans.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by name or skill"
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            @forelse($artisans as $artisan)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm artisan-card">
                        <div class="profile-img-container text-center">
                            <img src="{{ $artisan->profile_photo ? asset('storage/' . $artisan->profile_photo) : asset('images/default-profile.jpg') }}"
                                class="rounded-circle profile-img" alt="{{ $artisan->user->name }}" width="120"
                                height="120">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title text-center fw-bold mb-2">{{ $artisan->user->name }}</h4>
                            <div class="d-flex justify-content-center mb-3">
                                <div class="rating-stars text-warning me-2">
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
                                <span class="text-muted">({{ $artisan->total_reviews }})</span>
                            </div>

                            <p class="card-text text-center text-muted mb-4">{{ Str::limit($artisan->bio, 100) }}</p>

                            <div class="mb-4">
                                <h6 class="card-subtitle mb-2 fw-bold">Services:</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($artisan->services->take(3) as $service)
                                        <span class="service-badge">{{ $service->name }}</span>
                                    @endforeach
                                    @if ($artisan->services->count() > 3)
                                        <span class="badge bg-primary">+{{ $artisan->services->count() - 3 }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="card-subtitle mb-2 fw-bold">Skills:</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @if (is_array($artisan->skills))
                                        @foreach ($artisan->skills as $skill)
                                            <span class="skill-badge">{{ $skill }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-between border-top pt-3">
                                <div>
                                    <i class="fas fa-map-marker-alt info-icon me-1"></i>
                                    <span>{{ $artisan->city }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-briefcase info-icon me-1"></i>
                                    <span>{{ $artisan->years_experience }} yrs exp.</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 text-center py-3">
                            <a href="{{ route('client.artisans.show', $artisan->id) }}"
                                class="btn btn-primary view-profile-btn">View Profile</a>
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
