<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    /**
     * Get paginated categories with their parent relationships
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedCategories(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get all active categories
     *
     * @return Collection
     */
    public function getActiveCategories(): Collection;

    /**
     * Get all active categories except the given one
     *
     * @param int $excludeId
     * @return Collection
     */
    public function getActiveCategoriesExcept(int $excludeId): Collection;

    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data): Category;

    /**
     * Update a category
     *
     * @param Category $category
     * @param array $data
     * @return bool
     */
    public function updateCategory(Category $category, array $data): bool;

    /**
     * Delete a category
     *
     * @param Category $category
     * @return bool
     */
    public function deleteCategory(Category $category): bool;

    /**
     * Generate a unique slug for a category
     *
     * @param string $name
     * @param int|null $excludeId
     * @return string
     */
    public function generateUniqueSlug(string $name, ?int $excludeId = null): string;

    /**
     * Check if a category can be safely deleted
     *
     * @param Category $category
     * @return array Contains 'canDelete' boolean and 'reason' string if can't delete
     */
    public function canDeleteCategory(Category $category): array;

    /**
     * Handle category image upload
     *
     * @param Request $request
     * @param Category|null $category
     * @return string|null The image filename
     */
    public function handleImageUpload(Request $request, ?Category $category = null): ?string;
}
