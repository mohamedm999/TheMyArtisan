<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Get paginated categories with their parent relationships
     * 
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedCategories(int $perPage = 10): LengthAwarePaginator
    {
        return Category::with('parent')->paginate($perPage);
    }
    
    /**
     * Get all active categories
     * 
     * @return Collection
     */
    public function getActiveCategories(): Collection
    {
        return Category::where('is_active', true)->get();
    }
    
    /**
     * Get all active categories except the given one
     * 
     * @param int $excludeId
     * @return Collection
     */
    public function getActiveCategoriesExcept(int $excludeId): Collection
    {
        return Category::where('id', '!=', $excludeId)
            ->where('is_active', true)
            ->get();
    }
    
    /**
     * Create a new category
     * 
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        try {
            $category = new Category();
            $category->name = $data['name'];
            $category->slug = $this->generateUniqueSlug($data['name']);
            $category->description = $data['description'] ?? null;
            $category->parent_id = $data['parent_id'] ?? null;
            $category->icon = $data['icon'] ?? null;
            $category->image = $data['image'] ?? null;
            $category->is_active = $data['is_active'] ?? false;
            $category->save();
            
            return $category;
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage(), [
                'data' => $data
            ]);
            throw $e;
        }
    }
    
    /**
     * Update a category
     * 
     * @param Category $category
     * @param array $data
     * @return bool
     */
    public function updateCategory(Category $category, array $data): bool
    {
        try {
            // Update slug only if name changed
            if ($category->name !== $data['name']) {
                $category->slug = $this->generateUniqueSlug($data['name'], $category->id);
            }
            
            $category->name = $data['name'];
            $category->description = $data['description'] ?? $category->description;
            $category->parent_id = $data['parent_id'] ?? $category->parent_id;
            $category->icon = $data['icon'] ?? $category->icon;
            
            if (isset($data['image'])) {
                $category->image = $data['image'];
            }
            
            $category->is_active = $data['is_active'] ?? false;
            
            return $category->save();
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage(), [
                'category_id' => $category->id,
                'data' => $data
            ]);
            return false;
        }
    }
    
    /**
     * Delete a category
     * 
     * @param Category $category
     * @return bool
     */
    public function deleteCategory(Category $category): bool
    {
        try {
            // Check if the category can be deleted
            $canDelete = $this->canDeleteCategory($category);
            if (!$canDelete['canDelete']) {
                return false;
            }
            
            // Delete image if exists
            if ($category->image) {
                Storage::delete('public/categories/' . $category->image);
            }
            
            return $category->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage(), [
                'category_id' => $category->id
            ]);
            return false;
        }
    }
    
    /**
     * Generate a unique slug for a category
     * 
     * @param string $name
     * @param int|null $excludeId
     * @return string
     */
    public function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        
        // Check if the slug already exists
        $query = Category::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $count = $query->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }
        
        return $slug;
    }
    
    /**
     * Check if a category can be safely deleted
     * 
     * @param Category $category
     * @return array Contains 'canDelete' boolean and 'reason' string if can't delete
     */
    public function canDeleteCategory(Category $category): array
    {
        // Check if category has services
        if ($category->services()->count() > 0) {
            return [
                'canDelete' => false,
                'reason' => 'Cannot delete category because it has associated services.'
            ];
        }
        
        // Check if category has subcategories
        if ($category->children()->count() > 0) {
            return [
                'canDelete' => false,
                'reason' => 'Cannot delete category because it has subcategories.'
            ];
        }
        
        // Check if category has artisan profiles
        if ($category->artisanProfiles()->count() > 0) {
            return [
                'canDelete' => false,
                'reason' => 'Cannot delete category because it is associated with artisan profiles.'
            ];
        }
        
        return [
            'canDelete' => true,
            'reason' => ''
        ];
    }
    
    /**
     * Handle category image upload
     * 
     * @param Request $request
     * @param Category|null $category
     * @return string|null The image filename
     */
    public function handleImageUpload(Request $request, ?Category $category = null): ?string
    {
        if (!$request->hasFile('image')) {
            return null;
        }
        
        try {
            // Delete old image if exists
            if ($category && $category->image) {
                Storage::delete('public/categories/' . $category->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/categories', $imageName);
            
            return $imageName;
        } catch (\Exception $e) {
            Log::error('Error handling image upload: ' . $e->getMessage());
            return null;
        }
    }
}