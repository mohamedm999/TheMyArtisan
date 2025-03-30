@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
        <div class="flex items-center mb-4">
            <div class="bg-green-100 rounded-full p-3 mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-xl font-semibold">Role Assignment Utility</h2>
        </div>

        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-6">
            <p>{{ $status }}</p>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-medium mb-2">User Details</h3>
            <div class="bg-gray-50 p-4 rounded">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Name:</strong> {{ $user->firstname }} {{ $user->lastname }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Direct role attribute:</strong> {{ $user->role ?? 'Not set' }}</p>
                <p><strong>Assigned roles:</strong> {{ implode(', ', $user->roles->pluck('name')->toArray()) ?: 'None' }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex justify-between">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-800 focus:outline-none focus:border-amber-800 focus:shadow-outline-amber transition ease-in-out duration-150">
                    Go to Admin Dashboard
                </a>
                <a href="/" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:shadow-outline-gray transition ease-in-out duration-150">
                    Return to Home
                </a>
            </div>

            <div class="mt-8 border-t pt-4 text-sm text-gray-500">
                <p>Note: This is a utility page for administrator role assignment. For security reasons, you should remove this route after using it.</p>
            </div>
        </div>
    </div>
</div>
@endsection
