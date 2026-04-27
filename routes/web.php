<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ── Public routes ──────────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        $route = auth()->user()->role === 'guest' ? 'guest.dashboard' : 'dashboard';
        return redirect()->route($route);
    }
    return redirect()->route('login');
});

// ── Force logout ──────────────────────────────────────────────────
Route::get('/force-logout', function() {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

// ── Auth debug (remove after fixing) ──────────────────────────────
Route::get('/auth-debug', function() {
    return response()->json([
        'authenticated' => auth()->check(),
        'user'          => auth()->check() ? [
            'id'    => auth()->id(),
            'email' => auth()->user()->email,
            'role'  => auth()->user()->role,
        ] : null,
        'session_id'    => session()->getId(),
        'cookies'       => array_keys(request()->cookies->all()),
    ]);
});

// ── Admin routes ───────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'admin'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard', [
            'totalGuests'       => \App\Models\Guest::count(),
            'totalRooms'        => \App\Models\Room::count(),
            'totalEmployees'    => \App\Models\Employee::count(),
            'availableRooms'    => \App\Models\Room::where('status', 'Available')->count(),
            'occupiedRooms'     => \App\Models\Room::where('status', 'Occupied')->count(),
            'totalReservations' => \App\Models\Reservation::count(),
            'pendingRequests'   => \App\Models\ServiceRequest::where('status', 'Pending')->count(),
            'todayCheckins'     => \App\Models\CheckInOut::whereDate('actual_check_in', today())->count(),
        ]);
    })->name('dashboard');

    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('guests',     \App\Http\Controllers\GuestController::class);
    Route::resource('rooms',      \App\Http\Controllers\RoomController::class);
    Route::resource('employees',  \App\Http\Controllers\EmployeeController::class);
    Route::resource('services',   \App\Http\Controllers\ServiceController::class);
    Route::resource('facilities', \App\Http\Controllers\FacilityController::class);

    Route::resource('reservations', \App\Http\Controllers\ReservationController::class);

    Route::resource('checkinout', \App\Http\Controllers\CheckInOutController::class)
         ->only(['index', 'create', 'store', 'show']);
    Route::post('checkinout/{checkinout}/checkout',
        [\App\Http\Controllers\CheckInOutController::class, 'checkout'])
        ->name('checkinout.checkout');

    Route::resource('servicerequests',  \App\Http\Controllers\ServiceRequestController::class);
    Route::resource('schedules',        \App\Http\Controllers\EmployeeScheduleController::class);
    Route::resource('facilitybookings', \App\Http\Controllers\FacilityBookingController::class);

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('occupancy',            [\App\Http\Controllers\ReportController::class, 'occupancy'])           ->name('occupancy');
        Route::get('revenue',              [\App\Http\Controllers\ReportController::class, 'revenue'])             ->name('revenue');
        Route::get('service-usage',        [\App\Http\Controllers\ReportController::class, 'serviceUsage'])        ->name('service-usage');
        Route::get('employee-workload',    [\App\Http\Controllers\ReportController::class, 'employeeWorkload'])     ->name('employee-workload');
        Route::get('facility-utilization', [\App\Http\Controllers\ReportController::class, 'facilityUtilization']) ->name('facility-utilization');
    });

});

// ── Guest portal routes ────────────────────────────────────────────
Route::middleware(['auth', 'guest-portal'])->prefix('guest-portal')->name('guest.')->group(function () {
    Route::get('/dashboard',         [\App\Http\Controllers\GuestPortalController::class, 'dashboard'])         ->name('dashboard');
    Route::get('/reservations',        [\App\Http\Controllers\GuestPortalController::class, 'reservations'])        ->name('reservations');
    Route::get('/reservations/create', [\App\Http\Controllers\GuestPortalController::class, 'createReservation'])  ->name('reservations.create');
    Route::post('/reservations',       [\App\Http\Controllers\GuestPortalController::class, 'storeReservation'])   ->name('reservations.store');
    Route::get('/service-requests',  [\App\Http\Controllers\GuestPortalController::class, 'serviceRequests'])   ->name('service-requests');
    Route::post('/service-requests', [\App\Http\Controllers\GuestPortalController::class, 'storeServiceRequest'])->name('service-requests.store');
    Route::get('/facility-bookings', [\App\Http\Controllers\GuestPortalController::class, 'facilityBookings'])  ->name('facility-bookings');
    Route::post('/facility-bookings',[\App\Http\Controllers\GuestPortalController::class, 'storeFacilityBooking'])->name('facility-bookings.store');
});

require __DIR__.'/auth.php';