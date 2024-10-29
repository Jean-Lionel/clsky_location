<!-- resources/views/client/reservations/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Mes réservations</h2>

    @if($reservations->isEmpty())
        <div class="alert alert-info">
            Vous n'avez pas encore de réservations.
        </div>
    @else
        <div class="row">
            @foreach($reservations as $reservation)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        @if($reservation->property->featured_image)
                            <img src="{{ Storage::url($reservation->property->featured_image) }}"
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover;"
                                 alt="{{ $reservation->property->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $reservation->property->title }}</h5>
                            <p class="card-text">
                                <small class="text-muted">
                                    Du {{ $reservation->check_in->format('d/m/Y') }}
                                    au {{ $reservation->check_out->format('d/m/Y') }}
                                </small>
                            </p>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-{{ $reservation->status_color }}">
                                    {{ $reservation->status_label }}
                                </span>
                                <span class="fw-bold">{{ number_format($reservation->total_price, 2) }} €</span>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{ route('client.reservations.show', $reservation) }}"
                                   class="btn btn-outline-primary btn-sm">
                                    Détails
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $reservations->links() }}
    @endif
</div>
@endsection
