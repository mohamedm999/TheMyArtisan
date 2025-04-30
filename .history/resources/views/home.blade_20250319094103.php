@extends('layouts.app')

@section('title', 'MyArtisan - Connecting with Authentic Moroccan Artisans')
@section('description', 'Discover and connect with skilled Moroccan artisans offering traditional crafts including
    zellige, carpet weaving, leatherwork, and more.')

@section('content')
    <!-- Hero Section -->
    @include('components.hero')

    <!-- Features Section (separate from hero) -->
    @include('components.features')

    <!-- Call to Action -->
    @include('components.cta')
@endsection
