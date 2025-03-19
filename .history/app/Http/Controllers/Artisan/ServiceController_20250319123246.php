<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\ArtisanProfile; // Add this import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Add logging
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        // If there's no artisan profile yet, just return an empty collection
        if (!$artisanProfile) {
            $services = collect(); // Empty collection
        } else {
            // Get services through the artisan profile
            $services = Service::where('artisan_profile_id', $artisanProfile->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $categories = Category::orderBy('name')->get();

        return view('artisan.services', compact('services', 'categories'));
    }

    /**
     * Store a newly created service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $artisanProfile = ArtisanProfile::firstOrCreate(['user_id' => $user->id], []);

        $data = $request->except(['_token', 'image']);
        $data['artisan_profile_id'] = $artisanProfile->id; // Use artisan_profile_id instead of user_id
        $data['slug'] = Str::slug($request->name) . '-' . uniqid();
        $data['is_active'] = $request->has('is_active') ? true : false;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/services', $imageName);
            $data['image'] = str_replace('public/', '', $imagePath);
        }

        try {
            Service::create($data);
            Log::info('Service created successfully', ['artisan_profile_id' => $artisanProfile->id]);
            return redirect()->route('artisan.services')->with('success', 'Service added successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating service', ['error' => $e->getMessage()]);
            return redirect()->route('artisan.services')->with('error', 'Failed to add service: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->firstOrFail();

        $service = Service::where('id', $id)
            ->where('artisan_profile_id', $artisanProfile->id) // Use artisan_profile_id instead of user_id
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'image']);
        $data['is_active'] = $request->has('is_active') ? true : false;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($service->image && Storage::exists('public/' . $service->image)) {
                Storage::delete('public/' . $service->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/services', $imageName);
            $data['image'] = str_replace('public/', '', $imagePath);
        }

        $service->update($data);

        return redirect()->route('artisan.services')->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified service.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->firstOrFail();

        $service = Service::where('id', $id)
            ->where('artisan_profile_id', $artisanProfile->id) // Use artisan_profile_id instead of user_id
            ->firstOrFail();

        // Delete image if it exists
        if ($service->image && Storage::exists('public/' . $service->image)) {
            Storage::delete('public/' . $service->image);
        }

        $service->delete();

        return redirect()->route('artisan.services')->with('success', 'Service deleted successfully!');
    }
}
