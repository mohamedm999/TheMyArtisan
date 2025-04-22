<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certifications = Certification::with('user')->orderBy('created_at', 'desc')->paginate(10);
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
            'user_id' => 'required|exists:users,id',
            'verification_status' => 'required|in:pending,verified,rejected',
        ]);

        Certification::create($request->all());

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
        $certification = Certification::with('user')->findOrFail($id);
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
        $certification = Certification::findOrFail($id);
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

        $certification = Certification::findOrFail($id);
        $certification->update($request->all());

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
        $certification = Certification::findOrFail($id);
        $certification->delete();

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

        $certification = Certification::findOrFail($id);
        $certification->verification_status = $request->verification_status;
        $certification->save();

        return redirect()->route('admin.certifications.show', $id)
            ->with('success', 'Certification status updated successfully.');
    }
}
