<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['artisanProfile.user', 'category']);

        // Apply filters if provided
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $services = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::where('is_active', true)->get();

        return view('admin.services.index', compact('services', 'categories'));
    }

    public function create()
    {
        $artisans = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->with('artisanProfile')->get();

        $categories = Category::where('is_active', true)->get();

        return view('admin.services.create', compact('artisans', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:0',
            'artisan_profile_id' => 'required|exists:artisan_profiles,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $data['image'] = $path;
        }

        Service::create($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        $artisans = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->with('artisanProfile')->get();

        $categories = Category::where('is_active', true)->get();

        return view('admin.services.edit', compact('service', 'artisans', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:0',
            'artisan_profile_id' => 'required|exists:artisan_profiles,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $path = $request->file('image')->store('services', 'public');
            $data['image'] = $path;
        }

        $service->update($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        // Check if service has bookings
        if ($service->bookings()->count() > 0) {
            return redirect()->route('admin.services.index')
                ->with('error', 'Cannot delete service that has bookings.');
        }

        // Delete image if exists
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
