@extends('layouts.client')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Find Artisans</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.find-artisans.search') }}" method="GET">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">Service Category</label>
                                    <select class="form-control" id="category" name="category">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" id="location" name="location"
                                           placeholder="City or state...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="skill">Skill/Service Name</label>
                                    <input type="text" class="form-control" id="skill" name="skill"
                                           placeholder="Search by skill or service...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary px-5">Search</button>
                                <a href="{{ route('client.find-artisans.history') }}" class="btn btn-outline-secondary ml-2">
                                    <i class="fas fa-history"></i> Recent Searches
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4">
                <h5>Popular Categories</h5>
                <div class="row">
                    @foreach($categories->take(6) as $category)
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('client.find-artisans.search', ['category' => $category]) }}"
                               class="btn btn-outline-info btn-block">
                                {{ $category }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
