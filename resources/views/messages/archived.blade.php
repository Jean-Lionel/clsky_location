@extends('layouts.admin')

@section('title', 'Messages archivés')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Messages archivés</h1>
        <div>
            <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-inbox"></i> Boîte de réception
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>De</th>
                            <th>À</th>
                            <th>Sujet</th>
                            <th>Date d'archivage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $message)
                            <tr>
                                <td>{{ $message->sender->name }}</td>
                                <td>{{ $message->receiver->name }}</td>
                                <td>
                                    <a href="{{ route('messages.show', $message) }}"
                                       class="text-decoration-none">
                                        {{ $message->subject }}
                                    </a>
                                </td>

                                <td>
                                    @if ($message->archived_at)
                                        {{ \Carbon\Carbon::createFromTimestamp($message->archived_at)->format('d/m/Y H:i') }}
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('messages.show', $message) }}"
                                           class="btn btn-outline-primary"
                                           title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('messages.unarchive', $message) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-outline-success"
                                                    title="Désarchiver">
                                                <i class="bi bi-archive-fill"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('messages.destroy', $message) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-outline-danger"
                                                    title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="bi bi-archive text-muted fs-1"></i>
                                    <p class="mt-2 text-muted mb-0">Aucun message archivé</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
