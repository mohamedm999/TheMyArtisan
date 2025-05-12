<?php

namespace App\Repositories;

use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceRepository implements ServiceRepositoryInterface
{
    /**
     * Get all services for an artisan
     *
     * @param int $artisanProfileId
     * @return Collection
     */
    public function getArtisanServices(int $artisanProfileId): Collection
    {
        return Service::where('artisan_profile_id', $artisanProfileId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get all categories
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return Category::orderBy('name')->get();
    }

    /**
     * Create a new service for an artisan
     *
     * @param array $data
     * @param int $artisanProfileId
     * @return Service
     */
    public function createService(array $data, int $artisanProfileId): Service
    {
        try {
            $data['artisan_profile_id'] = $artisanProfileId;
            $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

            $service = Service::create($data);

            Log::info('Service created successfully', ['artisan_profile_id' => $artisanProfileId]);

            return $service;
        } catch (\Exception $e) {
            Log::error('Error creating service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Update an existing service
     *
     * @param Service $service
     * @param array $data
     * @return bool
     */
    public function updateService(Service $service, array $data): bool
    {
        return $service->update($data);
    }

    /**
     * Delete a service
     *
     * @param Service $service
     * @return bool
     */
    public function deleteService(Service $service): bool
    {
        // Delete image if it exists
        if ($service->image && Storage::exists('public/' . $service->image)) {
            Storage::delete('public/' . $service->image);
        }

        return $service->delete();
    }

    /**
     * Find a service by ID for a specific artisan profile
     *
     * @param int $serviceId
     * @param int $artisanProfileId
     * @return Service|null
     */
    public function findServiceForArtisan(int $serviceId, int $artisanProfileId): ?Service
    {
        return Service::where('id', $serviceId)
            ->where('artisan_profile_id', $artisanProfileId)
            ->first();
    }

    /**
     * Get or create artisan profile for user
     *
     * @param int $userId
     * @return ArtisanProfile
     */
    public function getOrCreateArtisanProfile(int $userId): ArtisanProfile
    {
        return ArtisanProfile::firstOrCreate(['user_id' => $userId], []);
    }

    /**
     * Handle image upload for a service
     *
     * @param Request $request
     * @param Service|null $service
     * @return string|null
     */
    public function handleImageUpload(Request $request, ?Service $service = null): ?string
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        try {
            // Delete old image if it exists
            if ($service && $service->image && Storage::exists('public/' . $service->image)) {
                Storage::delete('public/' . $service->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/services', $imageName);

            return str_replace('public/', '', $imagePath);
        } catch (\Exception $e) {
            Log::error('Error uploading image', ['error' => $e->getMessage()]);
            return null;
        }
    }
    
    /**
     * Get all services with filters for admin
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllServicesForAdmin(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Service::with(['artisanProfile.user', 'category']);

        // Apply search filter
        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply category filter
        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        // Apply status filter
        if (isset($filters['status'])) {
            $isActive = $filters['status'] === 'active';
            $query->where('is_active', $isActive);
        }

        // Apply sort options
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage)->withQueryString();
    }
    
    /**
     * Get active categories
     *
     * @return Collection
     */
    public function getActiveCategories(): Collection
    {
        return Category::where('is_active', true)->orderBy('name')->get();
    }
    
    /**
     * Get all artisans with their profiles
     *
     * @return Collection
     */
    public function getAllArtisansWithProfiles(): Collection
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->with('artisanProfile')->get();
    }
    
    /**
     * Find service by ID
     *
     * @param int $id
     * @return Service|null
     */
    public function findServiceById(int $id): ?Service
    {
        return Service::with(['artisanProfile.user', 'category'])->find($id);
    }
    
    /**
     * Check if service has bookings
     *
     * @param Service $service
     * @return bool
     */
    public function hasBookings(Service $service): bool
    {
        return $service->bookings()->count() > 0;
    }
}
