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

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" class="form-control @error('category') is-invalid @enderror"
                                            id="category" name="category" value="{{ old('category') }}"
                                            placeholder="e.g. Vouchers, Merchandise, etc.">
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="5" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="points_cost">Points Cost <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number"
                                                class="form-control @error('points_cost') is-invalid @enderror"
                                                id="points_cost" name="points_cost" value="{{ old('points_cost') }}"
                                                min="1" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">points</span>
                                            </div>
                                        </div>
                                        @error('points_cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock">Stock Quantity</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                                id="stock" name="stock" value="{{ old('stock', -1) }}"
                                                min="-1">
                                            <div class="input-group-append">
                                                <span class="input-group-text">units</span>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Use -1 for unlimited stock</small>
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image">Product Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                        id="image" name="image">
                                    <label class="custom-file-label" for="image">Choose file...</label>
                                </div>
                                <small class="form-text text-muted">Recommended size: 800x600 pixels (JPG, PNG)</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_available"
                                                name="is_available" {{ old('is_available') ? 'checked' : 'checked' }}>
                                            <label class="custom-control-label" for="is_available">Available for
                                                purchase</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_featured"
                                                name="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_featured">Featured product</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-center">
                                <button type="submit" class="btn btn-primary px-5">
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
        // Update file input label to show selected filename
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
@endsection
