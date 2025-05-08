@extends('layouts.patient')

@section('title', 'Aide et Support')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="text-primary">Aide et Support</h6>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-question-circle text-primary me-2"></i>
                                        Foire Aux Questions
                                    </h5>
                                    <p class="card-text">Consultez notre liste de questions fréquentes pour trouver rapidement des réponses à vos interrogations.</p>
                                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        Afficher les FAQ
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-book text-primary me-2"></i>
                                        Guide d'utilisation
                                    </h5>
                                    <p class="card-text">Découvrez comment utiliser au mieux notre plateforme avec notre guide complet.</p>
                                    <a href="{{ route('patient.aide-support.guideComplet') }}" class="btn btn-sm btn-primary">
                                        Guide complet
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="collapse" id="collapseExample">
                        <div class="card card-body mb-4">
                            <h5>Questions fréquentes</h5>
                            <div class="accordion" id="accordionFaq">
                                @forelse ($faqs as $key => $faq)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $key }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" aria-expanded="false" aria-controls="collapse{{ $key }}">
                                                {{ $faq->question }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $key }}" data-bs-parent="#accordionFaq">
                                            <div class="accordion-body">
                                                {!! $faq->reponse !!}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info">
                                        Aucune FAQ disponible pour le moment.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        Contacter le support
                                    </h5>
                                    <p class="card-text">Vous avez une question spécifique ? N'hésitez pas à contacter notre équipe de support.</p>
                                    <a href="{{ route('patient.aide-support.contactSupport') }}" class="btn btn-sm btn-primary">
                                        Formulaire de contact
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-history text-primary me-2"></i>
                                        Mes messages au support
                                    </h5>
                                    <p class="card-text">Consultez l'historique de vos échanges avec notre équipe de support.</p>
                                    <a href="{{ route('patient.aide-support.mesMessages') }}" class="btn btn-sm btn-primary">
                                        Voir mes messages
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Liens utiles</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-shield-alt text-primary me-3 fa-2x"></i>
                                                <div>
                                                    <h6 class="mb-0">Politique de confidentialité</h6>
                                                    <a href="{{ route('patient.aide-support.politiques', 'confidentialite') }}" class="text-sm">Consulter</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-file-contract text-primary me-3 fa-2x"></i>
                                                <div>
                                                    <h6 class="mb-0">Conditions d'utilisation</h6>
                                                    <a href="{{ route('patient.aide-support.politiques', 'conditions') }}" class="text-sm">Consulter</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-gavel text-primary me-3 fa-2x"></i>
                                                <div>
                                                    <h6 class="mb-0">Mentions légales</h6>
                                                    <a href="{{ route('patient.aide-support.politiques', 'mentions') }}" class="text-sm">Consulter</a>
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
    </div>
</div>
@endsection