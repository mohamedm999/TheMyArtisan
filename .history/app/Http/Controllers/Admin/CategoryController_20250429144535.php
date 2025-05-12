<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * The category repository instance.
     *
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * Create a new controller instance.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     * @return void
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->getPaginatedCategories(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->getActiveCategories();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        $imageName = $this->categoryRepository->handleImageUpload($request);

        // Create category with repository
        $this->categoryRepository->createCategory([
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'icon' => $request->icon,
            'image' => $imageName,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $categories = $this->categoryRepository->getActiveCategoriesExcept($category->id);
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload if needed
        $imageName = $this->categoryRepository->handleImageUpload($request, $category);
        
        // Update category with repository
        $this->categoryRepository->updateCategory($category, [
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'icon' => $request->icon,
            'image' => $imageName ?? $category->image, // Keep old image if no new upload
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Check if category can be deleted using repository method
        $canDelete = $this->categoryRepository->canDeleteCategory($category);
        
        if (!$canDelete['canDelete']) {
            return redirect()->route('admin.categories.index')
                ->with('error', $canDelete['reason']);
        }

        // Delete category with repository
        if ($this->categoryRepository->deleteCategory($category)) {
            return redirect()->route('admin.categories.index')
                ->with('success', 'Category deleted successfully.');
        }
        
        return redirect()->route('admin.categories.index')
            ->with('error', 'Failed to delete category. Please try again.');
    }
}
