@extends('layouts.admin')

@section('title', 'Manage Certifications')
@section('description', 'View and manage artisan certifications')

@section('content')
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Certifications</h1>
                    <p class="mt-1 text-sm text-gray-500">Manage and verify artisan certifications</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.certifications.create') }}"
                        class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg shadow-sm text-sm font-medium transition-all focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <i class="fas fa-plus mr-2"></i>Add Certification
                    </a>
                </div>
            </div>
        </div>

        <div class="p-4">
            <div class="mb-4">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.certifications.index') }}"
                        class="px-3 py-1 text-xs rounded-full {{ !request('status') ? 'bg-primary-100 text-primary-800' : 'bg-gray-100 text-gray-800' }}">
                        All
                    </a>
                    <a href="{{ route('admin.certifications.index', ['status' => 'pending']) }}"
                        class="px-3 py-1 text-xs rounded-full {{ request('status') === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                        Pending
                    </a>
                    <a href="{{ route('admin.certifications.index', ['status' => 'verified']) }}"
                        class="px-3 py-1 text-xs rounded-full {{ request('status') === 'verified' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        Verified
                    </a>
                    <a href="{{ route('admin.certifications.index', ['status' => 'rejected']) }}"
                        class="px-3 py-1 text-xs rounded-full {{ request('status') === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                        Rejected
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-50 text-green-800 rounded-lg p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Artisan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Issuing Organization
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Issue Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($certifications as $certification)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $certification->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $certification->user->firstname }} {{ $certification->user->lastname }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $certification->issuing_organization }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $certification->issue_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($certification->verification_status === 'pending')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($certification->verification_status === 'verified')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Verified
                                        </span>
                                    @elseif($certification->verification_status === 'rejected')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center space-x-2">
                                        <a href="{{ route('admin.certifications.show', $certification->id) }}"
                                            class="text-primary-600 hover:text-primary-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.certifications.edit', $certification->id) }}"
                                            class="text-green-600 hover:text-green-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.certifications.destroy', $certification->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Are you sure you want to delete this certification?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No certifications found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $certifications->links() }}
            </div>
        </div>
    </div>
@endsection
