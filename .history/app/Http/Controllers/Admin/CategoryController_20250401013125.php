<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
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

        // Generate slug
        $slug = Str::slug($request->name);

        // Check if the slug already exists
        $count = Category::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        // Handle image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/categories', $imageName);
        }

        // Create category
        Category::create([
            'name' => $request->name,
            'slug' => $slug,
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
        $categories = Category::where('id', '!=', $category->id)->where('is_active', true)->get();
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

        // Update slug only if name changed
        if ($category->name !== $request->name) {
            $slug = Str::slug($request->name);

            // Check if the slug already exists
            $count = Category::where('slug', $slug)->where('id', '!=', $category->id)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }

            $category->slug = $slug;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                Storage::delete('public/categories/' . $category->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/categories', $imageName);

            $category->image = $imageName;
        }

        // Update other fields
        $category->name = $request->name;
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->icon = $request->icon;
        $category->is_active = $request->has('is_active');

        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Check if category has services
        if ($category->services()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category because it has associated services.');
        }

        // Check if category has subcategories
        if ($category->children()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category because it has subcategories.');
        }

        // Check if category has artisan profiles
        if ($category->artisanProfiles()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category because it is associated with artisan profiles.');
        }

        // Delete image if exists
        if ($category->image) {
            Storage::delete('public/categories/' . $category->image);
        }

        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
