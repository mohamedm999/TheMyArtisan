@extends('layouts.artisan')

@section('title', 'My Schedule')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-amber-800">My Schedule</h1>
                        <div class="flex space-x-2">
                            <button
                                class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700">
                                <i class="fas fa-plus mr-2"></i> Add Availability
                            </button>
                            <button
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-amber-700 uppercase tracking-widest hover:bg-gray-50">
                                <i class="fas fa-cog mr-2"></i> Settings
                            </button>
                        </div>
                    </div>

                    <!-- Calendar Navigation -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center space-x-2">
                            <button class="p-2 rounded-full hover:bg-gray-100">
                                <i class="fas fa-chevron-left text-gray-600"></i>
                            </button>
                            <h2 class="text-xl font-medium">November 2023</h2>
                            <button class="p-2 rounded-full hover:bg-gray-100">
                                <i class="fas fa-chevron-right text-gray-600"></i>
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 text-sm bg-amber-600 text-white rounded-md">Today</button>
                            <button class="px-3 py-1 text-sm border border-gray-300 rounded-md">Week</button>
                            <button class="px-3 py-1 text-sm border border-gray-300 rounded-md bg-gray-100">Month</button>
                        </div>
                    </div>

                    <!-- Calendar -->
                    <div class="bg-white border rounded-lg shadow">
                        <!-- Days of week header -->
                        <div class="grid grid-cols-7 gap-px bg-gray-200 border-b">
                            <div class="bg-gray-50 py-2 text-center text-sm font-medium text-gray-500">Sun</div>
                            <div class="bg-gray-50 py-2 text-center text-sm font-medium text-gray-500">Mon</div>
                            <div class="bg-gray-50 py-2 text-center text-sm font-medium text-gray-500">Tue</div>
                            <div class="bg-gray-50 py-2 text-center text-sm font-medium text-gray-500">Wed</div>
                            <div class="bg-gray-50 py-2 text-center text-sm font-medium text-gray-500">Thu</div>
                            <div class="bg-gray-50 py-2 text-center text-sm font-medium text-gray-500">Fri</div>
                            <div class="bg-gray-50 py-2 text-center text-sm font-medium text-gray-500">Sat</div>
                        </div>

                        <!-- Calendar grid -->
                        <div class="grid grid-cols-7 grid-rows-5 gap-px bg-gray-200">
                            <!-- Previous month days -->
                            <div class="bg-gray-50 min-h-[100px] p-2">
                                <div class="text-gray-400 text-sm">29</div>
                            </div>
                            <div class="bg-gray-50 min-h-[100px] p-2">
                                <div class="text-gray-400 text-sm">30</div>
                            </div>
                            <div class="bg-gray-50 min-h-[100px] p-2">
                                <div class="text-gray-400 text-sm">31</div>
                            </div>

                            <!-- Current month days (sample first week) -->
                            <div class="bg-white min-h-[100px] p-2">
                                <div class="text-gray-700 text-sm">1</div>
                            </div>
                            <div class="bg-white min-h-[100px] p-2">
                                <div class="text-gray-700 text-sm">2</div>
                                <div class="mt-1 text-xs bg-amber-100 text-amber-800 p-1 rounded">
                                    Available 9AM-5PM
                                </div>
                            </div>
                            <div class="bg-white min-h-[100px] p-2">
                                <div class="text-gray-700 text-sm">3</div>
                                <div class="mt-1 text-xs bg-amber-100 text-amber-800 p-1 rounded">
                                    Available 9AM-5PM
                                </div>
                            </div>
                            <div class="bg-white min-h-[100px] p-2">
                                <div class="text-gray-700 text-sm">4</div>
                            </div>

                            <!-- Sample calendar entries for week 2 -->
                            <div class="bg-white min-h-[100px] p-2">
                                <div class="text-gray-700 text-sm">5</div>
                            </div>
                            <div class="bg-white min-h-[100px] p-2">
                                <div class="text-gray-700 text-sm">6</div>
                                <div class="mt-1 text-xs bg-amber-100 text-amber-800 p-1 rounded">
                                    Available 9AM-5PM
                                </div>
                            </div>
                            <div class="bg-white min-h-[100px] p-2">
                                <div class="text-gray-700 text-sm">7</div>
                                <div class="mt-1 text-xs bg-amber-100 text-amber-800 p-1 rounded">
                                    Available 9AM-5PM
                                </div>
                            </div>
                            <div class="bg-white min-h-[100px] p-2">
                                <div class="text-gray-700 text-sm">8</div>
                                <div class="mt-1 text-xs bg-amber-100 text-amber-800 p-1 rounded">
                                    Available 9AM-5PM
                                </div>
                            </div>
                            <div class="bg-white min-h-[100px] p-2">
                                <div class="text-gray-700 text-sm">9</div>
                                <div class="mt-1 text-xs bg-amber-100 text-amber-800 p-1 rounded">
                                    Available 9AM-5PM
                                </div>
                            </div>
                            <div class="bg-white min-h-[100px] p-2">
                                <div class="text-gray-700 text-sm">10</div>
                                <div class="mt-1 text-xs bg-green-100 text-green-800 p-1 rounded">
                                    Booked: Chair Restoration
                                </div>
                            </div>
                            <div class="bg-white min-h-[100px] p-2">
                                <div class="text-gray-700 text-sm">11</div>
                            </div>

                            <!-- Additional calendar cells would continue for the rest of the month -->
                            <!-- ... showing only the key elements for brevity -->
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="mt-4 flex items-center space-x-6 text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-amber-100 rounded mr-2"></div>
                            <span>Available</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-100 rounded mr-2"></div>
                            <span>Booked</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-100 rounded mr-2"></div>
                            <span>Pending</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-100 rounded mr-2"></div>
                            <span>Unavailable</span>
                        </div>
                    </div>

                    <!-- Recurring Availability -->
                    <div class="mt-8">
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Default Weekly Availability</h2>
                        <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Day</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Hours</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Monday
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Available</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">9:00 AM - 5:00 PM</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button class="text-amber-600 hover:text-amber-900 mr-2"><i
                                                    class="fas fa-edit"></i></button>
                                        </td>
                                    </tr>
                                    <!-- Additional days would follow the same pattern -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
