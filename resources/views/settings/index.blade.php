@extends('layouts.admin')

@section('title', 'Paramètres - CL SKY APARTMENT')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h3 mb-3">Paramètres</h1>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Paramètres Généraux -->
                        <h5 class="mb-4">Paramètres Généraux</h5>
                        <div class="mb-4">
                            <label class="form-label">Nom de l'entreprise</label>
                            <input type="text" class="form-control" name="company_name" value="CL SKY APARTMENT">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Email de contact</label>
                            <input type="email" class="form-control" name="contact_email" value="contact@clsky.com">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Téléphone</label>
                            <input type="text" class="form-control" name="phone" value="+33 1 23 45 67 89">
                        </div>

                        <hr class="my-4">

                        <!-- Paramètres de Réservation -->
                        <h5 class="mb-4">Paramètres de Réservation</h5>
                        <div class="mb-4">
                            <label class="form-label">Heure d'arrivée par défaut</label>
                            <input type="time" class="form-control" name="default_check_in" value="14:00">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Heure de départ par défaut</label>
                            <input type="time" class="form-control" name="default_check_out" value="11:00">
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="auto_confirm" id="auto_confirm">
                                <label class="form-check-label" for="auto_confirm">
                                    Confirmation automatique des réservations
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Paramètres de Notification -->
                        <h5 class="mb-4">Paramètres de Notification</h5>
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="email_notifications" id="email_notifications" checked>
                                <label class="form-check-label" for="email_notifications">
                                    Activer les notifications par email
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sms_notifications" id="sms_notifications">
                                <label class="form-check-label" for="sms_notifications">
                                    Activer les notifications par SMS
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Enregistrer les modifications
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection