<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Repositories\Interfaces\CertificationRepositoryInterface;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    /**
     * The certification repository instance.
     *
     * @var CertificationRepositoryInterface
     */
    protected $certificationRepository;

    /**
     * Create a new controller instance.
     *
     * @param CertificationRepositoryInterface $certificationRepository
     * @return void
     */
    public function __construct(CertificationRepositoryInterface $certificationRepository)
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
        $this->certificationRepository = $certificationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certifications = $this->certificationRepository->getAllWithPagination(10);
        return view('admin.certifications.index', compact('certifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.certifications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'description' => 'nullable|string',
            'artisan_profile_id' => 'required|exists:artisan_profiles,id',
            'verification_status' => 'required|in:pending,verified,rejected',
        ]);

        $this->certificationRepository->create($request->all());

        return redirect()->route('admin.certifications.index')
            ->with('success', 'Certification created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $certification = $this->certificationRepository->findById($id);
        return view('admin.certifications.show', compact('certification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $certification = $this->certificationRepository->findById($id);
        return view('admin.certifications.edit', compact('certification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'description' => 'nullable|string',
            'verification_status' => 'required|in:pending,verified,rejected',
        ]);

        $certification = $this->certificationRepository->findById($id);
        $this->certificationRepository->update($certification, $request->all());

        return redirect()->route('admin.certifications.index')
            ->with('success', 'Certification updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $certification = $this->certificationRepository->findById($id);
        $this->certificationRepository->delete($certification);

        return redirect()->route('admin.certifications.index')
            ->with('success', 'Certification deleted successfully.');
    }

    /**
     * Update the verification status of a certification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'verification_status' => 'required|in:pending,verified,rejected',
        ]);

        $certification = $this->certificationRepository->findById($id);
        $this->certificationRepository->updateStatus($certification, $request->verification_status);

        return redirect()->route('admin.certifications.show', $id)
            ->with('success', 'Certification status updated successfully.');
    }
}
