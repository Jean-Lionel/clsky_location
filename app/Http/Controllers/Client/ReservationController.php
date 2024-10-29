<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;


class ReservationController extends Controller
{
    public function index()
    {
        $reservations = auth()->user()->reservations()
            ->with(['property', 'payment'])
            ->latest()
            ->paginate(10);

        return view('client.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        return view('client.reservations.show', compact('reservation'));
    }

    public function cancel(Reservation $reservation)
    {
        $this->authorize('cancel', $reservation);

        if ($reservation->status !== 'pending' && $reservation->status !== 'confirmed') {
            return back()->with('error', 'Cette réservation ne peut pas être annulée.');
        }

        try {
            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancelled_by' => auth()->id()
            ]);

            // Si un paiement existe, initier le remboursement
            if ($reservation->payment && $reservation->payment->status === 'completed') {
                $this->initiateRefund($reservation);
            }

            // Notifier le propriétaire et le client
            $reservation->property->user->notify(new ReservationNotification($reservation, 'cancelled'));
            $reservation->user->notify(new ReservationNotification($reservation, 'cancelled'));

            return back()->with('success', 'La réservation a été annulée avec succès.');

        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'annulation.');
        }
    }

    private function initiateRefund(Reservation $reservation)
    {
        // Logique de remboursement via Stripe
    }
}
