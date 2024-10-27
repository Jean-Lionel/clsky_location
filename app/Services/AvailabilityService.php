<?php

namespace App\Services;

use App\Models\Property;
use Carbon\Carbon;

class AvailabilityService
{
    public function getSuggestions(Property $property, $numberOfSuggestions = 5)
    {
        $suggestions = [];
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addMonths(3);
        
        // Récupérer les réservations existantes
        $existingReservations = $property->reservations()
            ->where('status', '!=', 'cancelled')
            ->where('check_out', '>=', $startDate)
            ->orderBy('check_in')
            ->get(['check_in', 'check_out']);

        $currentDate = $startDate->copy();

        while ($currentDate < $endDate && count($suggestions) < $numberOfSuggestions) {
            // Suggérer des séjours de différentes durées (3, 5, 7 nuits)
            foreach ([3, 5, 7] as $duration) {
                $checkOut = $currentDate->copy()->addDays($duration);
                
                if ($this->isPeriodAvailable($currentDate, $checkOut, $existingReservations)) {
                    $suggestions[] = [
                        'checkIn' => $currentDate->format('Y-m-d'),
                        'checkOut' => $checkOut->format('Y-m-d'),
                        'nights' => $duration,
                        'totalPrice' => number_format($property->price * $duration, 2),
                        'available' => true
                    ];

                    if (count($suggestions) >= $numberOfSuggestions) {
                        break;
                    }
                }
            }

            $currentDate->addDays(1);
        }

        return $suggestions;
    }

    protected function isPeriodAvailable($start, $end, $reservations)
    {
        foreach ($reservations as $reservation) {
            if ($start->between($reservation->check_in, $reservation->check_out) ||
                $end->between($reservation->check_in, $reservation->check_out) ||
                ($start <= $reservation->check_in && $end >= $reservation->check_out)) {
                return false;
            }
        }

        return true;
    }
}
