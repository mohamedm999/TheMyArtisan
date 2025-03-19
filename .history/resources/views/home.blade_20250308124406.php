
@extends('layouts.app')

@section('title', 'MyArtisan - Moroccan Craftsmanship Platform')

@section('description', 'MyArtisan - Connect with skilled Moroccan artisans for authentic craftsmanship')

@section('content')
    @include('components.hero')
    @include('components.features')
    @include('components.cta')
@endsection
