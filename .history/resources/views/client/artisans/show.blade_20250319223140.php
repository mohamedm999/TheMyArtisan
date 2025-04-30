@extends('layouts.client')

@section('title', $artisan->name . ' - Profile')

@section('content')
    <div class="container py-5">
        <!-- Artisan Header -->
        <div class="row mb-5">
            <div class="col-md-3">
                <div class="text-center mb-3">
                    @if ($artisan->profile_photo)
                        <img src="{{ asset('storage/' . $artisan->profile_photo) }}" alt="{{ $artisan->name }}"
                            class="img-fluid rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle d-flex justify-content-center align-items-center"
                            style="width: 200px; height: 200px; margin: 0 auto;">
                            <span class="display-4 text-white">{{ substr($artisan->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <h1 class="mb-2">{{ $artisan->name }}</h1>
                <div class="d-flex align-items-center mb-3">
                    <div class="ratings me-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <i
                                class="bi bi-star{{ $i <= $artisan->average_rating ? '-fill' : ($i - 0.5 <= $artisan->average_rating ? '-half' : '') }} text-warning"></i>
                        @endfor
                    </div>
                    <span>({{ $artisan->reviews_count }} reviews)</span>
                </div>
                <p class="mb-2"><i class="bi bi-geo-alt"></i> {{ $artisan->location }}</p>
                <p class="mb-2"><i class="bi bi-briefcase"></i> {{ $artisan->speciality }}</p>
                <p class="mb-2"><i class="bi bi-calendar-check"></i> Member since
                    {{ $artisan->created_at->format('M Y') }}</p>
                <div class="mt-4">
                    <a href="#contact" class="btn btn-primary">Contact Artisan</a>
                    <a href="#services" class="btn btn-outline-primary ms-2">View Services</a>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0">About {{ $artisan->name }}</h2>
                    </div>
                    <div class="card-body">
                        <p>{{ $artisan->bio }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="row mb-5" id="services">
            <div class="col-12">
                <h2 class="mb-4">Services Offered</h2>
                <div class="row">
                    @forelse($artisan->services ?? [] as $service)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                @if ($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top"
                                        alt="{{ $service->name }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $service->name }}</h5>
                                    <p class="card-text">{{ Str::limit($service->description, 100) }}</p>
                                    <p class="card-text text-primary fw-bold">{{ number_format($service->price, 2) }} DH
                                    </p>
                                    <a href="{{ route('client.services.show', $service->id) }}"
                                        class="btn btn-sm btn-outline-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">This artisan has not listed any services yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Portfolio Section -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-4">Portfolio</h2>
                <div class="row">
                    @forelse($artisan->portfolioItems ?? [] as $item)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top"
                                    alt="{{ $item->title }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->title }}</h5>
                                    <p class="card-text">{{ Str::limit($item->description, 100) }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">No portfolio items available.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-4">Reviews</h2>
                @forelse($artisan->reviews ?? [] as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <h5 class="mb-0">{{ $review->user->name }}</h5>
                                    <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                </div>
                                <div class="ratings">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="card-text">{{ $review->comment }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No reviews yet. Be the first to leave a review!</p>
                @endforelse
            </div>
        </div>

        <!-- Contact Section -->
        <div class="row" id="contact">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0">Contact {{ $artisan->name }}</h2>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Using the fixed route -->
                        <form action="{{ route('client.contact') }}" method="POST">
                            @csrf
                            <input type="hidden" name="artisan_id" value="{{ $artisan->id }}">

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    id="subject" name="subject" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5"
                                    required></textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
