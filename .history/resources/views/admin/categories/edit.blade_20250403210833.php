@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
    <div class="py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    <i class="fas fa-edit text-blue-600 mr-2"></i> Edit Category
                </h2>
                <a href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow transition duration-150 ease-in-out">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Categories
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-sm">Please correct the following errors:</p>
                            <ul class="mt-2 list-disc list-inside text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                    enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-150 ease-in-out"
                                required>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-150 ease-in-out">{{ old('description', $category->description) }}</textarea>
                        </div>

                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Parent Category
                            </label>
                            <div class="relative">
                                <select name="parent_id" id="parent_id"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-150 ease-in-out appearance-none">
                                    <option value="">None (Top Level Category)</option>
                                    @foreach ($categories as $parentCategory)
                                        @if ($parentCategory->id != $category->id)
                                            <option value="{{ $parentCategory->id }}"
                                                {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                                                {{ $parentCategory->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">
                                Icon Class
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-icons text-gray-400"></i>
                                </span>
                                <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}"
                                    placeholder="e.g. fa-hammer"
                                    class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-150 ease-in-out">
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Enter Font Awesome icon class (e.g. fa-hammer, fa-tools)</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category Image</label>
                            <div class="flex items-start space-x-4">
                                @if ($category->image)
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/categories/' . $category->image) }}"
                                            alt="{{ $category->name }}" class="h-28 w-28 object-cover rounded-lg shadow-sm border border-gray-200">
                                    </div>
                                @endif
                                <div class="flex-grow">
                                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <i class="fas fa-cloud-upload-alt mx-auto h-12 w-12 text-gray-400"></i>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="image"
                                                    class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                    <span>Upload a file</span>
                                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, GIF up to 2MB
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label for="is_active" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" class="sr-only"
                                        {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                    <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
                                </div>
                                <div class="ml-3 text-gray-700 font-medium">Active Category</div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow transition duration-150 ease-in-out">
                            <i class="fas fa-save mr-2"></i> Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        input:checked ~ .dot {
            transform: translateX(100%);
            background-color: #3b82f6;
        }
        input:checked ~ .block {
            background-color: #bfdbfe;
        }
    </style>
@endsection
