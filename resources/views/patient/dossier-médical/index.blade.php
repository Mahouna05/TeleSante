<!-- resources/views/patient/dossier-medical/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon dossier médical') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Informations personnelles') }}</h3>
                        <div>
                            <a href="{{ route('dossier-medical.telecharger') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                {{ __('Télécharger le dossier complet') }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium mb-2">{{ __('Informations de base') }}</h4>
                            <div class="bg-gray-50 p-4 rounded-md">
                                <p><strong>{{ __('Nom') }}:</strong> {{ auth()->user()->nom }}</p>
                                <p><strong>{{ __('Prénom') }}:</strong> {{ auth()->user()->prenom }}</p>
                                <p><strong>{{ __('Date de naissance') }}:</strong> {{ auth()->user()->patient->dateNaissance->format('d/m/Y') }}</p>
                                <p><strong>{{ __('Sexe') }}:</strong> {{ auth()->user()->patient->sexe }}</p>
                                <p><strong>{{ __('Adresse') }}:</strong> {{ auth()->user()->patient->adresse }}</p>
                                <p><strong>{{ __('Email') }}:</strong> {{ auth()->user()->email }}</p>
                                <p><strong>{{ __('Téléphone') }}:</strong> {{ auth()->user()->telephone }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium mb-2">{{ __('Informations médicales') }}</h4>
                            <div class="bg-gray-50 p-4 rounded-md">
                                <p><strong>{{ __('Groupe sanguin') }}:</strong> {{ $dossier->groupeSanguin ?? 'Non renseigné' }}</p>
                                <p><strong>{{ __('Allergies') }}:</strong> {{ $dossier->allergies ?? 'Aucune allergie connue' }}</p>
                                <p><strong>{{ __('Antécédents médicaux') }}:</strong> {{ $dossier->antecedents ?? 'Aucun antécédent connu' }}</p>
                                <p><strong>{{ __('Traitements en cours') }}:</strong> {{ $dossier->traitements ?? 'Aucun traitement en cours' }}</p>
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('dossier-medical.details') }}" class="text-blue-600 hover:text-blue-800">
                                    {{ __('Voir tous les détails du dossier médical') }} →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historique des consultations -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Historique des consultations') }}</h3>
                    
                    @if($consultations->count() > 0)
                        <div class="space-y-4">
                            @foreach($consultations as $consultation)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-medium">{{ $consultation->type == 'video' ? 'Consultation vidéo' : 'Consultation chat' }} - Dr. {{ $consultation->medecin->user->nom }} {{ $consultation->medecin->user->prenom }}</h4>
                                            <p class="text-sm text-gray-600">{{ $consultation->medecin->specialite }}</p>
                                            <p class="text-sm text-gray-500">{{ $consultation->date->format('d/m/Y') }} à {{ $consultation->date->format('H:i') }}</p>
                                        </div>
                                        <div>
                                            <a href="{{ route('dossier-medical.consultation', $consultation) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                                {{ __('Voir le rapport') }}
                                            </a>
                                        </div>
                                    </div>
                                    
                                    @if($consultation->notes)
                                        <div class="mt-3">
                                            <h5 class="text-sm font-medium mb-1">{{ __('Diagnostic') }}</h5>
                                            <p class="text-sm text-gray-700">{{ Str::limit($consultation->notes, 150) }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($consultation->ordonnance)
                                        <div class="mt-3">
                                            <h5 class="text-sm font-medium mb-1">{{ __('Ordonnance') }}</h5>
                                            <p class="text-sm text-gray-700">
                                                {{ $consultation->ordonnance->medicaments->count() }} médicament(s) prescrit(s)
                                                <a href="{{ route('medicaments.ordonnance.show', $consultation->ordonnance) }}" class="text-blue-600 hover:text-blue-800 ml-2">
                                                    {{ __('Voir l\'ordonnance') }}
                                                </a>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('Aucune consultation terminée.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>