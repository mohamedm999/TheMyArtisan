@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap">
            <div class="w-full">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h4 class="text-lg font-semibold text-gray-700">Create New Service</h4>
                        <a href="{{ route('admin.services.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Back to Services
                        </a>
                    </div>
                    <div class="p-6">
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.services.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Service Name</label>
                                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    value="{{ old('name') }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    rows="4" required>{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                                <input type="number" name="price" id="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    step="0.01" value="{{ old('price') }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                                <select name="category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Service Provider</label>
                                <select name="user_id" id="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="">Select Provider</option>
                                    @foreach (\App\Models\User::whereHas('roles', function ($q) {
            $q->where('name', 'artisan');
        })->get() as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create Service</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
