<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\CheckInOut;
use App\Models\ServiceRequest;
use App\Models\EmployeeSchedule;
use App\Models\FacilityBooking;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Facility;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // ── 1. Occupancy Report ───────────────────────────────────────
    public function occupancy(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to   = $request->input('to',   now()->toDateString());

        $records = CheckInOut::with(['room'])
            ->whereBetween('actual_check_in', [$from, $to . ' 23:59:59'])
            ->get();

        $totalRooms    = Room::count();
        $occupiedCount = $records->where('status', 'Checked-in')->count();
        $occupancyRate = $totalRooms > 0
            ? round(($occupiedCount / $totalRooms) * 100, 2)
            : 0;

        return view('reports.occupancy', compact(
            'records', 'from', 'to', 'totalRooms', 'occupiedCount', 'occupancyRate'
        ));
    }

    // ── 2. Revenue Report ─────────────────────────────────────────
    public function revenue(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to   = $request->input('to',   now()->toDateString());

        $checkouts = CheckInOut::with(['guest', 'room'])
            ->where('status', 'Checked-out')
            ->whereBetween('actual_check_out', [$from, $to . ' 23:59:59'])
            ->get();

        $facilityRevenue = FacilityBooking::where('status', 'Completed')
            ->whereBetween('booking_end', [$from, $to . ' 23:59:59'])
            ->sum('total_cost');

        $serviceRevenue  = ServiceRequest::where('status', 'Completed')
            ->whereBetween('updated_at', [$from, $to . ' 23:59:59'])
            ->sum('total_cost');

        $roomRevenue   = $checkouts->sum('total_amount');
        $totalRevenue  = $roomRevenue + $facilityRevenue + $serviceRevenue;

        return view('reports.revenue', compact(
            'checkouts', 'from', 'to',
            'roomRevenue', 'facilityRevenue', 'serviceRevenue', 'totalRevenue'
        ));
    }

    // ── 3. Service Usage Report ───────────────────────────────────
    public function serviceUsage(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to   = $request->input('to',   now()->toDateString());

        $services = Service::withCount(['requests as total_requests' => function($q) use ($from, $to) {
                $q->whereBetween('created_at', [$from, $to . ' 23:59:59']);
            }])
            ->withSum(['requests as total_quantity' => function($q) use ($from, $to) {
                $q->whereBetween('created_at', [$from, $to . ' 23:59:59']);
            }], 'quantity')
            ->withSum(['requests as total_revenue' => function($q) use ($from, $to) {
                $q->whereBetween('created_at', [$from, $to . ' 23:59:59']);
            }], 'total_cost')
            ->get();

        return view('reports.service-usage', compact('services', 'from', 'to'));
    }

    // ── 4. Employee Workload Report ───────────────────────────────
    public function employeeWorkload(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to   = $request->input('to',   now()->toDateString());

        $employees = Employee::withCount([
                'schedules as total_shifts' => function($q) use ($from, $to) {
                    $q->whereBetween('work_date', [$from, $to]);
                },
                'serviceRequests as total_services' => function($q) use ($from, $to) {
                    $q->whereBetween('created_at', [$from, $to . ' 23:59:59']);
                },
            ])
            ->get();

        return view('reports.employee-workload', compact('employees', 'from', 'to'));
    }

    // ── 5. Facility Utilization Report ────────────────────────────
    public function facilityUtilization(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to   = $request->input('to',   now()->toDateString());

        $facilities = Facility::withCount([
                'bookings as total_bookings' => function($q) use ($from, $to) {
                    $q->whereBetween('booking_start', [$from, $to . ' 23:59:59']);
                },
            ])
            ->withSum([
                'bookings as total_revenue' => function($q) use ($from, $to) {
                    $q->whereBetween('booking_start', [$from, $to . ' 23:59:59']);
                },
            ], 'total_cost')
            ->withAvg([
                'bookings as avg_rating' => function($q) use ($from, $to) {
                    $q->whereBetween('booking_start', [$from, $to . ' 23:59:59'])
                      ->whereNotNull('rating');
                },
            ], 'rating')
            ->get();

        return view('reports.facility-utilization', compact('facilities', 'from', 'to'));
    }
}