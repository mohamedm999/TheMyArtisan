@extends('layouts.client')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3 lg:w-1/2">
                <div class="mt-5 bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-red-600 text-white py-3 px-4 font-semibold">
                        Error {{ $code ?? 500 }}
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3">Oops! Something went wrong.</h3>
                        <p class="text-gray-700 mb-6">{{ $message ?? 'An unexpected error occurred. Please try again later.' }}</p>
                        <div class="mt-4">
                            <a href="{{ url('/') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                                Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
