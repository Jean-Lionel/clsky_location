<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['reservation', 'reservation.property'])
            ->where('user_id', Auth::id());

        // Check if a status query exists
        if ($request->has('status') && $request->status != '') {
            $status = $request->status;
            $query->where('status', 'like', "%{$status}%");
        }

        $payments = $query->latest()->paginate(10);

        return view('client.payments.index', compact('payments'));
    }



    public function show(Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        return view('client.payments.show', compact('payment'));
    }

    public function initiate(Reservation $reservation)
    {
        try {
            // Vérifier que l'utilisateur est autorisé
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        // Vérifier que la réservation n'est pas déjà payée
        if ($reservation->isFullyPaid()) {
            return redirect()
                ->route('client.reservations.show', $reservation)
                ->with('error', 'Cette réservation a déjà été payée.');
        }

        return view('client.payments.checkout', compact('reservation'));
        } catch (\Throwable $th) {
               dd($th);
        }

    }

    public function pay(Request $request, Reservation $reservation)
    {
        // Validation des données
        $validated = $request->validate([
            'payment_method' => 'required|in:card,bank_transfer,cash',
            'transaction_id' => 'required|string|max:50',
            'sender_name' => 'required|string|max:255',
            'sender_phone' => 'required|string|max:20',
            'transfer_date' => 'required|date',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            // Créer le paiement
            $payment = Payment::create([
                'reservation_id' => $reservation->id,
                'user_id' => Auth::id(),
                'amount' => $reservation->total_price,
                'payment_method' => $validated['payment_method'],
                'transaction_id' => $validated['transaction_id'],
                'status' => 'pending', // Le paiement doit être vérifié manuellement
                'metadata' => [
                    'sender_name' => $validated['sender_name'],
                    'sender_phone' => $validated['sender_phone'],
                    'transfer_date' => $validated['transfer_date'],
                    'notes' => $validated['notes']
                ]
            ]);

            // Mettre à jour le statut de la réservation
            $reservation->update(['status' => 'pending']);

            // Notifier l'administrateur (à implémenter selon vos besoins)
            // Notification::send($admins, new NewPaymentNotification($payment));

            return redirect()
                ->route('client.reservations.show', $reservation)
                ->with('success', 'Votre paiement a été enregistré et est en cours de vérification. Nous vous notifierons une fois la confirmation effectuée.');

        } catch (\Exception $e) {
            dd($e);
            // return back()
            //     ->with('error', 'Une erreur est survenue lors de l\'enregistrement du paiement. Veuillez réessayer.')
            //     ->withInput();
        }
    }
}
