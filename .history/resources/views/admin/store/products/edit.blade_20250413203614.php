@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
            <div>
                <a href="{{ route('admin.store.products.show', $product->id) }}" class="btn btn-info shadow-sm mr-2">
                    <i class="fas fa-eye fa-sm text-white-50 mr-1"></i> View Product
                </a>
                <a href="{{ route('admin.store.products.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Products
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Product Information</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.store.products.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $product->name) }}"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" class="form-control @error('category') is-invalid @enderror"
                                            id="category" name="category" value="{{ old('category', $product->category) }}"
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
                                    rows="5" required>{{ old('description', $product->description) }}</textarea>
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
                                                id="points_cost" name="points_cost"
                                                value="{{ old('points_cost', $product->points_cost) }}" min="1"
                                                required>
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
                                                id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
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
                                @if ($product->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="img-thumbnail" style="max-height: 200px;">
                                        <div class="custom-control custom-checkbox mt-1">
                                            <input type="checkbox" class="custom-control-input" id="remove_image"
                                                name="remove_image">
                                            <label class="custom-control-label" for="remove_image">Remove current
                                                image</label>
                                        </div>
                                    </div>
                                @endif
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                        id="image" name="image">
                                    <label class="custom-file-label" for="image">Choose new file...</label>
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
                                                name="is_available"
                                                {{ old('is_available', $product->is_available) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_available">Available for
                                                purchase</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_featured"
                                                name="is_featured"
                                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_featured">Featured product</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-center">
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="fas fa-save mr-1"></i> Update Product
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
