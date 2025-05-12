@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
    <div class="py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4 md:mb-0">
                    <i class="fas fa-folder-open mr-2 text-blue-600"></i>Categories Management
                </h2>
                <a href="{{ route('admin.categories.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow transition duration-150 ease-in-out">
                    <i class="fas fa-plus mr-2"></i> Add New Category
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm"
                    role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Image
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Parent
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Services
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($categories as $category)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $category->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($category->image)
                                            <img src="{{ asset('storage/categories/' . $category->image) }}"
                                                alt="{{ $category->name }}"
                                                class="h-12 w-12 rounded-lg object-cover border border-gray-200 shadow-sm">
                                        @else
                                            <div
                                                class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center shadow-inner">
                                                @if ($category->icon)
                                                    <i class="fas {{ $category->icon }} text-gray-500 text-lg"></i>
                                                @else
                                                    <i class="fas fa-folder text-gray-500 text-lg"></i>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($category->description, 30) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($category->parent)
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-level-up-alt mr-1 transform rotate-90"></i>
                                                {{ $category->parent->name }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">
                                                <i class="fas fa-minus mr-1"></i> None
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $category->services()->count() }} services
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-3 py-1.5 inline-flex items-center rounded-full text-xs font-medium
                                            {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            <span
                                                class="w-2 h-2 mr-1.5 rounded-full {{ $category->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
