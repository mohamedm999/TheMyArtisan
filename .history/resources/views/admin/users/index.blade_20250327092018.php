@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
                    <p class="mt-1 text-sm text-gray-600">Manage all platform users from one place</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 active:bg-primary-800 focus:outline-none focus:border-primary-800 focus:ring focus:ring-primary-200 transition ease-in-out duration-150">
                    <i class="fas fa-plus mr-2"></i> Add New User
                </a>
            </div>

            <!-- Notification -->
            @if (session('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 border-l-4 border-green-500">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button onclick="this.parentElement.parentElement.parentElement.remove()"
                                    class="inline-flex text-green-500 focus:outline-none focus:text-green-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filters Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900">Search & Filters</h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.users.index') }}"
                        class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    class="focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Name or email">
                            </div>
                        </div>

                        <div class="w-full md:w-48">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <select name="role" id="role"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                                <option value="">All Roles</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="artisan" {{ request('role') == 'artisan' ? 'selected' : '' }}>Artisan
                                </option>
                                <option value="client" {{ request('role') == 'client' ? 'selected' : '' }}>Client</option>
                            </select>
                        </div>

                        <div class="w-full md:w-48">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                                <option value="">Any Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>

                        <div class="flex space-x-3">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <i class="fas fa-search mr-2"></i> Search
                            </button>
                            <a href="{{ route('admin.users.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <i class="fas fa-undo mr-2"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users Table Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">All Users</h3>
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                        {{ $users->total() }} Users
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        User
                                        <a href="#" class="ml-1 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-sort"></i>
                                        </a>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        Role
                                        <a href="#" class="ml-1 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-sort"></i>
                                        </a>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        Status
                                        <a href="#" class="ml-1 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-sort"></i>
                                        </a>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        Registered
                                        <a href="#" class="ml-1 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-sort"></i>
                                        </a>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if (isset($user->profile_photo_url))
                                                    <img class="h-10 w-10 rounded-full object-cover border border-gray-200"
                                                        src="{{ $user->profile_photo_url }}"
                                                        alt="{{ $user->firstname }}">
                                                @else
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center text-white font-medium">
                                                        {{ substr($user->firstname, 0, 1) }}{{ substr($user->lastname, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $user->firstname }} {{ $user->lastname }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-0.5">
                                                    ID: {{ $user->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                        @if ($user->phone)
                                            <div class="text-xs text-gray-500">{{ $user->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @foreach ($user->roles as $role)
                                            <span
                                                class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full
                                                {{ $role->name == 'admin'
                                                    ? 'bg-red-100 text-red-800'
                                                    : ($role->name == 'artisan'
                                                        ? 'bg-amber-100 text-amber-800'
                                                        : 'bg-green-100 text-green-800') }}">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ isset($user->email_verified_at) ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            <span
                                                class="h-2 w-2 rounded-full
                                                {{ isset($user->email_verified_at) ? 'bg-green-500' : 'bg-yellow-500' }} mr-1.5"></span>
                                            {{ isset($user->email_verified_at) ? 'Active' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $user->created_at->format('h:i A') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.users.show', $user) }}"
                                                class="inline-flex items-center p-1.5 text-blue-600 hover:text-blue-900 rounded-md hover:bg-blue-50"
                                                title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="inline-flex items-center p-1.5 text-indigo-600 hover:text-indigo-900 rounded-md hover:bg-indigo-50"
                                                title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" onclick="confirmDelete('{{ $user->id }}')"
                                                class="inline-flex items-center p-1.5 text-red-600 hover:text-red-900 rounded-md hover:bg-red-50"
                                                title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <form id="delete-form-{{ $user->id }}" method="POST"
                                                action="{{ route('admin.users.destroy', $user) }}" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <p class="mt-2 text-gray-500 font-medium">No users found</p>
                                            <p class="text-sm text-gray-400">Try adjusting your search or filter to find
                                                what you're looking for.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Script -->
    <script>
        function confirmDelete(userId) {
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                document.getElementById('delete-form-' + userId).submit();
            }
        }
    </script>
@endsection
