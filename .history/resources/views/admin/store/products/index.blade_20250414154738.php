@extends('layouts.admin')

@section('title', 'Manage Store Products')

@section('content')
    <div class="px-4 py-6 w-full">
        <!-- Page Heading -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Store Products</h1>
            <a href="{{ route('admin.store.products.create') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow">
                <i class="fas fa-plus text-xs mr-2"></i> Add New Product
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded relative" role="alert">
                {{ session('success') }}
                <button type="button" class="absolute right-0 top-0 mt-4 mr-4" data-dismiss="alert">
                    <span class="text-green-500">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded relative" role="alert">
                {{ session('error') }}
                <button type="button" class="absolute right-0 top-0 mt-4 mr-4" data-dismiss="alert">
                    <span class="text-red-500">&times;</span>
                </button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-grow">
                        <div class="text-xs font-semibold text-blue-600 uppercase mb-1">Total Products</div>
                        <div class="text-xl font-bold text-gray-800">{{ $products->total() }}</div>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-gift text-2xl text-gray-300"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-grow">
                        <div class="text-xs font-semibold text-green-600 uppercase mb-1">Available Products</div>
                        <div class="text-xl font-bold text-gray-800">{{ $products->where('is_available', true)->count() }}</div>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-2xl text-gray-300"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="flex-grow">
                        <div class="text-xs font-semibold text-yellow-600 uppercase mb-1">Featured Products</div>
                        <div class="text-xl font-bold text-gray-800">{{ $products->where('is_featured', true)->count() }}</div>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-star text-2xl text-gray-300"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-cyan-500">
                <div class="flex items-center">
                    <div class="flex-grow">
                        <div class="text-xs font-semibold text-cyan-600 uppercase mb-1">Out of Stock</div>
                        <div class="text-xl font-bold text-gray-800">{{ $products->where('stock', 0)->count() }}</div>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-box-open text-2xl text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table Card -->
        <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
            <div class="px-6 py-4 flex items-center justify-between border-b">
                <h6 class="font-bold text-blue-600">All Products</h6>
                <div class="relative">
                    <button id="dropdownMenuLink" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" id="dropdown-menu">
                        <div class="px-4 py-2 text-xs text-gray-500">Options:</div>
                        <a href="{{ route('admin.store.products.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Add New Product</a>
                        <a href="{{ route('admin.store.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Orders</a>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table id="productsTable" class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Image</th>
                                <th class="py-3 px-4 text-left">Name</th>
                                <th class="py-3 px-4 text-left">Category</th>
                                <th class="py-3 px-4 text-left">Points Cost</th>
                                <th class="py-3 px-4 text-left">Stock</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Featured</th>
                                <th class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @foreach ($products as $product)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">{{ $product->id }}</td>
                                    <td class="py-3 px-4">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}"
                                                class="w-12 h-12 object-cover rounded">
                                        @else
                                            <div class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded">
                                                <i class="fas fa-gift text-gray-500"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">{{ $product->name }}</td>
                                    <td class="py-3 px-4">{{ $product->category ?? 'Uncategorized' }}</td>
                                    <td class="py-3 px-4">{{ number_format($product->points_cost) }} points</td>
                                    <td class="py-3 px-4">
                                        @if ($product->stock == -1)
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Unlimited</span>
                                        @elseif($product->stock > 10)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">{{ $product->stock }}</span>
                                        @elseif($product->stock > 0)
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">{{ $product->stock }} left</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Out of stock</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if ($product->is_available)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Available</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Unavailable</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if ($product->is_featured)
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-star mr-1"></i> Featured
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">No</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex space-x-1">
                                            <a href="{{ route('admin.store.products.show', $product->id) }}"
                                                class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.store.products.edit', $product->id) }}"
                                                class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600" title="Edit Product">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.store.products.destroy', $product->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600" title="Delete Product"
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
