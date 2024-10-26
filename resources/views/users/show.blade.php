@extends('layouts.admin')

@section('title', 'Détails de l\'Utilisateur')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 text-gray-800">Détails de l'Utilisateur</h1>
                <div>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary me-2">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            @if($user->avatar)
                                <img src="{{ asset('storage/'.$user->avatar) }}" 
                                     class="rounded-circle img-thumbnail mb-3" 
                                     width="150" height="150" 
                                     alt="{{ $user->name }}">
                            @else
                                <div class="rounded-circle bg-gray-200 text-gray-600 d-flex align-items-center justify-content-center mx-auto mb-3" 
                                     style="width: 150px; height: 150px; font-size: 3rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h4>{{ $user->name }}</h4>
                            <p class="text-gray-500 mb-2">{{ $user->email }}</p>
                            <div class="mb-2">
                                <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'agent' ? 'warning' : 'info') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'secondary' }} ms-2">
                                    {{ $user->status == 'active' ? 'Actif' : 'Inactif' }}
                                </span>
                            </div>
                            <p class="mb-1"><strong>Téléphone:</strong> {{ $user->phone ?? 'Non renseigné' }}</p>
                            <p class="mb-0"><strong>Adresse:</strong> {{ $user->address ?? 'Non renseignée' }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Informations supplémentaires</h5>
                            <p><strong>Date d'inscription:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Dernière modification:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Email vérifié:</strong> 
                                @if($user->email_verified_at)
                                    <span class="text-success">
                                        <i class="bi bi-check-circle"></i> 
                                        Le {{ $user->email_verified_at->format('d/m/Y H:i') }}
                                    </span>
                                @else
                                    <span class="text-danger">
                                        <i class="bi bi-x-circle"></i> 
                                        Non vérifié
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">Statistiques</h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h3 class="mb-1">{{ $user->reservations_count ?? 0 }}</h3>
                                            <small class="text-gray-500">Réservations</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h3 class="mb-1">{{ $user->properties_count ?? 0 }}</h3>
                                            <small class="text-gray-500">Propriétés</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection