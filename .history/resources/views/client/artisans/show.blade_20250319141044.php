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
                        <div class="mb-4 {{ !$loop->last ? 'pb-4 border-bottom' : '' }}">
                            <h5 class="mb-1">{{ $experience->position }}</h5>
                            <h6 class="mb-2">{{ $experience->company }}</h6>
                            <p class="mb-2 text-muted">
                                {{ date('M Y', strtotime($experience->start_date)) }} -
                                {{ $experience->end_date ? date('M Y', strtotime($experience->end_date)) : 'Present' }}
                            </p>
                            <p>{{ $experience->description }}</p>
                        </div>
                    @empty
                        <p class="text-muted">No work experience information available.</p>
                    @endforelse
                </div>
            </div>

            <!-- Portfolio/Gallery Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h3 class="mb-0">Portfolio</h3>
                </div>
                <div class="card-body">
                    @if($artisan->portfolioItems && count($artisan->portfolioItems) > 0)
                        <div class="row">
                            @foreach($artisan->portfolioItems as $item)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ asset('storage/'.$item->image) }}" class="card-img-top" alt="{{ $item->title }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item->title }}</h5>
                                            <p class="card-text small">{{ $item->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No portfolio items available.</p>
                    @endif
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Client Reviews</h3>
                </div>
                <div class="card-body">
                    @forelse($reviews as $review)
                        <div class="mb-4 {{ !$loop->last ? 'pb-4 border-bottom' : '' }}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $review->client->user->profile_photo ? asset('storage/'.$review->client->user->profile_photo) : asset('images/default-profile.jpg') }}"
                                         class="rounded-circle me-2" alt="{{ $review->client->user->name }}" width="40">
                                    <div>
                                        <h6 class="mb-0">{{ $review->client->user->name }}</h6>
                                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="mb-0">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <p class="text-muted">No reviews yet.</p>
                    @endforelse

                    @if(count($reviews) > 0 && $reviews->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Contact Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h3 class="mb-0">Contact</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-phone text-primary me-2"></i>
                        <a href="tel:{{ $artisan->phone_number }}">{{ $artisan->phone_number }}</a>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        <a href="mailto:{{ $artisan->user->email }}">{{ $artisan->user->email }}</a>
                    </div>
                    <hr>
                    <h5 class="mb-3">Send a Message</h5>
                    <form action="{{ route('client.messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="recipient_id" value="{{ $artisan->user->id }}">
                        <div class="mb-3">
                            <textarea class="form-control" name="content" rows="3" placeholder="Write your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Message</button>
                    </form>
                </div>
            </div>

            <!-- Availability Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h3 class="mb-0">Availability</h3>
                </div>
                <div class="card-body">
                    @if($artisan->availability && count($artisan->availability) > 0)
                        <ul class="list-group list-group-flush">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span>{{ $day }}</span>
                                    <span>
                                        @if(isset($artisan->availability[$day]) && $artisan->availability[$day]['available'])
                                            {{ $artisan->availability[$day]['start_time'] }} - {{ $artisan->availability[$day]['end_time'] }}
                                        @else
                                            <span class="text-muted">Not Available</span>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No availability information provided.</p>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('client.bookings.create', ['artisan' => $artisan->id]) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-calendar-alt me-2"></i>Check Full Schedule
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
