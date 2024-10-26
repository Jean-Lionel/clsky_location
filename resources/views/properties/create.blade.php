{{-- resources/views/properties/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Détails de la Propriété')

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">{{ $property->title }}</h1>
        <div>
            <a href="{{ route('properties.edit', $property) }}" class="btn btn-primary me-2">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Galerie d'images -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-body">
                    @if($property->images->count() > 0)
                        <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($property->images as $image)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img src="{{ Storage::url($image->image_path) }}" 
                                             class="d-block w-100" 
                                             alt="Image de la propriété"
                                             style="height: 400px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Précédent</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Suivant</span>
                            </button>
                        </div>
                    @else
                        <div class="text-center py-5 bg-light">
                            <i class="bi bi-image fs-1 text-gray-400"></i>
                            <p class="mt-2 text-gray-500">Aucune image disponible</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informations principales -->
        <div class="col-md-4 mb-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Informations principales</h5>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Prix</span>
                            <span class="fw-bold">{{ number_format($property->price) }} €</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Type</span>
                            <span class="badge bg-info">{{ $property->type }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Statut</span>
                            <span class="badge bg-{{ $property->status_color }}">{{ $property->status }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Surface</span>
                            <span>{{ $property->area }} m²</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Chambres</span>
                            <span>{{ $property->bedrooms }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Salles de bain</span>
                            <span>{{ $property->bathrooms }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Étage</span>
                            <span>{{ $property->floor ?? 'RDC' }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Meublé</span>
                            <span>{!! $property->furnished ? '<i class="bi bi-check-lg text-success"></i>' : '<i class="bi bi-x-lg text-danger"></i>' !!}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Localisation</h5>
                    <address class="mb-0">
                        {{ $property->address }}<br>
                        {{ $property->postal_code }} {{ $property->city }}<br>
                        {{ $property->country }}
                    </address>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Description</h5>
                    <p class="card-text">{{ $property->description }}</p>
                </div>
            </div>
        </div>

        <!-- Réservations -->
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Réservations</h5>
                    <button class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-lg"></i> Nouvelle réservation
                    </button>
                </div>
                <div class="card-body">
                    @if($property->reservations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Date début</th>
                                        <th>Date fin</th>
                                        <th>Statut</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($property->reservations as $reservation)
                                        <tr>
                                            <td>{{ $reservation->user->name }}</td>
                                            <td>{{ $reservation->check_in }}</td>
                                            <td>{{ $reservation->check_out }}</td>
                                            <td>
                                                <span class="badge bg-{{ $reservation->status_color }}">
                                                    {{ $reservation->status }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($reservation->total_price) }} €</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x fs-1 text-gray-400"></i>
                            <p class="mt-2 text-gray-500">Aucune réservation pour le moment</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection