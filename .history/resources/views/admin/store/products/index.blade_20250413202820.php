@extends('layouts.admin')

@section('title', 'Manage Store Products')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Store Products</h1>
            <a href="{{ route('admin.store.products.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add New Product
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Products</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $products->total() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-gift fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Available Products
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $products->where('is_available', true)->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Featured Products
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $products->where('is_featured', true)->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-star fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Out of Stock</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $products->where('stock', 0)->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box-open fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Products</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Options:</div>
                        <a class="dropdown-item" href="{{ route('admin.store.products.create') }}">Add New Product</a>
                        <a class="dropdown-item" href="{{ route('admin.store.orders.index') }}">View Orders</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="productsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Points Cost</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}"
                                                style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                                        @else
                                            <div class="bg-light text-center rounded"
                                                style="width: 50px; height: 50px; line-height: 50px;">
                                                <i class="fas fa-gift text-gray-500"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category ?? 'Uncategorized' }}</td>
                                    <td>{{ number_format($product->points_cost) }} points</td>
                                    <td>
                                        @if ($product->stock == -1)
                                            <span class="badge badge-info">Unlimited</span>
                                        @elseif($product->stock > 10)
                                            <span class="badge badge-success">{{ $product->stock }}</span>
                                        @elseif($product->stock > 0)
                                            <span class="badge badge-warning">{{ $product->stock }} left</span>
                                        @else
                                            <span class="badge badge-danger">Out of stock</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->is_available)
                                            <span class="badge badge-success">Available</span>
                                        @else
                                            <span class="badge badge-secondary">Unavailable</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->is_featured)
                                            <span class="badge badge-warning"><i class="fas fa-star mr-1"></i>
                                                Featured</span>
                                        @else
                                            <span class="badge badge-light">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.store.products.show', $product->id) }}"
                                                class="btn btn-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.store.products.edit', $product->id) }}"
                                                class="btn btn-primary" title="Edit Product">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.store.products.destroy', $product->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Delete Product"
                                                    onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable({
                "paging": false,
                "searching": true,
                "ordering": true,
                "info": false,
            });
        });
    </script>
@endsection
