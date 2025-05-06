<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    /**
     * The service repository implementation.
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
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Display all services for the artisan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $artisanProfile = $this->serviceRepository->getOrCreateArtisanProfile($user->id);

        // If there's no artisan profile yet, just return an empty collection
        $services = $artisanProfile && $artisanProfile->id
            ? $this->serviceRepository->getArtisanServices($artisanProfile->id)
            : collect(); // Empty collection

        $categories = $this->serviceRepository->getAllCategories();

        return view('artisan.services', compact('services', 'categories'));
    }

    /**
     * Store a new service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
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

        try {
            $user = Auth::user();
            $artisanProfile = $this->serviceRepository->getOrCreateArtisanProfile($user->id);

            $data = $request->except(['_token', 'image']);
            $data['is_active'] = $request->has('is_active') ? true : false;

            // Handle image upload
            $imagePath = $this->serviceRepository->handleImageUpload($request);
            if ($imagePath) {
                $data['image'] = $imagePath;
            }

            $this->serviceRepository->createService($data, $artisanProfile->id);

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $user = Auth::user();
            $artisanProfile = $this->serviceRepository->getOrCreateArtisanProfile($user->id);

            // Find service for this artisan
            $service = $this->serviceRepository->findServiceForArtisan($id, $artisanProfile->id);

            if (!$service) {
                return redirect()->route('artisan.services')->with('error', 'Service not found!');
            }

            $data = $request->except(['_token', '_method', 'image']);
            $data['is_active'] = $request->has('is_active') ? true : false;

            // Handle image upload
            $imagePath = $this->serviceRepository->handleImageUpload($request, $service);
            if ($imagePath) {
                $data['image'] = $imagePath;
            }

            $this->serviceRepository->updateService($service, $data);

            return redirect()->route('artisan.services')->with('success', 'Service updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating service', ['error' => $e->getMessage()]);
            return redirect()->route('artisan.services')->with('error', 'Failed to update service: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified service.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $artisanProfile = $this->serviceRepository->getOrCreateArtisanProfile($user->id);

            // Find service for this artisan
            $service = $this->serviceRepository->findServiceForArtisan($id, $artisanProfile->id);

            if (!$service) {
                return redirect()->route('artisan.services')->with('error', 'Service not found!');
            }

            $this->serviceRepository->deleteService($service);

            return redirect()->route('artisan.services')->with('success', 'Service deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting service', ['error' => $e->getMessage()]);
            return redirect()->route('artisan.services')->with('error', 'Failed to delete service: ' . $e->getMessage());
        }
    }
}
