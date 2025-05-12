<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * The service repository instance.
     *
     * @var ServiceRepositoryInterface
     */
    protected $serviceRepository;

    /**
     * Create a new controller instance.
     *
     * @param ServiceRepositoryInterface $serviceRepository
     * @return void
     */
    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Display a listing of services.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'category' => $request->category,
            'status' => $request->status,
            'sort_field' => $request->sort_by,
            'sort_direction' => $request->sort_direction
        ];

        $services = $this->serviceRepository->getAllServicesForAdmin($filters);
        $categories = $this->serviceRepository->getActiveCategories();

        return view('admin.services.index', compact('services', 'categories'));
    }

    /**
     * Show the form for creating a new service.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $artisans = $this->serviceRepository->getAllArtisansWithProfiles();
        $categories = $this->serviceRepository->getActiveCategories();

        return view('admin.services.create', compact('artisans', 'categories'));
    }

    /**
     * Store a newly created service in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
        
        // Handle image upload if present
        if ($request->hasFile('image')) {
            $data['image'] = $this->serviceRepository->handleImageUpload($request);
        }
        
        // Use existing createService method
        $this->serviceRepository->createService($data, $request->artisan_profile_id);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Show the form for editing the specified service.
     *
     * @param Service $service
     * @return \Illuminate\View\View
     */
    public function edit(Service $service)
    {
        $artisans = $this->serviceRepository->getAllArtisansWithProfiles();
        $categories = $this->serviceRepository->getActiveCategories();

        return view('admin.services.edit', compact('service', 'artisans', 'categories'));
    }

    /**
     * Update the specified service in storage.
     *
     * @param Request $request
     * @param Service $service
     * @return \Illuminate\Http\RedirectResponse
     */
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
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        
        // Handle image upload if present
        if ($request->hasFile('image')) {
            $data['image'] = $this->serviceRepository->handleImageUpload($request, $service);
        }

        $this->serviceRepository->updateService($service, $data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified service from storage.
     *
     * @param Service $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service)
    {
        // Check if service has bookings
        if ($this->serviceRepository->hasBookings($service)) {
            return redirect()->route('admin.services.index')
                ->with('error', 'Cannot delete service that has bookings.');
        }

        $this->serviceRepository->deleteService($service);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
