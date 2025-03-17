@extends('layouts.client')

@section('title', 'My Bookings')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">My Bookings</h1>

                    <!-- Booking Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <a href="#"
                                class="border-green-500 text-green-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Upcoming
                            </a>
                            <a href="#"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Past
                            </a>
                            <a href="#"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Cancelled
                            </a>
                        </nav>
                    </div>

                    <!-- No Bookings Message -->
                    <div class="text-center py-12">
                        <div class="mx-auto h-24 w-24 text-gray-300 mb-4">
                            <i class="fas fa-calendar-times fa-4x"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No upcoming bookings</h3>
                        <p class="text-gray-500 max-w-sm mx-auto mb-6">You don't have any upcoming bookings with artisans.
                            Start exploring artisans and book their services.</p>
                        <a href="{{ route('client.find-artisans') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Find Artisans
                        </a>
                    </div>

                    <!-- Sample Booking Cards (hidden for demo) -->
                    <div class="hidden">
                        <!-- Sample Booking Card -->
                        <div class="bg-white rounded-lg overflow-hidden shadow border border-gray-200 mb-4">
                            <div class="p-4 md:p-6">
                                <div class="md:flex md:items-center md:justify-between">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-12 h-12 rounded-full bg-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold">
                                                AM</div>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900">Carpet Cleaning Service</h3>
                                            <p class="text-sm text-gray-500">with Ahmed Mansouri</p>
                                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                                <i class="far fa-calendar mr-1.5 text-gray-400"></i>
                                                <span>May 15, 2023 • 10:00 AM - 12:00 PM</span>
                                            </div>
                                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                                <i class="fas fa-map-marker-alt mr-1.5 text-gray-400"></i>
                                                <span>Your Home Address</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 md:mt-0 text-right flex flex-col items-end">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Confirmed
                                        </span>
                                        <span class="mt-2 text-sm text-gray-900 font-medium">800 MAD</span>
                                        <div class="mt-2">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Reschedule
                                            </button>
                                            <button type="button"
                                                class="ml-2 inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
