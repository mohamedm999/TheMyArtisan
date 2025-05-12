<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Availability;
use App\Models\ArtisanProfile;
use App\Repositories\Interfaces\ScheduleRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    /**
     * The schedule repository implementation.
     *
     * @var ScheduleRepositoryInterface
     */
    protected $scheduleRepository;

    /**
     * Create a new controller instance.
     *
     * @param ScheduleRepositoryInterface $scheduleRepository
     * @return void
     */
    public function __construct(ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
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

        // Get artisan profile ID for the current user
        $userId = Auth::id();
        $artisanProfile = $this->scheduleRepository->getOrCreateArtisanProfile($userId);
        $artisanProfileId = $artisanProfile ? $artisanProfile->id : null;

        // Log debugging info
        Log::info('Fetching availabilities', [
            'user_id' => $userId,
            'artisan_profile_id' => $artisanProfileId,
            'date_range' => [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]
        ]);

        // Get availabilities using the repository
        $availabilities = $artisanProfileId
            ? $this->scheduleRepository->getAvailabilitiesInDateRange($artisanProfileId, $startDate, $endDate)
            : collect(); // Empty collection if no profile

        // Format availabilities by date using the repository
        $formattedAvailabilities = $this->scheduleRepository->formatAvailabilitiesByDate($availabilities);

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
            // Get or create artisan profile using the repository
            $artisanProfile = $this->scheduleRepository->getOrCreateArtisanProfile($userId);

            if (!$artisanProfile || !$artisanProfile->id) {
                return back()->with('error', 'Could not create availability: No artisan profile found.');
            }

            $artisanProfileId = $artisanProfile->id;
            $date = Carbon::parse($request->date);
            $startTime = $request->start_time;
            $endTime = $request->end_time;

            // Check for overlapping availabilities using the repository
            $overlapping = $this->scheduleRepository->hasOverlappingAvailabilities(
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

                // Create weekly availabilities using the repository
                $created = $this->scheduleRepository->createWeeklyAvailabilities(
                    $artisanProfileId,
                    $date,
                    $repeatUntil,
                    $startTime,
                    $endTime
                );

                return back()->with('success', $created . ' availabilities added successfully.');
            } else {
                // Create a single availability using the repository
                $this->scheduleRepository->createAvailability(
                    $artisanProfileId,
                    $date->format('Y-m-d'),
                    $startTime,
                    $endTime
                );

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
        $artisanProfile = $this->scheduleRepository->getOrCreateArtisanProfile($userId);
        $artisanProfileId = $artisanProfile ? $artisanProfile->id : null;

        if (!$artisanProfileId) {
            return response()->json(['success' => false, 'message' => 'No artisan profile found'], 404);
        }

        // Find availability using the repository
        $availability = $this->scheduleRepository->findAvailabilityForArtisan($id, $artisanProfileId);

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

        // Delete the availability using the repository
        $this->scheduleRepository->deleteAvailability($availability);

        return response()->json(['success' => true]);
    }
}
