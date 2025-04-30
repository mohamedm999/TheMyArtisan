<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\Interfaces\AvailabilityRepositoryInterface;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;

class ScheduleController extends Controller
{
    /**
     * The availability repository instance.
     *
     * @var AvailabilityRepositoryInterface
     */
    protected $availabilityRepository;

    /**
     * The artisan profile repository instance.
     *
     * @var ArtisanProfileRepositoryInterface
     */
    protected $artisanProfileRepository;

    /**
     * Create a new controller instance.
     *
     * @param AvailabilityRepositoryInterface $availabilityRepository
     * @param ArtisanProfileRepositoryInterface $artisanProfileRepository
     * @return void
     */
    public function __construct(
        AvailabilityRepositoryInterface $availabilityRepository,
        ArtisanProfileRepositoryInterface $artisanProfileRepository
    ) {
        $this->availabilityRepository = $availabilityRepository;
        $this->artisanProfileRepository = $artisanProfileRepository;
    }

    /**
     * Display the artisan's schedule.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get the selected month and year (default to current month/year)
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Create a Carbon instance for the first day of the month
        $firstDayOfMonth = Carbon::createFromDate($year, $month, 1);

        // Get the number of days in the month
        $daysInMonth = $firstDayOfMonth->daysInMonth;

        // Get the day of the week for the first day (0 = Sunday, 6 = Saturday)
        $firstDayOfWeek = $firstDayOfMonth->dayOfWeek;

        // Calculate the starting date for the calendar grid (might be in previous month)
        $startDate = $firstDayOfMonth->copy()->subDays($firstDayOfWeek);

        // Calculate the ending date (calendar shows 6 weeks = 42 days total)
        $endDate = $startDate->copy()->addDays(41);

        // Generate array of days for the calendar
        $calendarDays = [];
        $currentDate = $startDate->copy();
        $today = Carbon::today();

        // Get all availabilities for the current artisan in this date range
        $userId = Auth::id();

        // First try to get the artisan profile ID
        $artisanProfile = $this->artisanProfileRepository->findByUserId($userId);
        $artisanProfileId = $artisanProfile ? $artisanProfile->id : null;

        // Log debugging info
        Log::info('Fetching availabilities', [
            'user_id' => $userId,
            'artisan_profile_id' => $artisanProfileId,
            'date_range' => [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]
        ]);

        // Get availabilities using repository
        $availabilities = $artisanProfileId 
            ? $this->availabilityRepository->getAvailabilitiesByDateRange($artisanProfileId, $startDate, $endDate)
            : collect(); // Empty collection if no profile

        // Manually group availabilities by date string
        $formattedAvailabilities = [];

        foreach ($availabilities as $availability) {
            // Use the string format of the date as the key
            $dateKey = $availability->date->format('Y-m-d');

            if (!isset($formattedAvailabilities[$dateKey])) {
                $formattedAvailabilities[$dateKey] = [];
            }

            $formattedAvailabilities[$dateKey][] = [
                'id' => $availability->id,
                'start_time' => Carbon::parse($availability->start_time)->format('H:i'),
                'end_time' => Carbon::parse($availability->end_time)->format('H:i'),
                'status' => $availability->status,
            ];
        }

        // Build calendar days array
        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('Y-m-d');

            $calendarDays[] = [
                'date' => $dateString,
                'day' => $currentDate->day,
                'current_month' => $currentDate->month == $month,
                'today' => $currentDate->isSameDay($today),
                'availabilities' => $formattedAvailabilities[$dateString] ?? [],
            ];

            $currentDate->addDay();
        }

        return view('artisan.schedule', compact('calendarDays', 'month', 'year'));
    }

    /**
     * Store a new availability.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'repeat' => 'required|in:none,weekly',
            'repeat_until' => 'nullable|date|required_if:repeat,weekly',
        ]);

        $userId = Auth::id();

        try {
            // Get or create artisan profile
            $artisanProfile = $this->artisanProfileRepository->findByUserId($userId);

            if (!$artisanProfile) {
                // Create a basic artisan profile if none exists
                $artisanProfile = $this->artisanProfileRepository->create([
                    'user_id' => $userId
                ]);
            }

            $artisanProfileId = $artisanProfile->id;

            if (!$artisanProfileId) {
                return back()->with('error', 'Could not create availability: No artisan profile found.');
            }

            $date = Carbon::parse($request->date);
            $startTime = $request->start_time;
            $endTime = $request->end_time;

            // Check for overlapping availabilities using repository
            $overlapping = $this->availabilityRepository->checkOverlappingAvailabilities(
                $artisanProfileId,
                $date->format('Y-m-d'),
                $startTime,
                $endTime
            );

            if ($overlapping) {
                return back()->with('error', 'The selected time overlaps with an existing availability.');
            }

            // If repeating, create multiple availability records
            if ($request->repeat === 'weekly') {
                $repeatUntil = Carbon::parse($request->repeat_until);
                $currentDate = $date->copy();
                $created = 0;

                while ($currentDate <= $repeatUntil) {
                    $this->availabilityRepository->create([
                        'artisan_profile_id' => $artisanProfileId,
                        'date' => $currentDate->format('Y-m-d'),
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'status' => 'available',
                    ]);

                    $created++;
                    $currentDate->addWeek();
                }

                return back()->with('success', $created . ' availabilities added successfully.');
            } else {
                // Create a single availability using repository
                $this->availabilityRepository->create([
                    'artisan_profile_id' => $artisanProfileId,
                    'date' => $date->format('Y-m-d'),
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'status' => 'available',
                ]);

                return back()->with('success', 'Availability added successfully.');
            }
        } catch (\Exception $e) {
            Log::error('Failed to create availability', [
                'error' => $e->getMessage(),
                'user_id' => $userId
            ]);
            return back()->with('error', 'Could not create availability: ' . $e->getMessage());
        }
    }

    /**
     * Delete an availability.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        $artisanProfile = $this->artisanProfileRepository->findByUserId($userId);
        $artisanProfileId = $artisanProfile ? $artisanProfile->id : null;

        if (!$artisanProfileId) {
            return response()->json(['success' => false, 'message' => 'No artisan profile found'], 404);
        }

        // Find availability using repository
        $availability = $this->availabilityRepository->findByIdAndArtisanProfile($id, $artisanProfileId);

        if (!$availability) {
            return response()->json(['success' => false, 'message' => 'Availability not found'], 404);
        }

        // Only allow deletion if not booked
        if ($availability->status === 'booked') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete a booked availability.'
            ], 400);
        }

        // Delete availability using repository
        $deleted = $this->availabilityRepository->delete($availability);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the availability.'
            ], 500);
        }

        return response()->json(['success' => true]);
    }
}
