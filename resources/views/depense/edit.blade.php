@extends('layouts.admin')

@section('title', 'Modifier la Dépense')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Modifier la Dépense</h1>

    <form action="{{ route('depenses.update', $depense->id) }}" method="POST" class="card mb-4">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" value="{{ $depense->titre }}" required>
            </div>
            <div class="mb-3">
                <label for="montant" class="form-label">Montant</label>
                <input type="number" name="montant" class="form-control" value="{{ $depense->montant }}" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="date_depense" class="form-label">Date</label>
                <input type="date" name="date_depense" class="form-control" value="{{ $depense->date_depense->format('Y-m-d') }}" required>
            </div>
            <div class="mb-3">
                <label for="categorie" class="form-label">Catégorie</label>
                <input type="text" name="categorie" class="form-control" value="{{ $depense->categorie }}">
            </div>
            <button type="submit" class="btn btn-warning">Mettre à Jour</button>
        </div>
    </form>
</div>
@endsection
