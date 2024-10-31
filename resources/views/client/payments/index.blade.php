@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">Historique des paiements</h2>
        </div>
        <div class="col-md-4">
            <!-- Filtres -->
            <form action="{{ route('client.payments.index') }}" method="GET" class="d-flex">
                <select name="status" class="form-select me-2">
                    <option value="">Tous les statuts</option>
                    @foreach(['pending' => 'En attente', 'completed' => 'Complété', 'failed' => 'Échoué', 'refunded' => 'Remboursé'] as $value => $label)
                        <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </form>
        </div>
    </div>

    <!-- Résumé des paiements -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total payé</h6>
                    <h3 class="mb-0">
                        {{ number_format($payments->where('status', 'completed')->sum('amount'), 2) }} €
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h6 class="card-title">En attente</h6>
                    <h3 class="mb-0">
                        {{ number_format($payments->where('status', 'pending')->sum('amount'), 2) }} €
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">Nombre de transactions</h6>
                    <h3 class="mb-0">{{ $payments->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Dernière transaction</h6>
                    <h3 class="mb-0">
                        {{ $payments->first() ? $payments->first()->created_at->format('d/m/Y') : 'N/A' }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des paiements -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Réservation</th>
                            <th>Méthode</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>#{{ $payment->id }}</td>
                                <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('client.reservations.show', $payment->reservation_id) }}"
                                       class="text-decoration-none">
                                        {{ $payment->reservation->property->title }}
                                    </a>
                                </td>
                                <td>
                                    @if($payment->payment_method === 'bank_transfer')
                                        <i class="bi bi-bank"></i> Bank Transfer
                                    @elseif($payment->payment_method === 'card')
                                        <i class="bi bi-phone"></i> Card Transfer
                                    @elseif($payment->payment_method === 'cash')
                                        <i class="bi bi-money"></i> Cash Transfer
                                    @endif
                                </td>
                                <td>{{ number_format($payment->amount, 2) }} €</td>
                                <td>
                                    <span class="badge bg-{{ $payment->status_color }}">
                                        {{ $payment->status_text }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('client.payments.show', $payment) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Détails
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-credit-card display-4 text-muted mb-3"></i>
                                        <h5>Aucun paiement trouvé</h5>
                                        <p class="text-muted">Vous n'avez pas encore effectué de paiement.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($payments->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 8px;
    margin-bottom: 1rem;
}
.table th {
    border-top: none;
    background-color: #f8f9fa;
}
.badge {
    padding: 0.5em 1em;
    font-weight: 500;
}
.bi {
    margin-right: 0.25rem;
}
</style>
@endsection
