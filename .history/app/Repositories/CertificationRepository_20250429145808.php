<?php

namespace App\Repositories;

use App\Models\Certification;
use App\Repositories\Interfaces\CertificationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class CertificationRepository implements CertificationRepositoryInterface
{
    /**
     * Get all certifications with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllWithPagination(int $perPage = 10): LengthAwarePaginator
    {
        return Certification::with('artisanProfile.user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get certification by ID
     *
     * @param int $id
     * @return Certification|null
     */
    public function findById(int $id): ?Certification
    {
        return Certification::with('artisanProfile.user')
            ->findOrFail($id);
    }

    /**
     * Create a new certification
     *
     * @param array $data
     * @return Certification
     */
    public function create(array $data): Certification
    {
        try {
            return Certification::create($data);
        } catch (\Exception $e) {
            Log::error('Error creating certification: ' . $e->getMessage(), [
                'data' => $data
            ]);
            throw $e;
        }
    }

    /**
     * Update a certification
     *
     * @param Certification $certification
     * @param array $data
     * @return bool
     */
    public function update(Certification $certification, array $data): bool
    {
        try {
            return $certification->update($data);
        } catch (\Exception $e) {
            Log::error('Error updating certification: ' . $e->getMessage(), [
                'certification_id' => $certification->id,
                'data' => $data
            ]);
            return false;
        }
    }

    /**
     * Delete a certification
     *
     * @param Certification $certification
     * @return bool
     */
    public function delete(Certification $certification): bool
    {
        try {
            return $certification->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting certification: ' . $e->getMessage(), [
                'certification_id' => $certification->id
            ]);
            return false;
        }
    }

    /**
     * Update certification verification status
     *
     * @param Certification $certification
     * @param string $status
     * @return bool
     */
    public function updateStatus(Certification $certification, string $status): bool
    {
        try {
            $certification->verification_status = $status;
            $certification->verified_at = $status === 'verified' ? now() : null;
            $certification->verification_notes = $certification->verification_notes . "\nStatus changed to {$status} on " . now()->format('Y-m-d H:i:s');

            return $certification->save();
        } catch (\Exception $e) {
            Log::error('Error updating certification status: ' . $e->getMessage(), [
                'certification_id' => $certification->id,
                'status' => $status
            ]);
            return false;
        }
    }
}
