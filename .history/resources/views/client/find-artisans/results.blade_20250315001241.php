@extends('layouts.client')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <a href="{{ route('client.find-artisans') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Search
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Search Results</h4>
                    <span class="badge badge-primary">{{ $artisans->total() }} artisans found</span>
                </div>
                <div class="card-body">
                    @if($artisans->count() > 0)
                        <div class="row">
                            @foreach($artisans as $artisan)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <img src="{{ $artisan->artisanProfile && $artisan->artisanProfile->profile_photo
                                                    ? asset('storage/' . $artisan->artisanProfile->profile_photo)
                                                    : asset('img/default-avatar.png') }}"
                                                    class="img-fluid rounded-start" alt="{{ $artisan->firstname }} {{ $artisan->lastname }}">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $artisan->firstname }} {{ $artisan->lastname }}</h5>
                                                    @if($artisan->artisanProfile)
                                                        <p class="card-text">
                                                            <small>
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                {{ $artisan->artisanProfile->city ?? 'No location specified' }}
                                                                {{ $artisan->artisanProfile->state ? ', '.$artisan->artisanProfile->state : '' }}
                                                            </small>
                                                        </p>
                                                        <p class="card-text">
                                                            {{ Str::limit($artisan->artisanProfile->bio, 100) ?? 'No bio available' }}
                                                        </p>
                                                    @else
                                                        <p class="card-text">No profile information available.</p>
                                                    @endif
                                                    <a href="{{ route('client.find-artisans.view', $artisan->id) }}" class="btn btn-primary btn-sm">
                                                        View Profile
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $artisans->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5>No artisans found matching your criteria</h5>
                            <p>Try adjusting your search filters or search terms.</p>
                            <a href="{{ route('client.find-artisans') }}" class="btn btn-primary">Reset Search</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
