@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('admin.users.index') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Users
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">User Profile</h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    <i class="fas fa-trash-alt mr-2"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- User Avatar and Basic Info -->
                        <div class="md:col-span-1">
                            <div class="flex flex-col items-center p-6 bg-gray-50 rounded-lg">
                                <div class="w-32 h-32 mb-4">
                                    @php
                                        $profilePhoto = null;
                                        $hasArtisanRole = $user->roles->where('name', 'artisan')->count() > 0;
                                        $hasClientRole = $user->roles->where('name', 'client')->count() > 0;

                                        if ($hasArtisanRole && isset($user->artisanProfile) && $user->artisanProfile->profile_photo) {
                                            $profilePhoto = asset('storage/' . $user->artisanProfile->profile_photo);
                                        } elseif ($hasClientRole && isset($user->clientProfile) && $user->clientProfile->profile_photo) {
                                            $profilePhoto = asset('storage/' . $user->clientProfile->profile_photo);
                                        }
                                    @endphp

                                    @if ($profilePhoto)
                                        <img src="{{ $profilePhoto }}" alt="{{ $user->firstname }} {{ $user->lastname }}"
                                            class="w-full h-full rounded-full object-cover border-4 border-white shadow">
                                    @else
                                        <div
                                            class="w-full h-full rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center text-white text-4xl font-medium border-4 border-white shadow">
                                            {{ substr($user->firstname, 0, 1) }}{{ substr($user->lastname, 0, 1) }}
                                        </div>
                                    @endif
                                </div>

                                <h3 class="text-xl font-bold text-gray-800">{{ $user->firstname }} {{ $user->lastname }}</h3>
                                <p class="text-gray-600 mb-2">{{ $user->email }}</p>

                                <div class="mt-2">
                                    @foreach ($user->roles as $role)
                                        <span
                                            class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                            {{ $role->name == 'admin'
                                                ? 'bg-red-100 text-red-800'
                                                : ($role->name == 'artisan'
                                                    ? 'bg-amber-100 text-amber-800'
                                                    : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="mt-4 w-full">
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-500">User ID:</span>
                                        <span class="font-medium">{{ $user->id }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-500">Status:</span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">

                                <div class="mt-4 w-full">
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-500">User ID:</span>
                                        <span class="font-medium">{{ $user->id }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-500">Status:</span>
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-500">Joined:</span>
                                        <span>{{ $user->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <span class="text-gray-500">Last Updated:</span>
                                        <span>{{ $user->updated_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Details -->
                        <div class="md:col-span-2">
                            <div class="bg-white rounded-lg">
                                <div class="mb-6">
                                    <h4 class="text-lg font-medium border-b pb-2 mb-3">Personal Information</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm text-gray-500">First Name</label>
                                            <div class="font-medium">{{ $user->firstname }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-500">Last Name</label>
                                            <div class="font-medium">{{ $user->lastname }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-500">Email</label>
                                            <div class="font-medium">{{ $user->email }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-500">Phone</label>
                                            <div class="font-medium">{{ $user->phone ?? 'Not provided' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Specific Role Information -->
                                @if ($hasArtisanRole && isset($user->artisanProfile))
                                    <div class="mb-6">
                                        <h4 class="text-lg font-medium border-b pb-2 mb-3">Artisan Details</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm text-gray-500">Specialty</label>
                                                <div class="font-medium">
                                                    {{ $user->artisanProfile->specialty ?? 'Not specified' }}</div>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-500">Experience</label>
                                                <div class="font-medium">{{ $user->artisanProfile->experience ?? '0' }}
                                                    years</div>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-500">Status</label>
                                                <div class="font-medium">
                                                    @if (isset($user->artisanProfile->status))
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            {{ $user->artisanProfile->status == 'approved'
                                                                ? 'bg-green-100 text-green-800'
                                                                : ($user->artisanProfile->status == 'rejected'
                                                                    ? 'bg-red-100 text-red-800'
                                                                    : 'bg-yellow-100 text-yellow-800') }}">
                                                            {{ ucfirst($user->artisanProfile->status) }}
                                                        </span>
                                                    @else
                                                        Not available
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-500">Location</label>
                                                <div class="font-medium">
                                                    @if (isset($user->artisanProfile->city) || isset($user->artisanProfile->country))
                                                        {{ $user->artisanProfile->city ?? '' }}
                                                        {{ isset($user->artisanProfile->city) && isset($user->artisanProfile->country) ? ', ' : '' }}
                                                        {{ $user->artisanProfile->country ?? '' }}
                                                    @else
                                                        Not specified
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        @if (isset($user->artisanProfile->bio))
                                            <div class="mt-4">
                                                <label class="block text-sm text-gray-500">Bio</label>
                                                <div class="mt-1 text-gray-800">{{ $user->artisanProfile->bio }}</div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Services Section -->
                                    @if (isset($user->services) && count($user->services) > 0)
                                        <div class="mb-6">
                                            <h4 class="text-lg font-medium border-b pb-2 mb-3">Services Offered</h4>
                                            <div class="grid grid-cols-1 gap-4">
                                                @foreach ($user->services as $service)
                                                    <div class="border rounded-md p-3 bg-gray-50">
                                                        <div class="flex justify-between items-center mb-1">
                                                            <h5 class="font-medium">{{ $service->name }}</h5>
                                                            <span
                                                                class="font-medium text-gray-800">€{{ number_format($service->price, 2) }}</span>
                                                        </div>
                                                        <p class="text-sm text-gray-600">{{ $service->description }}</p>
                                                        <div class="mt-2">
                                                            <span class="text-xs px-2 py-1 bg-gray-200 rounded">
                                                                {{ $service->category->name ?? 'Uncategorized' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                @if ($hasClientRole && isset($user->clientProfile))
                                    <div class="mb-6">
                                        <h4 class="text-lg font-medium border-b pb-2 mb-3">Client Details</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm text-gray-500">Address</label>
                                                <div class="font-medium">
                                                    {{ $user->clientProfile->address ?? 'Not provided' }}</div>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-500">City</label>
                                                <div class="font-medium">{{ $user->clientProfile->city ?? 'Not provided' }}
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-500">Country</label>
                                                <div class="font-medium">
                                                    {{ $user->clientProfile->country ?? 'Not provided' }}</div>
                                            </div>
                                        </div>

                                        @if (isset($user->clientProfile->preferences))
                                            <div class="mt-4">
                                                <label class="block text-sm text-gray-500">Preferences</label>
                                                <div class="mt-1 text-gray-800">{{ $user->clientProfile->preferences }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Activity Section -->
                                <div class="mb-6">
                                    <h4 class="text-lg font-medium border-b pb-2 mb-3">Account Activity</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm text-gray-500">Last Login</label>
                                            <div class="font-medium">
                                                {{ isset($user->last_login_at) ? $user->last_login_at->format('M d, Y H:i') : 'Never logged in' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-500">Email Verified</label>
                                            <div class="font-medium">
                                                @if ($user->email_verified_at)
                                                    <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>
                                                        Verified on {{ $user->email_verified_at->format('M d, Y') }}</span>
                                                @else
                                                    <span class="text-red-600"><i class="fas fa-times-circle mr-1"></i>
                                                        Not verified</span>
                                                @endif
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
    </div>
@endsection
