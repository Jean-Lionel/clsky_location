@extends('layouts.admin')

@section('title', 'Ajouter une Dépense')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Ajouter une Dépense</h1>

    <form action="{{ route('depenses.store') }}" method="POST" class="card mb-4">
        @csrf
        <div class="card-body">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="montant" class="form-label">Montant</label>
                <input type="number" name="montant" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="date_depense" class="form-label">Date</label>
                <input type="date" name="date_depense" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="categorie" class="form-label">Catégorie</label>
                <input type="text" name="categorie" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
        </div>
    </form>
</div>
@endsection
