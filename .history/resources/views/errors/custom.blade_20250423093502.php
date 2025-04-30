@extends('layouts.client')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3 lg:w-1/2">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-red-500 to-red-700 text-white py-4 px-6 flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span class="text-xl font-bold">Error {{ $code ?? 500 }}</span>
                    </div>

                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-4 text-gray-800">Oops! Something went wrong.</h3>
                        <p class="text-gray-600 mb-8 text-lg">
                            {{ $message ?? 'An unexpected error occurred. Please try again later.' }}
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <button onclick="window.history.back()"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Go Back
                            </button>

                            <a href="{{ route('home') }}"
                                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Home Page
                            </a>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
                            If this problem persists, please contact <a href="mailto:support@example.com" class="text-blue-600 hover:underline">support@example.com</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
