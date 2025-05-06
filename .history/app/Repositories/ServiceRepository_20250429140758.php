<?php

namespace App\Repositories;

use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Illuminate\Http\Request;
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
}
