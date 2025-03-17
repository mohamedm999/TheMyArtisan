@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Find Artisans</h1>

    <div class="card mb-4">
        <div class="card-header">Search Filters</div>
        <div class="card-body">
            <form id="artisan-search-form" action="{{ route('client.find-artisans.search') }}" method="GET">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="category-filter">Category</label>
                        <select id="category-filter" name="category" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="location-filter">Location</label>
                        <input type="text" id="location-filter" name="location" class="form-control" placeholder="City or State">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="skill-filter">Skill or Service</label>
                        <input type="text" id="skill-filter" name="skill" class="form-control" placeholder="Enter skill or service name">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Results <span class="badge bg-secondary" id="artisans-count">{{ $artisans->total() }}</span></h2>
        <a href="{{ route('client.find-artisans.history') }}" class="btn btn-outline-secondary">
            <i class="fas fa-history"></i> Search History
        </a>
    </div>

    <div id="results-container">
        @include('client.find-artisans.partials.artisans-list', ['artisans' => $artisans])
    </div>

    <div id="pagination-container" class="d-flex justify-content-center mt-4">
        {{ $artisans->links() }}
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/find-artisans.js') }}"></script>
@endpush
@endsection
