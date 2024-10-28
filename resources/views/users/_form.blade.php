<div class="row g-3">
    {{-- Informations de base --}}
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   id="name"
                   name="name"
                   value="{{ old('name', $user->name ?? '') }}"
                   required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   id="email"
                   name="email"
                   value="{{ old('email', $user->email ?? '') }}"
                   required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Mot de passe --}}
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password" class="form-label">
                {{ isset($user) ? 'Nouveau mot de passe' : 'Mot de passe' }}
            </label>
            <div class="input-group">
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       id="password"
                       name="password"
                       {{ !isset($user) ? 'required' : '' }}>
                <button class="btn btn-outline-secondary"
                        type="button"
                        onclick="togglePassword('password')">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">
                {{ isset($user) ? 'Confirmer le nouveau mot de passe' : 'Confirmer le mot de passe' }}
            </label>
            <div class="input-group">
                <input type="password"
                       class="form-control"
                       id="password_confirmation"
                       name="password_confirmation"
                       {{ !isset($user) ? 'required' : '' }}>
                <button class="btn btn-outline-secondary"
                        type="button"
                        onclick="togglePassword('password_confirmation')">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Informations de contact --}}
    <div class="col-md-6">
        <div class="mb-3">
            <label for="phone" class="form-label">Téléphone</label>
            <input type="tel"
                   class="form-control @error('phone') is-invalid @enderror"
                   id="phone"
                   name="phone"
                   value="{{ old('phone', $user->phone ?? '') }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select class="form-select @error('role') is-invalid @enderror"
                    id="role"
                    name="role"
                    required>
                <option value="">Sélectionner un rôle</option>
                <option value="admin" {{ (old('role', $user->role ?? '') == 'admin') ? 'selected' : '' }}>Administrateur</option>
                <option value="agent" {{ (old('role', $user->role ?? '') == 'agent') ? 'selected' : '' }}>Agent</option>
                <option value="tenant" {{ (old('role', $user->role ?? '') == 'tenant') ? 'selected' : '' }}>Locataire</option>
                <option value="owner" {{ (old('role', $user->role ?? '') == 'owner') ? 'selected' : '' }}>Propriétaire</option>
                <option value="client" {{ (old('role', $user->role ?? '') == 'client') ? 'selected' : '' }}>Client</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Avatar --}}
    <div class="col-md-12">
        <div class="mb-3">
            <label for="avatar" class="form-label">Avatar</label>
            <input type="file"
                   class="form-control @error('avatar') is-invalid @enderror"
                   id="avatar"
                   name="avatar"
                   accept="image/*"
                   onchange="previewImage(this)">
            @error('avatar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="text-center mb-3">
            <img id="avatar-preview"
                 src="{{ isset($user) && $user->avatar ? asset('storage/' . $user->avatar) : '#' }}"
                 class="rounded-circle {{ isset($user) && $user->avatar ? '' : 'd-none' }}"
                 style="width: 100px; height: 100px; object-fit: cover;">
        </div>
    </div>

    {{-- Adresse --}}
    <div class="col-md-12">
        <div class="mb-3">
            <label for="address" class="form-label">Adresse</label>
            <textarea class="form-control @error('address') is-invalid @enderror"
                      id="address"
                      name="address"
                      rows="3">{{ old('address', $user->address ?? '') }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Statut --}}
    <div class="col-md-12">
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       type="checkbox"
                       id="status"
                       name="status"
                       value="active"
                       {{ (old('status', $user->status ?? 'active') == 'active') ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Utilisateur actif</label>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Fonction pour afficher/masquer le mot de passe
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);

        // Change l'icône
        const icon = event.currentTarget.querySelector('i');
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    }

    // Fonction pour prévisualiser l'avatar
    function previewImage(input) {
        const preview = document.getElementById('avatar-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
