// ...existing code...

// Find instances where workExperiences are being queried and ensure they use artisan_profile_id
// For example, if you have code like this:
$workExperiences = WorkExperience::where('artisan_profiles_id', $artisanProfile->id)->get();

// Change it to:
$workExperiences = WorkExperience::where('artisan_profile_id', $artisanProfile->id)->get();

// ...existing code...
