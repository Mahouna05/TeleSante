@extends('layouts.patient')

@section('title', 'Supprimer mon compte')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Confirmation de suppression de compte</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h5 class="alert-heading">Cette action est irréversible !</h5>
                        <p>Vous êtes sur le point de supprimer votre compte de la plateforme TéléSanté Bénin. Cette action entraînera :</p>
                        <ul>
                            <li>La désactivation immédiate de votre compte</li>
                            <li>L'impossibilité de vous reconnecter avec vos identifiants actuels</li>
                            <li>La perte d'accès à vos rendez-vous programmés</li>
                        </ul>
                        <p>Conformément à la législation, vos dossiers médicaux seront conservés pendant la durée légale de conservation.</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6>Pourquoi souhaitez-vous supprimer votre compte ?</h6>
                        <p>Votre avis nous aide à améliorer notre service.</p>
                        
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="raison_suppression" id="raison1" value="insatisfait">
                            <label class="form-check-label" for="raison1">
                                Je ne suis pas satisfait du service
                            </label>
                        </div>
                        
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="raison_suppression" id="raison2" value="difficulte">
                            <label class="form-check-label" for="raison2">
                                J'ai des difficultés à utiliser la plateforme
                            </label>
                        </div>
                        
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="raison_suppression" id="raison3" value="autre_plateforme">
                            <label class="form-check-label" for="raison3">
                                J'utilise une autre plateforme de télémédecine
                            </label>
                        </div>
                        
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="raison_suppression" id="raison4" value="confidentialite">
                            <label class="form-check-label" for="raison4">
                                Je suis préoccupé par la confidentialité de mes données
                            </label>
                        </div>
                        
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="raison_suppression" id="raison5" value="autre">
                            <label class="form-check-label" for="raison5">
                                Autre raison
                            </label>
                        </div>
                        
                        <div class="mb-3" id="autre_raison_container" style="display: none;">
                            <textarea class="form-control" id="autre_raison" rows="2" placeholder="Précisez la raison..."></textarea>
                        </div>
                    </div>
                    
                    <form action="{{ route('patient.parametres.deleteAccount') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Pour confirmer, veuillez saisir votre mot de passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="confirm_delete" name="confirm_delete" required>
                            <label class="form-check-label" for="confirm_delete">
                                Je confirme vouloir supprimer définitivement mon compte
                            </label>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('patient.parametres.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-danger" id="deleteBtn" disabled>
                                <i class="fas fa-trash-alt me-2"></i> Supprimer définitivement mon compte
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gérer l'affichage du champ "autre raison"
        const raisonAutre = document.getElementById('raison5');
        const autreRaisonContainer = document.getElementById('autre_raison_container');
        
        document.querySelectorAll('input[name="raison_suppression"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (raisonAutre.checked) {
                    autreRaisonContainer.style.display = 'block';
                } else {
                    autreRaisonContainer.style.display = 'none';
                }
            });
        });
        
        // Activer/désactiver le bouton de suppression
        const confirmCheckbox = document.getElementById('confirm_delete');
        const deleteBtn = document.getElementById('deleteBtn');
        
        confirmCheckbox.addEventListener('change', function() {
            deleteBtn.disabled = !this.checked;
        });
    });
</script>
@endsection