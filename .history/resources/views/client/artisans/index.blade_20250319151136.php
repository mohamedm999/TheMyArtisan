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
