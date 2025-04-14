@extends('layouts.admin')

@section('title', 'Create Product')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Create New Product
    </h2>

    @if ($errors->any())
        <div class="mb-5">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">Please check the form for errors.</span>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md">
        <form action="{{ route('admin.store.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Product Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        required>
                </div>
                <div>
                    <label for="points_cost" class="block mb-2 text-sm font-medium text-gray-900">Points Cost</label>
                    <input type="number" id="points_cost" name="points_cost" value="{{ old('points_cost') }}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        required min="1">
                </div>
                <div>
                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                    <input type="text" id="category" name="category" value="{{ old('category') }}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        list="category-options">
                    <datalist id="category-options">
                        @foreach($categories as $category)
                            <option value="{{ $category }}">
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label for="stock" class="block mb-2 text-sm font-medium text-gray-900">Stock (-1 for unlimited)</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        required min="-1">
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                <textarea id="description" name="description" rows="4" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                    required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Product Image</label>
                <input type="file" id="image" name="image" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                    accept="image/*">
                <p class="mt-1 text-sm text-gray-500">Maximum file size: 2MB. Formats: JPG, PNG</p>
            </div>
            
            <div class="flex items-start mb-6">
                <div class="flex items-center h-5">
                    <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ old('is_featured') ? 'checked' : '' }}
                        class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300">
                </div>
                <label for="is_featured" class="ml-2 text-sm font-medium text-gray-900">Featured Product</label>
            </div>
            
            <div class="flex items-start mb-6">
                <div class="flex items-center h-5">
                    <input id="is_available" name="is_available" type="checkbox" value="1" {{ old('is_available', true) ? 'checked' : '' }}
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
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
