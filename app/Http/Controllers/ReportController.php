<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);
        $endDate = now();

        // Statistiques générales
        $stats = [
            'total_revenue' => Payment::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount'),

            'total_reservations' => Reservation::whereBetween('created_at', [$startDate, $endDate])
                ->count(),

            'average_occupancy' => $this->calculateOccupancyRate($startDate, $endDate),

            'new_customers' => Reservation::whereBetween('created_at', [$startDate, $endDate])
                ->distinct('user_id')
                ->count()
        ];

        // Données pour les graphiques
        $charts = [
            'revenue_by_month' => $this->getRevenueByMonth(),
            'reservations_by_type' => $this->getReservationsByType(),
            'occupancy_by_property' => $this->getOccupancyByProperty()
        ];

        return view('reports.index', compact('stats', 'charts', 'period'));
    }

    private function getStartDate($period)
    {
        return match($period) {
            'week' => now()->subWeek(),
            'month' => now()->subMonth(),
            'quarter' => now()->subQuarter(),
            'year' => now()->subYear(),
            default => now()->subMonth()
        };
    }

    private function calculateOccupancyRate($startDate, $endDate)
    {
        $totalDays = $endDate->diffInDays($startDate);
        $totalProperties = Property::count();
        if ($totalProperties === 0) return 0;

        $occupiedDays = Reservation::where('status', 'confirmed')
            ->whereBetween('check_in', [$startDate, $endDate])
            ->orWhereBetween('check_out', [$startDate, $endDate])
            ->sum(\DB::raw('DATEDIFF(check_out, check_in)'));

        return round(($occupiedDays / ($totalDays * $totalProperties)) * 100, 2);
    }

    private function getRevenueByMonth()
    {
        return Payment::where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::create()->month($item->month)->format('F'),
                    'total' => $item->total
                ];
            });
    }

    private function getReservationsByType()
    {
        return Property::withCount(['reservations' => function ($query) {
                $query->where('created_at', '>=', now()->subMonths(6));
            }])
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->get();
    }

    private function getOccupancyByProperty()
    {
        $properties = Property::with(['reservations' => function ($query) {
                $query->where('created_at', '>=', now()->subMonths(6));
            }])
            ->get()
            ->map(function ($property) {
                return [
                    'name' => $property->title,
                    'rate' => $this->calculatePropertyOccupancy($property)
                ];
            });

        return $properties;
    }

    private function calculatePropertyOccupancy($property)
    {
        $totalDays = now()->diffInDays(now()->subMonths(6));
        if ($totalDays === 0) return 0;

        $occupiedDays = $property->reservations
            ->sum(function ($reservation) {
                return $reservation->check_in->diffInDays($reservation->check_out);
            });

        return round(($occupiedDays / $totalDays) * 100, 2);
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);

        $data = [
            'stats' => [
                'period' => $period,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => now()->format('Y-m-d'),
                'total_revenue' => Payment::where('status', 'completed')
                    ->whereBetween('created_at', [$startDate, now()])
                    ->sum('amount'),
                'total_reservations' => Reservation::whereBetween('created_at', [$startDate, now()])
                    ->count(),
                'average_occupancy' => $this->calculateOccupancyRate($startDate, now())
            ],
            'reservations' => Reservation::with(['property', 'user'])
                ->whereBetween('created_at', [$startDate, now()])
                ->get()
        ];

        return match($format) {
            'pdf' => $this->generatePdf($data),
            'excel' => $this->generateExcel($data),
            default => redirect()->back()->with('error', 'Format non supporté')
        };
    }
}
