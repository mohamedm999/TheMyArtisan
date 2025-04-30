@extends('layouts.client')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header bg-danger text-white">
                    Error {{ $code ?? 500 }}
                </div>
                <div class="card-body">
                    <h3>Oops! Something went wrong.</h3>
                    <p>{{ $message ?? 'An unexpected error occurred. Please try again later.' }}</p>
                    <div class="mt-4">
                        <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
