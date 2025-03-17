// ...existing code...

@if($service->image)
    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="service-image">
@else
    <div class="placeholder-image">No Image</div>
@endif

// ...existing code...
