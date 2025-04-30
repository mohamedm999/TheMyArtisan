@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
    <div class="container mx-auto px-4">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Add New Product</h1>
            <a href="{{ route('admin.store.products.index') }}" class="hidden md:inline-flex px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 shadow-sm">
                <i class="fas fa-arrow-left mr-1 text-white text-opacity-80"></i> Back to Products
            </a>
        </div>

        <div class="flex flex-wrap">
            <div class="w-full">
                <!-- Basic Card Example -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <h6 class="font-bold text-blue-600">Product Information</h6>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.store.products.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full md:w-2/3 px-3 mb-4">
                                    <div class="mb-4">
                                        <label for="name" class="block mb-1">Product Name <span class="text-red-600">*</span></label>
                                        <input type="text" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600 @error('name') border-red-500 @enderror"
                                            id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-full md:w-1/3 px-3 mb-4">
                                    <div class="mb-4">
                                        <label for="category" class="block mb-1">Category</label>
                                        <input type="text" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600 @error('category') border-red-500 @enderror"
                                            id="category" name="category" value="{{ old('category') }}"
                                            placeholder="e.g. Vouchers, Merchandise, etc.">
                                        @error('category')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block mb-1">Description <span class="text-red-600">*</span></label>
                                <textarea class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600 @error('description') border-red-500 @enderror" id="description" name="description"
                                    rows="5" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full md:w-1/2 px-3 mb-4">
                                    <div class="mb-4">
                                        <label for="points_cost" class="block mb-1">Points Cost <span class="text-red-600">*</span></label>
                                        <div class="flex">
                                            <input type="number"
                                                class="w-full px-3 py-2 border rounded-l focus:outline-none focus:ring-2 focus:ring-blue-600 @error('points_cost') border-red-500 @enderror"
                                                id="points_cost" name="points_cost" value="{{ old('points_cost') }}"
                                                min="1" required>
                                            <span class="px-3 py-2 bg-gray-100 border border-l-0 rounded-r">points</span>
                                        </div>
                                        @error('points_cost')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-full md:w-1/2 px-3 mb-4">
                                    <div class="mb-4">
                                        <label for="stock" class="block mb-1">Stock Quantity</label>
                                        <div class="flex">
                                            <input type="number" class="w-full px-3 py-2 border rounded-l focus:outline-none focus:ring-2 focus:ring-blue-600 @error('stock') border-red-500 @enderror"
                                                id="stock" name="stock" value="{{ old('stock', -1) }}"
                                                min="-1">
                                            <span class="px-3 py-2 bg-gray-100 border border-l-0 rounded-r">units</span>
                                        </div>
                                        <span class="text-sm text-gray-500">Use -1 for unlimited stock</span>
                                        @error('stock')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="block mb-1">Product Image</label>
                                <div class="relative">
                                    <input type="file" class="hidden" id="image" name="image"
                                        onchange="updateFileName(this)">
                                    <label for="image" class="w-full flex items-center px-3 py-2 border rounded text-gray-700 cursor-pointer hover:bg-gray-50">
                                        <span id="file-label" class="truncate">Choose file...</span>
                                    </label>
                                </div>
                                <span class="text-sm text-gray-500">Recommended size: 800x600 pixels (JPG, PNG)</span>
                                @error('image')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full md:w-1/2 px-3 mb-4">
                                    <div class="mb-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="is_available"
                                                name="is_available" {{ old('is_available') ? 'checked' : 'checked' }}>
                                            <span class="ml-2">Available for purchase</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="w-full md:w-1/2 px-3 mb-4">
                                    <div class="mb-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="is_featured"
                                                name="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                                            <span class="ml-2">Featured product</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 text-center">
                                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    <i class="fas fa-save mr-1"></i> Create Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function updateFileName(input) {
            const fileName = input.files[0]?.name || 'Choose file...';
            document.getElementById('file-label').textContent = fileName;
        }
    </script>
@endsection
