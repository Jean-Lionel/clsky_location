<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = auth()->user()->payments()
            ->with(['reservation.property'])
            ->latest()
            ->paginate(10);

        return view('client.payments.index', compact('payments'));
    }

    public function pay(Request $request, Reservation $reservation)
    {
        $this->authorize('pay', $reservation);

        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Cette réservation ne peut pas être payée.');
        }

        // Vérifier que le paiement n'existe pas déjà
        if ($reservation->payment()->exists()) {
            return back()->with('error', 'Un paiement existe déjà pour cette réservation.');
        }

        return view('client.payments.pay', compact('reservation'));
    }

    public function processPayment(Request $request, Reservation $reservation)
    {
        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $reservation->total_price * 100,
                'currency' => 'eur',
                'payment_method_types' => ['card'],
                'metadata' => [
                    'reservation_id' => $reservation->id,
                    'property_id' => $reservation->property_id
                ]
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);

        return view('client.payments.show', compact('payment'));
    }
}
