/**
* Toggle the availability status of the artisan.
*
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\Response
*/
public function toggleAvailability(Request $request)
{
try {
$artisanProfile = auth()->user()->artisanProfile;

if (!$artisanProfile) {
return redirect()->back()->with('error', 'Artisan profile not found.');
}

// Toggle the availability status
$artisanProfile->is_available = !$artisanProfile->is_available;
$artisanProfile->save();

$status = $artisanProfile->is_available ? 'available' : 'unavailable';

return redirect()->back()->with('success', "Your status has been updated. You are now marked as {$status}.");
} catch (\Exception $e) {
\Log::error('Error toggling availability: ' . $e->getMessage());
return redirect()->back()->with('error', 'An error occurred while updating your availability status.');
}
}