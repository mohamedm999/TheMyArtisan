@extends('layouts.client')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        padding: 40px 0;
        margin-bottom: 30px;
        border-radius: 0 0 20px 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .page-title {
        color: white;
        font-weight: 700;
        margin-bottom: 0;
    }
    .search-container {
        background: white;
        border-radius: 50px;
        padding: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .search-input {
        border: none;
        box-shadow: none;
        padding-left: 20px;
    }
    .search-input:focus {
        box-shadow: none;
    }
    .search-btn {
        border-radius: 50px;
        padding: 8px 25px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .filter-chip {
        border-radius: 50px;
        padding: 5px 15px;
        margin: 0 5px 10px 0;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.85rem;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
    }
    .filter-chip:hover, .filter-chip.active {
        background: #2575fc;
        color: white;
        border-color: #2575fc;
    }
    .artisan-card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: none;
        height: 100%;
    }
    .artisan-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 25px rgba(0,0,0,0.1) !important;
    }
    .card-header-bg {
        height: 80px;
        background: linear-gradient(45deg, #11998e, #38ef7d);
        position: relative;
    }
    .profile-img-wrapper {
        position: absolute;
        bottom: -50px;
        left: 50%;
        transform: translateX(-50%);
    }
    .profile-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .card-content {
        padding-top: 60px;
    }
    .name-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    .rating-container {
        margin-bottom: 15px;
    }
    .bio-text {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 20px;
        line-height: 1.5;
    }
    .section-title {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6c757d;
        margin-bottom: 10px;
        font-weight: 600;
    }
    .tag {
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 0.8rem;
        margin: 0 5px 5px 0;
        font-weight: 500;
        display: inline-block;
    }
    .service-tag {
        background-color: #e7f5ff;
        color: #1971c2;
    }
    .skill-tag {
        background-color: #f1f3f5;
        color: #495057;
    }
    .info-footer {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        border-top: 1px solid #f1f3f5;
        color: #6c757d;
        font-size: 0.85rem;
    }
    .info-item {
        display: flex;
        align-items: center;
    }
    .info-icon {
        margin-right: 6px;
    }
    .view-btn {
        width: 100%;
        border-radius: 30px;
        padding: 10px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
        transition: all 0.3s;
        background: linear-gradient(45deg, #11998e, #38ef7d);
        border: none;
    }
    .view-btn:hover {
        box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
        transform: translateY(-3px);
    }
    .pagination-container {
        margin-top: 40px;
    }
    .empty-state {
        text-align: center;
        padding: 60px 0;
        background: #f8f9fa;
        border-radius: 15px;
    }
    .empty-state-icon {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 20px;
    }
</style>

<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">Discover Talented Artisans</h1>
            </div>
            <div class="col-md-6">
                <form action="{{ route('client.artisans.index') }}" method="GET">
                    <div class="search-container d-flex">
                        <input type="text" name="search" class="form-control search-input" placeholder="Search by name, skill or service" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary search-btn">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="mb-4">
        <div class="d-flex flex-wrap">
            <div class="filter-chip active">All</div>
            <div class="filter-chip">Highest Rated</div>
            <div class="filter-chip">Most Experienced</div>
            <div class="filter-chip">Recently Added</div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($artisans as $artisan)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm artisan-card">
                    <div class="card-header-bg">
                        <div class="profile-img-wrapper">
                            <img src="{{ $artisan->profile_photo ? asset('storage/'.$artisan->profile_photo) : asset('images/default-profile.jpg') }}"
                                class="rounded-circle profile-img" alt="{{ $artisan->user->name }}">
                        </div>
                    </div>
                    <div class="card-body card-content">
                        <h5 class="text-center name-title">{{ $artisan->user->name }}</h5>
                        <div class="d-flex justify-content-center rating-container">
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
                            <span class="small text-muted">({{ $artisan->total_reviews }})</span>
                        </div>

                        <p class="bio-text text-center">{{ Str::limit($artisan->bio, 100) }}</p>

                        <div class="mb-3">
                            <h6 class="section-title">Services</h6>
                            <div>
                                @foreach($artisan->services->take(3) as $service)
                                    <span class="tag service-tag">{{ $service->name }}</span>
                                @endforeach
                                @if($artisan->services->count() > 3)
                                    <span class="badge bg-primary rounded-pill">+{{ $artisan->services->count() - 3 }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <h6 class="section-title">Skills</h6>
                            <div>
                                @if(is_array($artisan->skills))
                                    @foreach(array_slice($artisan->skills, 0, 4) as $skill)
                                        <span class="tag skill-tag">{{ $skill }}</span>
                                    @endforeach
                                    @if(count($artisan->skills) > 4)
                                        <span class="badge bg-secondary rounded-pill">+{{ count($artisan->skills) - 4 }}</span>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="info-footer">
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt info-icon"></i>
                                <span>{{ $artisan->city }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-briefcase info-icon"></i>
                                <span>{{ $artisan->years_experience }} yrs experience</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-3">
                        <a href="{{ route('client.artisans.show', $artisan->id) }}" class="btn btn-primary view-btn">View Profile</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4>No artisans found</h4>
                    <p class="text-muted">Try adjusting your search or check back later.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="pagination-container d-flex justify-content-center">
        <!-- Pagination links would go here if you have them -->
    </div>
</div>
@endsection
