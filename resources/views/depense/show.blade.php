@extends('layouts.admin')

@section('title', 'Détails de la Dépense')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Détails de la Dépense</h1>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Titre:</strong> {{ $depense->titre }}</p>
            <p><strong>Montant:</strong> {{ number_format($depense->montant, 2) }} €</p>
            <p><strong>Date:</strong> {{ $depense->date_depense->format('d/m/Y') }}</p>
            <p><strong>Catégorie:</strong> {{ $depense->categorie }}</p>
            <a href="{{ route('depenses.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
@endsection
