@extends('layouts.patient')

@section('title', 'Guide d\'utilisation')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="text-primary">Guide d'utilisation complet</h6>
                    <a href="{{ route('patient.aide-support.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($guide) && $guide)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>{{ $guide->titre }}</h5>
                                <div>
                                    <a href="{{ route('patient.aide-support.telechargerGuide') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-download me-2"></i>Télécharger en PDF
                                    </a>
                                </div>
                            </div>
                            <div class="mb-4">
                                {!! $guide->contenu !!}
                            </div>
                        </div>
                    @else
                        <div class="guide-content">
                            <div class="table-of-contents mb-4">
                                <h5>Table des matières</h5>
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item"><a href="#section1">Débuter avec TéléSanté Bénin</a></li>
                                    <li class="list-group-item"><a href="#section2">Gestion de votre profil</a></li>
                                    <li class="list-group-item"><a href="#section3">Prendre rendez-vous avec un médecin</a></li>
                                    <li class="list-group-item"><a href="#section4">Consultations en ligne</a></li>
                                    <li class="list-group-item"><a href="#section5">Votre dossier médical</a></li>
                                    <li class="list-group-item"><a href="#section6">Gestion des médicaments et rappels</a></li>
                                    <li class="list-group-item"><a href="#section7">Paiements et factures</a></li>
                                    <li class="list-group-item"><a href="#section8">Résolution des problèmes courants</a></li>
                                </ol>
                            </div>

                            <section id="section1" class="mb-5">
                                <h4 class="text-primary">1. Débuter avec TéléSanté Bénin</h4>
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5>Premiers pas sur la plateforme</h5>
                                        <p>Bienvenue sur TéléSanté Bénin ! Notre plateforme vous permet d'accéder à des consultations médicales de qualité à distance et de gérer votre santé efficacement.</p>
                                        
                                        <h6>Inscription et création de compte</h6>
                                        <p>Pour utiliser nos services, vous devez d'abord créer un compte :</p>
                                        <ol>
                                            <li>Rendez-vous sur la page d'accueil et cliquez sur "S'inscrire"</li>
                                            <li>Remplissez le formulaire avec vos informations personnelles</li>
                                            <li>Vérifiez votre adresse email en cliquant sur le lien reçu</li>
                                            <li>Complétez votre profil médical pour une meilleure prise en charge</li>
                                        </ol>
                                        
                                        <h6>Navigation dans le tableau de bord</h6>
                                        <p>Une fois connecté, vous accédez à votre tableau de bord personnel qui comprend :</p>
                                        <ul>
                                            <li><strong>Tableau de bord</strong> : Aperçu général de vos activités</li>
                                            <li><strong>Consultations</strong> : Gérez vos consultations en cours et passées</li>
                                            <li><strong>Dossier médical</strong> : Accédez à votre historique médical</li>
                                            <li><strong>Médicaments</strong> : Suivez vos traitements en cours</li>
                                            <li><strong>Rendez-vous</strong> : Planifiez et gérez vos rendez-vous</li>
                                            <li><strong>Paiements</strong> : Consultez vos factures et historique de paiement</li>
                                            <li><strong>Paramètres</strong> : Personnalisez votre compte</li>
                                            <li><strong>Aide et support</strong> : Obtenez de l'assistance</li>
                                        </ul>
                                    </div>
                                </div>
                            </section>

                            <section id="section2" class="mb-5">
                                <h4 class="text-primary">2. Gestion de votre profil</h4>
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5>Personnaliser votre compte</h5>
                                        <p>Il est important de maintenir votre profil à jour pour faciliter vos consultations médicales.</p>
                                        
                                        <h6>Modifier vos informations personnelles</h6>
                                        <p>Pour modifier vos informations personnelles :</p>
                                        <ol>
                                            <li>Accédez à l'onglet "Paramètres"</li>
                                            <li>Sélectionnez "Informations personnelles"</li>
                                            <li>Mettez à jour vos coordonnées (nom, prénom, téléphone, etc.)</li>
                                            <li>Cliquez sur "Enregistrer les modifications"</li>
                                        </ol>
                                        
                                        <h6>Changer votre mot de passe</h6>
                                        <p>Pour renforcer la sécurité de votre compte :</p>
                                        <ol>
                                            <li>Dans "Paramètres", sélectionnez l'onglet "Mot de passe"</li>
                                            <li>Entrez votre mot de passe actuel</li>
                                            <li>Saisissez votre nouveau mot de passe et confirmez-le</li>
                                            <li>Cliquez sur "Mettre à jour le mot de passe"</li>
                                        </ol>
                                        
                                        <h6>Préférences d'interface</h6>
                                        <p>Personnalisez votre expérience utilisateur :</p>
                                        <ul>
                                            <li>Choisissez votre langue préférée</li>
                                            <li>Sélectionnez le format de date et d'heure</li>
                                            <li>Optez pour le thème clair ou sombre selon vos préférences</li>
                                        </ul>
                                    </div>
                                </div>
                            </section>

                            <!-- Les autres sections seraient développées de manière similaire -->
                            <section id="section3" class="mb-5">
                                <h4 class="text-primary">3. Prendre rendez-vous avec un médecin</h4>
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <p><em>Ce contenu sera développé prochainement...</em></p>
                                    </div>
                                </div>
                            </section>

                            <!-- Vous pouvez afficher un message pour les sections en cours de développement -->
                            <div class="alert alert-info mt-5">
                                <h5><i class="fas fa-info-circle me-2"></i> Guide en cours de développement</h5>
                                <p>Notre guide d'utilisation est constamment mis à jour pour vous fournir les informations les plus précises et utiles possibles. Les sections restantes seront bientôt disponibles.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection