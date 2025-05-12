<?php

namespace App\Repositories\Interfaces;

use App\Models\Certification;
use Illuminate\Pagination\LengthAwarePaginator;

interface CertificationRepositoryInterface
{
    /**
     * Get all certifications with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllWithPagination(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get certification by ID
     *
     * @param int $id
     * @return Certification|null
     */
    public function findById(int $id): ?Certification;

    /**
     * Create a new certification
     *
     * @param array $data
     * @return Certification
     */
    public function create(array $data): Certification;

    /**
     * Update a certification
     *
     * @param Certification $certification
     * @param array $data
     * @return bool
     */
    public function update(Certification $certification, array $data): bool;

    /**
     * Delete a certification
     *
     * @param Certification $certification
     * @return bool
     */
    public function delete(Certification $certification): bool;

    /**
     * Update certification verification status
     *
     * @param Certification $certification
     * @param string $status
     * @return bool
     */
    public function updateStatus(Certification $certification, string $status): bool;
}
