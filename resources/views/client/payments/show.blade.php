@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <a href="{{ route('client.payments.index') }}" class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Retour aux paiements
                </a>
            </div>

            <!-- Détails du paiement -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Détails du paiement #{{ $payment->id }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1">
                                <strong class="text-muted">Date :</strong><br>
                                {{ $payment->created_at->format('d/m/Y H:i') }}
                            </p>
                            <p class="mb-1">
                                <strong class="text-muted">Méthode :</strong><br>
                                {{ ucfirst($payment->payment_method) }}
                            </p>
                            <p class="mb-1">
                                <strong class="text-muted">Transaction ID :</strong><br>
                                {{ $payment->transaction_id }}
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-1">
                                <strong class="text-muted">Montant :</strong><br>
                                <span class="h3">{{ number_format($payment->amount, 2) }} €</span>
                            </p>
                            <p class="mb-0">
                                <strong class="text-muted">Statut :</strong><br>
                                <span class="badge bg-{{ $payment->status_color }}">
                                    {{ $payment->status_text }}
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($payment->metadata)
                        <div class="border-top pt-4">
                            <h6 class="mb-3">Informations complémentaires</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <strong class="text-muted">Nom de l'expéditeur :</strong><br>
                                        {{ $payment->metadata['sender_name'] ?? 'N/A' }}
                                    </p>
                                    <p class="mb-1">
                                        <strong class="text-muted">Téléphone :</strong><br>
                                        {{ $payment->metadata['sender_phone'] ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <strong class="text-muted">Date du transfert :</strong><br>
                                        {{ isset($payment->metadata['transfer_date']) ?
                                            \Carbon\Carbon::parse($payment->metadata['transfer_date'])->format('d/m/Y H:i') :
                                            'N/A' }}
                                    </p>
                                    @if(isset($payment->metadata['notes']))
                                        <p class="mb-1">
                                            <strong class="text-muted">Notes :</strong><br>
                                            {{ $payment->metadata['notes'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Détails de la réservation associée -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Réservation associée</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6>{{ $payment->reservation->property->titre }}</h6>
                            <p class="text-muted mb-1">
                                Du {{ $payment->reservation->check_in->format('d/m/Y') }}
                                au {{ $payment->reservation->check_out->format('d/m/Y') }}
                            </p>
                            <p class="mb-0">
                                {{ $payment->reservation->guests }} voyageurs
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="{{ route('client.reservations.show', $payment->reservation) }}"
                               class="btn btn-outline-primary">
                                Voir la réservation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
