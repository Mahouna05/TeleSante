@extends('layouts.patient')

@section('title', 'Contacter le Support')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="text-primary">Contacter le Support</h6>
                    <a href="{{ route('patient.aide-support.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        Besoin d'aide ?
                                    </h5>
                                    <p class="card-text">Nous sommes là pour vous aider. Veuillez nous fournir les détails de votre problème afin que nous puissions vous apporter une assistance adaptée.</p>
                                    <ul class="list-unstyled mt-4">
                                        <li class="mb-3">
                                            <strong><i class="fas fa-phone-alt text-primary me-2"></i> Téléphone :</strong>
                                            <a href="tel:+22990552154">(+229) 90 55 21 54</a>
                                        </li>
                                        <li class="mb-3">
                                            <strong><i class="fas fa-envelope text-primary me-2"></i> Email :</strong>
                                            <a href="mailto:support@telesante-benin.com">support@telesante-benin.com</a>
                                        </li>
                                        <li>
                                            <strong><i class="fas fa-clock text-primary me-2"></i> Heures d'ouverture :</strong>
                                            <p class="mb-0">Lundi - Vendredi : 8h00 - 18h00</p>
                                            <p class="mb-0">Samedi : 9h00 - 13h00</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">
                                        <i class="fas fa-paper-plane text-primary me-2"></i>
                                        Envoyer un message
                                    </h5>
                                    <form action="{{ route('patient.aide-support.envoyerMessage') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="mb-3">
                                            <label for="sujet" class="form-label">Sujet</label>
                                            <select class="form-select @error('sujet') is-invalid @enderror" id="sujet" name="sujet" required>
                                                <option value="" selected disabled>Sélectionner un sujet</option>
                                                <option value="question" {{ old('sujet') == 'question' ? 'selected' : '' }}>Question générale</option>
                                                <option value="probleme_technique" {{ old('sujet') == 'probleme_technique' ? 'selected' : '' }}>Problème technique</option>
                                                <option value="rendez_vous" {{ old('sujet') == 'rendez_vous' ? 'selected' : '' }}>Rendez-vous</option>
                                                <option value="paiement" {{ old('sujet') == 'paiement' ? 'selected' : '' }}>Paiement</option>
                                                <option value="suggestion" {{ old('sujet') == 'suggestion' ? 'selected' : '' }}>Suggestion</option>
                                                <option value="autre" {{ old('sujet') == 'autre' ? 'selected' : '' }}>Autre</option>
                                            </select>
                                            @error('sujet')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="message" class="form-label">Message</label>
                                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" placeholder="Décrivez votre problème ou votre question..." required>{{ old('message') }}</textarea>
                                            @error('message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Minimum 10 caractères. Veuillez être aussi précis que possible.</small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="screenshot" class="form-label">Capture d'écran (optionnel)</label>
                                            <input type="file" class="form-control @error('screenshot') is-invalid @enderror" id="screenshot" name="screenshot">
                                            @error('screenshot')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Formats acceptés : JPG, PNG, GIF. Taille maximale : 2 Mo.</small>
                                        </div>
                                        
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-paper-plane me-2"></i>Envoyer
                                            </button>
                                        </div>
                                    </form>
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