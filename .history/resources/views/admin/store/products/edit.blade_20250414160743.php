@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="container max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-800 dark:text-gray-200">
            Edit Product: {{ $product->name }}
        </h2>

        @if ($errors->any())
            <div class="mb-6">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <strong class="font-medium">Error!</strong>
                        <span class="ml-1">Please check the form for errors.</span>
                    </div>
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Product Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="points_cost" class="block mb-2 text-sm font-medium text-gray-900">Points Cost</label>
                        <input type="number" id="points_cost" name="points_cost"
                            value="{{ old('points_cost', $product->points_cost) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required min="1">
                    </div>
                    <div>
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                        <input type="text" id="category" name="category"
                            value="{{ old('category', $product->category) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            list="category-options">
                        <datalist id="category-options">
                            @foreach ($categories as $category)
                                <option value="{{ $category }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label for="stock" class="block mb-2 text-sm font-medium text-gray-900">Stock (-1 for
                            unlimited)</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required min="-1">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required>{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="mb-6">
                    @if ($product->image)
                        <div class="mb-3">
                            <p class="mb-2 text-sm font-medium text-gray-900">Current Image:</p>
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-48 h-auto rounded-md border">
                        </div>
                    @endif

                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Change Product Image</label>
                    <input type="file" id="image" name="image"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        accept="image/*">
                    <p class="mt-1 text-sm text-gray-500">Maximum file size: 2MB. Formats: JPG, PNG. Leave empty to keep
                        current image.</p>
                </div>

                <div class="flex items-start mb-6">
                    <div class="flex items-center h-5">
                        <input id="is_featured" name="is_featured" type="checkbox" value="1"
                            {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                            class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300">
                    </div>
                    <label for="is_featured" class="ml-2 text-sm font-medium text-gray-900">Featured Product</label>
                </div>

                <div class="flex items-start mb-6">
                    <div class="flex items-center h-5">
                        <input id="is_available" name="is_available" type="checkbox" value="1"
                            {{ old('is_available', $product->is_available) ? 'checked' : '' }}
                            class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300">
                    </div>
                    <label for="is_available" class="ml-2 text-sm font-medium text-gray-900">Available for purchase</label>
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('admin.store.products.index') }}"
                        class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2">
                        Cancel
                    </a>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
