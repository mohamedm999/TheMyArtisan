@extends('layouts.app')

@section('title', 'Page Not Found - MyArtisan')
@section('description', 'The page you are looking for could not be found on the MyArtisan platform.')

@section('content')
<div class="bg-white min-h-[70vh] flex items-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <div class="mb-8">
            <svg class="h-32 w-32 mx-auto text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <h1 class="text-5xl font-bold text-amber-800 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Page Not Found</h2>
        <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto">
            The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" class="px-6 py-3 bg-amber-600 text-white rounded-md shadow-md hover:bg-amber-700 transition-colors font-medium">
                Return to Homepage
            </a>
            <a href="{{ route('contact') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-md shadow-md hover:bg-gray-50 transition-colors font-medium">
                Contact Support
            </a>
        </div>

        <div class="mt-16">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">You might be looking for:</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('featured-artisans') }}" class="p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                    <i class="fas fa-user-circle text-amber-600 text-xl mb-2"></i>
                    <h4 class="font-medium text-gray-900">Featured Artisans</h4>
                </a>
                <a href="{{ route('crafts.index') }}" class="p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                    <i class="fas fa-paint-brush text-amber-600 text-xl mb-2"></i>
                    <h4 class="font-medium text-gray-900">Browse Crafts</h4>
                </a>
                <a href="{{ route('blog.index') }}" class="p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                    <i class="fas fa-book-open text-amber-600 text-xl mb-2"></i>
                    <h4 class="font-medium text-gray-900">Read Our Blog</h4>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
