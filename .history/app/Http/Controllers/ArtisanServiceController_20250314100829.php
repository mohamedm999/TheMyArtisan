<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtisanServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Auth::user()->services()->latest()->get();
        return view('artisan.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ServiceCategory::where('is_active', true)->get();
        return view('artisan.services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'category_id' => 'required|exists:service_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $service = new Service();
        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->duration = $request->duration;
        $service->category_id = $request->category_id;
        $service->is_active = $request->has('is_active');
        $service->artisan_id = Auth::id();

        // Generate a slug from the name with a unique suffix
        $service->slug = Str::slug($request->name) . '-' . Str::lower(Str::random(10));

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $service->image = $path;
        }

        $service->save();

        return redirect()->route('artisan.services.index')
            ->with('success', 'Service created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        if ($service->artisan_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('artisan.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        if ($service->artisan_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = ServiceCategory::where('is_active', true)->get();
        return view('artisan.services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        if ($service->artisan_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'category_id' => 'required|exists:service_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->duration = $request->duration;
        $service->category_id = $request->category_id;
        $service->is_active = $request->has('is_active');

        // Update slug only if name has changed
        if ($service->isDirty('name')) {
            $service->slug = Str::slug($request->name) . '-' . Str::lower(Str::random(10));
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            // Store the new image
            $path = $request->file('image')->store('services', 'public');
            $service->image = $path;
        }

        $service->save();

        return redirect()->route('artisan.services.index')
            ->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->artisan_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the image if it exists
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('artisan.services.index')
            ->with('success', 'Service deleted successfully');
    }
}
