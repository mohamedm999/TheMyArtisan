@extends('layouts.artisan')

@section('title', 'Manage Services')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-amber-800">My Services</h1>
                        <button type="button" onclick="toggleModal('addServiceModal')"
                            class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-900 focus:outline-none focus:border-amber-900 focus:ring ring-amber-300">
                            <i class="fas fa-plus mr-2"></i> Add New Service
                        </button>
                    </div>

                    @if (isset($services) && count($services) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($services as $service)
                                <div class="bg-white rounded-lg border border-gray-200 shadow-md overflow-hidden">
                                    <div class="h-48 bg-gray-200 relative">
                                        @if ($service->image)
                                            <img class="w-full h-full object-cover"
                                                src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <i class="fas fa-tools text-4xl"></i>
                                            </div>
                                        @endif
                                        <div class="absolute top-2 right-2 flex space-x-1">
                                            <button type="button"
                                                onclick="toggleModal('editServiceModal{{ $service->id }}')"
                                                class="bg-amber-100 text-amber-600 p-2 rounded-full hover:bg-amber-200">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('artisan.services.delete', $service->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-100 text-red-600 p-2 rounded-full hover:bg-red-200">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="p-5">
                                        <div class="flex justify-between items-start mb-2">
                                            <h5 class="text-lg font-semibold truncate">{{ $service->name }}</h5>
                                            <span
                                                class="bg-amber-100 text-amber-800 text-sm font-medium px-2.5 py-0.5 rounded">
                                                €{{ number_format($service->price, 2) }}
                                            </span>
                                        </div>
                                        <p class="mb-3 text-gray-600 line-clamp-3">{{ $service->description }}</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500">
                                                <i class="far fa-clock mr-1"></i> {{ $service->duration }} minutes
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                @if ($service->is_active)
                                                    <span class="text-green-600"><i class="fas fa-circle text-xs mr-1"></i>
                                                        Active</span>
                                                @else
                                                    <span class="text-gray-400"><i class="fas fa-circle text-xs mr-1"></i>
                                                        Inactive</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Service Modal -->
                                <div id="editServiceModal{{ $service->id }}"
                                    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                                    <div
                                        class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
                                        <div class="mt-3">
                                            <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">Edit Service</h3>
                                            <form action="{{ route('artisan.services.update', $service->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <!-- Form fields -->
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2"
                                                        for="edit_name{{ $service->id }}">
                                                        Service Name
                                                    </label>
                                                    <input
                                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                        id="edit_name{{ $service->id }}" name="name" type="text"
                                                        value="{{ $service->name }}" required>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2"
                                                        for="edit_description{{ $service->id }}">
                                                        Description
                                                    </label>
                                                    <textarea
                                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                        id="edit_description{{ $service->id }}" name="description" rows="3" required>{{ $service->description }}</textarea>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <label class="block text-gray-700 text-sm font-bold mb-2"
                                                            for="edit_price{{ $service->id }}">
                                                            Price (€)
                                                        </label>
                                                        <input
                                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                            id="edit_price{{ $service->id }}" name="price"
                                                            type="number" step="0.01" min="0"
                                                            value="{{ $service->price }}" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-gray-700 text-sm font-bold mb-2"
                                                            for="edit_duration{{ $service->id }}">
                                                            Duration (minutes)
                                                        </label>
                                                        <input
                                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                            id="edit_duration{{ $service->id }}" name="duration"
                                                            type="number" min="1" value="{{ $service->duration }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2"
                                                        for="edit_image{{ $service->id }}">
                                                        Service Image
                                                    </label>
                                                    <input type="file" id="edit_image{{ $service->id }}" name="image"
                                                        class="w-full text-sm text-gray-500
                                                        file:mr-4 file:py-2 file:px-4
                                                        file:rounded file:border-0
                                                        file:text-sm file:font-semibold
                                                        file:bg-amber-50 file:text-amber-700
                                                        hover:file:bg-amber-100">
                                                    <p class="text-xs text-gray-500 mt-1">Current image:
                                                        {{ $service->image ? basename($service->image) : 'No image' }}</p>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="flex items-center">
                                                        <input type="checkbox" name="is_active"
                                                            class="form-checkbox h-4 w-4 text-amber-600"
                                                            {{ $service->is_active ? 'checked' : '' }}>
                                                        <span class="ml-2 text-sm text-gray-700">Active (visible to
                                                            clients)</span>
                                                    </label>
                                                </div>
                                                <div class="flex justify-end space-x-3">
                                                    <button type="button"
                                                        onclick="toggleModal('editServiceModal{{ $service->id }}')"
                                                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700">
                                                        Save Changes
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 p-12 rounded-lg text-center">
                            <div class="text-amber-500 text-5xl mb-4">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 mb-2">No services yet</h3>
                            <p class="text-gray-500 mb-6">You haven't added any services yet. Add your first service to
                                start attracting clients.</p>
                            <button type="button" onclick="toggleModal('addServiceModal')"
                                class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700">
                                <i class="fas fa-plus mr-2"></i> Add Your First Service
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Service Modal -->
    <div id="addServiceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">Add New Service</h3>
                <form action="{{ route('artisan.services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Service Name
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" name="name" type="text" placeholder="e.g. Furniture Restoration"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Description
                        </label>
                        <textarea
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="description" name="description" rows="3" placeholder="Describe your service in detail..." required></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                                Price (€)
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="price" name="price" type="number" step="0.01" min="0"
                                placeholder="0.00" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="duration">
                                Duration (minutes)
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="duration" name="duration" type="number" min="1" placeholder="60" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                            Category
                        </label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="category" name="category_id" required>
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="image">
                            Service Image
                        </label>
                        <input type="file" id="image" name="image"
                            class="w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded file:border-0
                            file:text-sm file:font-semibold
                            file:bg-amber-50 file:text-amber-700
                            hover:file:bg-amber-100">
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" class="form-checkbox h-4 w-4 text-amber-600" checked>
                            <span class="ml-2 text-sm text-gray-700">Active (visible to clients)</span>
                        </label>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="toggleModal('addServiceModal')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700">
                            Add Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }
    </script>
@endsection
