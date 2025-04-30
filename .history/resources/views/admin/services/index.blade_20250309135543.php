@extends('layouts.admin')

@section('title', 'Manage Services')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Services Management
                            <a href="{{ route('admin.services.create') }}" class="btn btn-primary float-right">Add New
                                Service</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Provider</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $service->id }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->price }}</td>
                                        <td>{{ $service->category->name ?? 'N/A' }}</td>
                                        <td>{{ $service->user->name ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('admin.services.edit', $service->id) }}"
                                                class="btn btn-sm btn-info">Edit</a>
                                            <form action="{{ route('admin.services.destroy', $service->id) }}"
                                                method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this service?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $services->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
