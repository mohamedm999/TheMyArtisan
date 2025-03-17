<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Certification;
use App\Models\WorkExperience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Schema\Blueprint;

class ArtisanProfileController extends Controller
{
    /**
     * Show the artisan profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        // Check if work_experiences table has artisan_profile_id column
        $workExperiences = [];
        $certifications = [];
        $debugInfo = [];

        try {
            // Debug database structure
            $debugInfo['tables_exist'] = [
                'work_experiences' => Schema::hasTable('work_experiences'),
                'certifications' => Schema::hasTable('certifications')
            ];

            if (Schema::hasTable('work_experiences')) {
                $debugInfo['work_experiences_columns'] = Schema::getColumnListing('work_experiences');
            }

            if (Schema::hasTable('certifications')) {
                $debugInfo['certifications_columns'] = Schema::getColumnListing('certifications');
            }

            if ($artisanProfile) {
                $debugInfo['artisan_profile'] = [
                    'id' => $artisanProfile->id,
                    'user_id' => $artisanProfile->user_id
                ];

                // Debug queries
                if (Schema::hasTable('work_experiences')) {
                    // Log the raw SQL query
                    $query = WorkExperience::where('artisan_profile_id', $artisanProfile->id);
                    $debugInfo['work_exp_query'] = $query->toSql();
                    $debugInfo['work_exp_bindings'] = $query->getBindings();

                    // Get all work experiences
                    $workExperiences = $query->get();
                    $debugInfo['work_experiences_count'] = $workExperiences->count();
                    $debugInfo['work_experiences_data'] = $workExperiences->toArray();

                    Log::info("Work experiences found: " . json_encode($debugInfo['work_experiences_data']));
                }

                if (Schema::hasTable('certifications')) {
                    // Log the raw SQL query
                    $query = Certification::where('artisan_profile_id', $artisanProfile->id);
                    $debugInfo['cert_query'] = $query->toSql();
                    $debugInfo['cert_bindings'] = $query->getBindings();

                    // Get all certifications
                    $certifications = $query->get();
                    $debugInfo['certifications_count'] = $certifications->count();
                    $debugInfo['certifications_data'] = $certifications->toArray();

                    Log::info("Certifications found: " . json_encode($debugInfo['certifications_data']));
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to fetch work experiences or certifications: " . $e->getMessage());
            $debugInfo['error'] = $e->getMessage();
            $debugInfo['trace'] = $e->getTraceAsString();
        }

        return view('artisan.profile', compact('artisanProfile', 'workExperiences', 'certifications', 'debugInfo'));
    }

    /**
     * Update professional information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfessionalInfo(Request $request)
    {
        $request->validate([
            'profession' => 'required|string|max:255',
            'about_me' => 'nullable|string',
            'skills' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
        ]);

        $user = Auth::user();

        // Find or create artisan profile
        $artisanProfile = ArtisanProfile::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        // Update professional info
        $artisanProfile->profession = $request->profession;
        $artisanProfile->about_me = $request->about_me;

        // Handle skills as JSON array
        $skills = $request->skills ? array_map('trim', explode(',', $request->skills)) : [];
        $artisanProfile->skills = $skills; // This will be stored as JSON

        $artisanProfile->experience_years = $request->experience_years;
        $artisanProfile->hourly_rate = $request->hourly_rate;
        $artisanProfile->save();

        return redirect()->route('artisan.profile')->with('success', 'Professional information updated successfully.');
    }

    /**
     * Add work experience.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addWorkExperience(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'company' => 'nullable|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_current' => 'nullable|boolean',
                'description' => 'nullable|string',
            ]);

            $user = Auth::user();

            // Find or create artisan profile
            $artisanProfile = ArtisanProfile::firstOrCreate(
                ['user_id' => $user->id],
                []
            );

            // Log request and profile data
            Log::info("Adding work experience - Request details:", [
                'artisan_profile_id' => $artisanProfile->id,
                'user_id' => $user->id,
                'title' => $request->title,
                'company' => $request->company,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_current' => $request->has('is_current'),
            ]);

            // Create work experience - ensure all required fields are explicitly set
            $workExp = new WorkExperience();
            $workExp->artisan_profile_id = $artisanProfile->id;
            $workExp->user_id = $user->id;
            $workExp->position = $request->title;
            $workExp->company_name = $request->company;
            $workExp->start_date = $request->start_date;
            $workExp->end_date = $request->has('is_current') ? null : $request->end_date;
            $workExp->is_current = $request->has('is_current') ? 1 : 0;  // Ensure boolean is properly formatted
            $workExp->description = $request->description;

            // Add error handling for save operation
            try {
                $saveResult = $workExp->save();
                Log::info("Work experience save result: " . ($saveResult ? "Success" : "Failed"));
            } catch (\Exception $saveEx) {
                Log::error("Error saving work experience: " . $saveEx->getMessage());
                throw $saveEx;  // Re-throw to be caught by outer catch
            }

            Log::info("Work experience created successfully for artisan {$artisanProfile->id} with ID: {$workExp->id}");

            return redirect()->route('artisan.profile')->with('success', 'Work experience added successfully.');
        } catch (\Exception $e) {
            Log::error("Error adding work experience: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
            Log::error("Stack trace: " . $e->getTraceAsString());
            return redirect()->route('artisan.profile')->with('error', 'Failed to add work experience. Error: ' . $e->getMessage());
        }
    }

    /**
     * Add certification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addCertification(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'issuing_organization' => 'required|string|max:255',
                'expiry_date' => 'nullable|date',
            ]);

            $user = Auth::user();

            // Find or create artisan profile
            $artisanProfile = ArtisanProfile::firstOrCreate(
                ['user_id' => $user->id],
                []
            );

            // Double-check that we have tables and required fields
            if (!Schema::hasTable('certifications')) {
                // Create the table on-the-fly if it doesn't exist
                Schema::create('certifications', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('artisan_profile_id');
                    $table->string('title');
                    $table->string('issuing_organization');
                    $table->date('issue_date');
                    $table->date('expiry_date')->nullable();
                    $table->string('credential_id')->nullable();
                    $table->string('credential_url')->nullable();
                    $table->text('description')->nullable();
                    $table->timestamps();

                    $table->foreign('artisan_profile_id')
                        ->references('id')
                        ->on('artisan_profiles')
                        ->onDelete('cascade');
                });

                Log::info('Created certifications table');
            }

            // Log more details before saving
            Log::info("About to save certification for artisan profile ID: {$artisanProfile->id}");
            Log::info("Certification data:", [
                'title' => $request->title,
                'issuing_organization' => $request->issuing_organization
            ]);

            // Create certification - using the correct column names from the database
            $certification = new Certification();
            $certification->artisan_profile_id = $artisanProfile->id;
            $certification->user_id = $user->id;  // Set the user_id field that exists in the database
            $certification->name = $request->title;  // Map 'title' field to 'name' column
            $certification->issuer = $request->issuing_organization;  // Map 'issuing_organization' field to 'issuer' column
            $certification->valid_until = $request->expiry_date;  // Map 'expiry_date' field to 'valid_until' column
            $certification->save();

            Log::info("Certification created successfully for artisan {$artisanProfile->id} with ID: {$certification->id}");

            return redirect()->route('artisan.profile')->with('success', 'Certification added successfully.');
        } catch (\Exception $e) {
            Log::error("Error adding certification: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
            return redirect()->route('artisan.profile')->with('error', 'Failed to add certification. Error: ' . $e->getMessage());
        }
    }

    /**
     * Delete certification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCertification($id)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if ($artisanProfile) {
            $certification = Certification::where('id', $id)
                ->where('artisan_profile_id', $artisanProfile->id)
                ->first();

            if ($certification) {
                $certification->delete();
                return redirect()->route('artisan.profile')->with('success', 'Certification deleted successfully.');
            }
        }

        return redirect()->route('artisan.profile')->with('error', 'Certification not found.');
    }

    /**
     * Update contact information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateContactInfo(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();

        // Find or create artisan profile
        $artisanProfile = ArtisanProfile::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        // Update contact info
        $artisanProfile->phone = $request->phone;
        $artisanProfile->address = $request->address;
        $artisanProfile->city = $request->city;
        $artisanProfile->country = $request->country;
        $artisanProfile->postal_code = $request->postal_code;
        $artisanProfile->save();

        return redirect()->route('artisan.profile')->with('success', 'Contact information updated successfully.');
    }

    /**
     * Update business information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateBusinessInfo(Request $request)
    {
        $request->validate([
            'business_name' => 'nullable|string|max:255',
            'business_registration_number' => 'nullable|string|max:50',
            'insurance_details' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Find or create artisan profile
        $artisanProfile = ArtisanProfile::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        // Update business info
        $artisanProfile->business_name = $request->business_name;
        $artisanProfile->business_registration_number = $request->business_registration_number;
        $artisanProfile->insurance_details = $request->insurance_details;
        $artisanProfile->save();

        return redirect()->route('artisan.profile')->with('success', 'Business information updated successfully.');
    }

    /**
     * Update profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Find or create artisan profile
        $artisanProfile = ArtisanProfile::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        // Handle file upload
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($artisanProfile->profile_photo) {
                Storage::disk('public')->delete($artisanProfile->profile_photo);
            }

            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $artisanProfile->profile_photo = $path;
            $artisanProfile->save();
        }

        return redirect()->route('artisan.profile')->with('success', 'Profile photo updated successfully.');
    }
}
