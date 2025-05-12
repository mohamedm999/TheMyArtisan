@extends('layouts.artisan')

@section('title', 'My Schedule')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Error and Success Messages -->
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Improved Debug Info - Remove in production -->
            @if (config('app.debug'))
                <div class="mb-4 p-4 bg-gray-100 rounded text-sm">
                    <p><strong>User ID:</strong> {{ Auth::id() }}</p>
                    @php
                        $artisanProfile = App\Models\ArtisanProfile::where('user_id', Auth::id())->first();
                        $availabilityCount = $artisanProfile
                            ? App\Models\Availability::where('artisan_profiles_id', $artisanProfile->id)->count()
                            : 0;
                        $userAvailabilityCount = App\Models\Availability::where('user_id', Auth::id())->count();
                    @endphp
                    <p><strong>Artisan Profile ID:</strong> {{ $artisanProfile ? $artisanProfile->id : 'None' }}</p>
                    <p><strong>Availabilities by Profile:</strong> {{ $availabilityCount }}</p>
                    <p><strong>Availabilities by User ID:</strong> {{ $userAvailabilityCount }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-amber-800">My Schedule</h1>
                        <button id="addAvailabilityBtn"
                            class="px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700 focus:outline-none">
                            <i class="fas fa-plus mr-2"></i> Add Availability
                        </button>
                    </div>

                    <!-- Schedule options -->
                    <div class="flex mb-6 space-x-4">
                        <div class="w-1/2">
                            <label for="month" class="block text-sm font-medium text-gray-700 mb-1">View Month</label>
                            <select id="month"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                <option value="1" {{ date('n') == 1 ? 'selected' : '' }}>January</option>
                                <option value="2" {{ date('n') == 2 ? 'selected' : '' }}>February</option>
                                <option value="3" {{ date('n') == 3 ? 'selected' : '' }}>March</option>
                                <option value="4" {{ date('n') == 4 ? 'selected' : '' }}>April</option>
                                <option value="5" {{ date('n') == 5 ? 'selected' : '' }}>May</option>
                                <option value="6" {{ date('n') == 6 ? 'selected' : '' }}>June</option>
                                <option value="7" {{ date('n') == 7 ? 'selected' : '' }}>July</option>
                                <option value="8" {{ date('n') == 8 ? 'selected' : '' }}>August</option>
                                <option value="9" {{ date('n') == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ date('n') == 10 ? 'selected' : '' }}>October</option>
                                <option value="11" {{ date('n') == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ date('n') == 12 ? 'selected' : '' }}>December</option>
                            </select>
                        </div>

                        <div class="w-1/2">
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                            <select id="year"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                @for ($i = date('Y'); $i <= date('Y') + 2; $i++)
                                    <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="flex space-x-6 mb-4">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-100 border border-green-400 rounded-sm mr-2"></div>
                            <span class="text-sm text-gray-600">Available</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-100 border border-blue-400 rounded-sm mr-2"></div>
                            <span class="text-sm text-gray-600">Booked</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-100 border border-red-400 rounded-sm mr-2"></div>
                            <span class="text-sm text-gray-600">Unavailable</span>
                        </div>
                    </div>

                    <!-- Calendar -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="grid grid-cols-7 gap-px bg-gray-200">
                            <div class="bg-gray-100 py-2 text-center text-sm font-medium text-gray-500">Sun</div>
                            <div class="bg-gray-100 py-2 text-center text-sm font-medium text-gray-500">Mon</div>
                            <div class="bg-gray-100 py-2 text-center text-sm font-medium text-gray-500">Tue</div>
                            <div class="bg-gray-100 py-2 text-center text-sm font-medium text-gray-500">Wed</div>
                            <div class="bg-gray-100 py-2 text-center text-sm font-medium text-gray-500">Thu</div>
                            <div class="bg-gray-100 py-2 text-center text-sm font-medium text-gray-500">Fri</div>
                            <div class="bg-gray-100 py-2 text-center text-sm font-medium text-gray-500">Sat</div>
                        </div>

                        <!-- Calendar days -->
                        <div class="grid grid-cols-7 gap-px bg-gray-200">
                            @foreach ($calendarDays as $day)
                                <div class="min-h-[100px] bg-white p-2 {{ $day['today'] ? 'bg-amber-50' : '' }} {{ !$day['current_month'] ? 'bg-gray-50 text-gray-400' : '' }}"
                                    data-date="{{ $day['date'] }}">
                                    <div class="flex justify-between mb-1">
                                        <span
                                            class="text-sm {{ $day['today'] ? 'font-bold text-amber-600' : '' }}">{{ $day['day'] }}</span>
                                        @if ($day['current_month'])
                                            <button
                                                class="text-xs text-gray-500 hover:text-amber-600 focus:outline-none add-availability-btn"
                                                data-date="{{ $day['date'] }}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Time slots -->
                                    <div class="space-y-1">
                                        @if (isset($day['availabilities']) && count($day['availabilities']) > 0)
                                            @foreach ($day['availabilities'] as $availability)
                                                <div
                                                    class="text-xs p-1 rounded {{ $availability['status'] == 'available' ? 'bg-green-100 text-green-800' : ($availability['status'] == 'booked' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ $availability['start_time'] }} - {{ $availability['end_time'] }}
                                                    @if ($availability['status'] == 'available')
                                                        <button
                                                            class="float-right text-green-600 hover:text-green-800 delete-availability"
                                                            data-id="{{ $availability['id'] }}">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-xs text-gray-400">No availabilities</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Availability Modal -->
    <div id="availabilityModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full"
        aria-modal="true">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add Availability</h3>
                <form id="availabilityForm" action="{{ route('artisan.schedule.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="date" id="selectedDate">

                    <div class="mb-4">
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                        <input type="time" id="start_time" name="start_time" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                        <input type="time" id="end_time" name="end_time" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Repeat</label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="repeat" value="none" class="form-radio" checked>
                                <span class="ml-2">None</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="repeat" value="weekly" class="form-radio">
                                <span class="ml-2">Weekly</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4" id="repeatUntilField" style="display: none;">
                        <label for="repeat_until" class="block text-sm font-medium text-gray-700 mb-1">Repeat
                            Until</label>
                        <input type="date" id="repeat_until" name="repeat_until"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                    </div>

                    <div class="flex justify-end space-x-3 mt-5">
                        <button type="button" id="cancelAvailability"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 focus:outline-none">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-amber-600 text-white rounded-md text-sm hover:bg-amber-700 focus:outline-none">
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('availabilityModal');
            const addBtn = document.getElementById('addAvailabilityBtn');
            const cancelBtn = document.getElementById('cancelAvailability');
            const selectedDateInput = document.getElementById('selectedDate');
            const repeatRadios = document.querySelectorAll('input[name="repeat"]');
            const repeatUntilField = document.getElementById('repeatUntilField');
            const monthSelect = document.getElementById('month');
            const yearSelect = document.getElementById('year');

            // Add event listeners for all "+" buttons in the calendar
            document.querySelectorAll('.add-availability-btn').forEach(button => {
                button.addEventListener('click', function() {
                    selectedDateInput.value = this.getAttribute('data-date');
                    modal.classList.remove('hidden');
                });
            });

            // Main add availability button
            addBtn.addEventListener('click', function() {
                const today = new Date().toISOString().split('T')[0];
                selectedDateInput.value = today;
                modal.classList.remove('hidden');
            });

            // Cancel button
            cancelBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            // Show/hide repeat until field based on repeat option
            repeatRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'weekly') {
                        repeatUntilField.style.display = 'block';
                    } else {
                        repeatUntilField.style.display = 'none';
                    }
                });
            });

            // Handle month/year change to reload the calendar
            function reloadCalendar() {
                const month = monthSelect.value;
                const year = yearSelect.value;
                window.location.href = `{{ route('artisan.schedule') }}?month=${month}&year=${year}`;
            }

            monthSelect.addEventListener('change', reloadCalendar);
            yearSelect.addEventListener('change', reloadCalendar);

            // Delete availability with improved error handling
            document.querySelectorAll('.delete-availability').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (confirm('Are you sure you want to delete this availability?')) {
                        const id = this.getAttribute('data-id');
                        const button = this; // Store reference to button

                        fetch(`{{ route('artisan.schedule.destroy', '') }}/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    // Success - remove the item or reload for consistency
                                    window.location.reload();
                                } else if (data.message) {
                                    // Error with message
                                    alert(data.message);
                                } else {
                                    alert('Error deleting availability');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error processing request. Please try again.');
                            });
                    }
                });
            });
        });
    </script>
@endsection
