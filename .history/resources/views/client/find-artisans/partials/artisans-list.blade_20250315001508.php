@if($artisans->isEmpty())
    <div class="alert alert-info w-100">
        <p class="mb-0">No artisans found matching your criteria. Please try a different search.</p>
    </div>
@else
    <div class="row">
        @foreach($artisans as $artisan)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 artisan-card">
                    <div class="card-img-top text-center py-3">
                        @if($artisan->artisanProfile->profile_photo)
                            <img src="{{ asset('storage/' . $artisan->artisanProfile->profile_photo) }}" 
                                class="rounded-circle" alt="{{ $artisan->firstname }}" 
                                style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="avatar-placeholder">
                                {{ substr($artisan->firstname, 0, 1) }}{{ substr($artisan->lastname, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $artisan->firstname }} {{ $artisan->lastname }}</h5>
                        <p class="card-text">
                            <i class="fas fa-map-marker-alt"></i> 
                            {{ $artisan->artisanProfile->city ?? 'Location not specified' }}, 
                            {{ $artisan->artisanProfile->state ?? '' }}
                        </p>
                        <p class="card-text">
                            <strong>Services:</strong> 
                            @forelse($artisan->artisanProfile->services as $service)
                                <span class="badge bg-secondary">{{ $service->name }}</span>
                            @empty
                                <span class="text-muted">No services listed</span>
                            @endforelse
                        </p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($artisan->artisanProfile->bio ?? 'No bio available', 100) }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('client.find-artisans.view', $artisan->id) }}" class="btn btn-primary">View Profile</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
