<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Reservation;
use App\Models\Payment;
use App\Services\ReportsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

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


    private function getReservationsByType()
    {
        return Property::select('type')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN reservations.created_at >= ? THEN 1 ELSE 0 END) as reservations_count', [now()->subMonths(6)])
            ->leftJoin('reservations', 'properties.id', '=', 'reservations.property_id')
            ->groupBy('type')
            ->get();
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
        $period = $request->get('period', 'month');
        $format = $request->get('format', 'pdf');
        $startDate = $this->getStartDate($period);

        $data = [
            'period' => [
                'start' => $startDate->format('d/m/Y'),
                'end' => now()->format('d/m/Y'),
            ],
            'stats' => [
                'total_revenue' => Payment::where('status', 'completed')
                    ->whereBetween('created_at', [$startDate, now()])
                    ->sum('amount'),

                'total_reservations' => Reservation::whereBetween('created_at', [$startDate, now()])
                    ->count(),

                'average_occupancy' => $this->calculateOccupancyRate($startDate, now()),

                'new_customers' => Reservation::whereBetween('created_at', [$startDate, now()])
                    ->distinct('user_id')
                    ->count()
            ],
            'reservations' => Reservation::with(['property', 'user'])
                ->whereBetween('created_at', [$startDate, now()])
                ->get(),

            'revenue_by_month' => $this->getRevenueByMonth(),
            'occupancy_by_property' => $this->getOccupancyByProperty()
        ];

        if ($format === 'pdf') {
            return $this->exportPDF($data);
        } else {
            return $this->exportExcel($data);
        }
    }

    protected function exportPDF($data)
    {
        $pdf = Pdf::loadView('reports.pdf', $data);

        return $pdf->download('rapport-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function exportExcel($data)
    {
        return Excel::download(
            new ReportsExport($data),
            'rapport-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
    private function getRevenueByMonth()
    {
    return Payment::where('status', 'completed')
        ->where('created_at', '>=', now()->subMonths(6))
        ->select(\DB::raw('MONTH(created_at) as month'))
        ->selectRaw('SUM(amount) as total')
        ->groupBy(\DB::raw('MONTH(created_at)'))
        ->orderBy('month')
        ->get()
        ->map(function ($item) {
            return [
                'month' => Carbon::create()->month($item->month)->format('F'),
                'total' => $item->total
            ];
        });
}

    private function getOccupancyByProperty()
    {
    return Property::select('properties.id', 'properties.title')
        ->selectRaw('
            COALESCE(
                SUM(DATEDIFF(
                    LEAST(reservations.check_out, ?),
                    GREATEST(reservations.check_in, ?)
                )) / ?, 0
            ) * 100 as rate
        ', [
            now(),
            now()->subMonths(6),
            now()->diffInDays(now()->subMonths(6))
        ])
        ->leftJoin('reservations', function($join) {
            $join->on('properties.id', '=', 'reservations.property_id')
                ->where('reservations.status', '=', 'confirmed')
                ->where('reservations.check_out', '>=', now()->subMonths(6))
                ->where('reservations.check_in', '<=', now());
        })
        ->groupBy('properties.id', 'properties.title')
        ->get()
        ->map(function ($property) {
            return [
                'name' => $property->title,
                'rate' => round($property->rate, 2)
            ];
        });
    }

}
