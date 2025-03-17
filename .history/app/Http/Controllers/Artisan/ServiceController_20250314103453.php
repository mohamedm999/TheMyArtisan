<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::where('artisan_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

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

        $data = $request->except(['_token', 'image']);
        $data['artisan_id'] = Auth::id();
        $data['slug'] = Str::slug($request->name) . '-' . uniqid();
        $data['is_active'] = $request->has('is_active') ? true : false;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Store directly in public/storage/services folder
            $imagePath = $image->storePublicly('services', 'public');
            $data['image'] = $imagePath;
        }

        Service::create($data);

        return redirect()->route('artisan.services')->with('success', 'Service added successfully!');
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
        $service = Service::where('id', $id)
            ->where('artisan_id', Auth::id())
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
            // Store directly in public/storage/services folder
            $imagePath = $image->storePublicly('services', 'public');
            $data['image'] = $imagePath;
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
        $service = Service::where('id', $id)
            ->where('artisan_id', Auth::id())
            ->firstOrFail();

        // Delete image if it exists
        if ($service->image && Storage::exists('public/' . $service->image)) {
            Storage::delete('public/' . $service->image);
        }

        $service->delete();

        return redirect()->route('artisan.services')->with('success', 'Service deleted successfully!');
    }
}
