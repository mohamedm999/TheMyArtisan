@extends('layouts.client')

@section('title', 'Find Artisans')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Find Talented Artisans</h1>
            <p class="text-muted">Browse through our selection of professional artisans for your projects</p>
        </div>
        <div class="col-md-4">
            <form action="{{ route('client.artisans.index') }}" method="GET">
