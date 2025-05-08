@extends('layouts.patient')

@section('title', 'Paramètres')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="text-primary">Paramètres du compte</h6>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Informations personnelles</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">Mot de passe</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="preferences-tab" data-bs-toggle="tab" data-bs-target="#preferences" type="button" role="tab" aria-controls="preferences" aria-selected="false">Préférences</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-danger" id="delete-tab" data-bs-toggle="tab" data-bs-target="#delete" type="button" role="tab" aria-controls="delete" aria-selected="false">Supprimer mon compte</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- Onglet Profil -->
                        <div class="tab-pane fade show active py-3" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <form action="{{ route('patient.parametres.updateProfile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-4 mb-3 text-center">
                                        <div class="avatar-upload">
                                            <div class="avatar-preview mb-3">
                                                <img src="{{ $user->photo_profil ? asset('storage/profils/' . $user->photo_profil) : asset('img/default-avatar.png') }}" 
                                                    alt="Photo de profil" class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" name="photo_profil" id="photo_profil" class="form-control">
                                                <small class="form-text text-muted">Format accepté: JPG, JPEG, PNG. Max 2MB.</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nom" class="form-label">Nom</label>
                                                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $user->nom) }}" required>
                                                @error('nom')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="prenom" class="form-label">Prénom</label>
                                                <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
                                                @error('prenom')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Adresse email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="telephone" class="form-label">Numéro de téléphone</label>
                                            <input type="tel" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone', $user->telephone) }}" required>
                                            @error('telephone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Onglet Mot de passe -->
                        <div class="tab-pane fade py-3" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <form action="{{ route('patient.parametres.updatePassword') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Mot de passe actuel</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nouveau mot de passe</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Minimum 8 caractères</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Mettre à jour le mot de passe</button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Onglet Préférences -->
                        <div class="tab-pane fade py-3" id="preferences" role="tabpanel" aria-labelledby="preferences-tab">
                            <form action="{{ route('patient.parametres.updatePreferences') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <!-- Extrait des préférences de l'utilisateur -->
                                @php
                                    $preferences = json_decode($user->preferences ?? '{}', true);
                                    $langue = $preferences['langue'] ?? 'fr';
                                    $format_date = $preferences['format_date'] ?? 'd/m/Y';
                                    $format_heure = $preferences['format_heure'] ?? 'H:i';
                                    $theme = $preferences['theme'] ?? 'clair';
                                @endphp
                                
                                <div class="mb-3">
                                    <label for="langue" class="form-label">Langue</label>
                                    <select class="form-select @error('langue') is-invalid @enderror" id="langue" name="langue">
                                        <option value="fr" {{ $langue == 'fr' ? 'selected' : '' }}>Français</option>
                                        <option value="en" {{ $langue == 'en' ? 'selected' : '' }}>English</option>
                                    </select>
                                    @error('langue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="format_date" class="form-label">Format de date</label>
                                    <select class="form-select @error('format_date') is-invalid @enderror" id="format_date" name="format_date">
                                        <option value="d/m/Y" {{ $format_date == 'd/m/Y' ? 'selected' : '' }}>31/12/2023 (JJ/MM/AAAA)</option>
                                        <option value="m/d/Y" {{ $format_date == 'm/d/Y' ? 'selected' : '' }}>12/31/2023 (MM/JJ/AAAA)</option>
                                        <option value="Y-m-d" {{ $format_date == 'Y-m-d' ? 'selected' : '' }}>2023-12-31 (AAAA-MM-JJ)</option>
                                    </select>
                                    @error('format_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="format_heure" class="form-label">Format d'heure</label>
                                    <select class="form-select @error('format_heure') is-invalid @enderror" id="format_heure" name="format_heure">
                                        <option value="H:i" {{ $format_heure == 'H:i' ? 'selected' : '' }}>14:30 (24h)</option>
                                        <option value="h:i A" {{ $format_heure == 'h:i A' ? 'selected' : '' }}>02:30 PM (12h)</option>
                                    </select>
                                    @error('format_heure')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="theme" class="form-label">Thème</label>
                                    <select class="form-select @error('theme') is-invalid @enderror" id="theme" name="theme">
                                        <option value="clair" {{ $theme == 'clair' ? 'selected' : '' }}>Clair</option>
                                        <option value="sombre" {{ $theme == 'sombre' ? 'selected' : '' }}>Sombre</option>
                                        <option value="auto" {{ $theme == 'auto' ? 'selected' : '' }}>Automatique (selon système)</option>
                                    </select>
                                    @error('theme')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Enregistrer les préférences</button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Onglet Supprimer le compte -->
                        <div class="tab-pane fade py-3" id="delete" role="tabpanel" aria-labelledby="delete-tab">
                            <div class="alert alert-warning">
                                <h5>Attention !</h5>
                                <p>La suppression de votre compte est irréversible. Toutes vos données personnelles seront définitivement effacées.</p>
                                <p>Vos dossiers médicaux seront conservés conformément à la législation en vigueur.</p>
                            </div>
                            
                            <div class="text-center">
                                <a href="{{ route('patient.parametres.confirmDeleteAccount') }}" class="btn btn-danger">
                                    <i class="fas fa-trash-alt me-2"></i> Supprimer mon compte
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Activer les onglets Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer l'onglet actif depuis l'URL ou les paramètres
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab');
        
        if (activeTab) {
            const tab = new bootstrap.Tab(document.querySelector(`#${activeTab}-tab`));
            tab.show();
        }
        
        // Prévisualisation de l'image de profil
        const photoInput = document.getElementById('photo_profil');
        if (photoInput) {
            photoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewImg = document.querySelector('.avatar-preview img');
                        previewImg.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endsection