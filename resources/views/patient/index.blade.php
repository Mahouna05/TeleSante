<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl font-semibold text-gray-900">
                Bonjour, {{ Auth::user()->firstname}} <span class="inline-block">👋</span>
            </h2>
            <p class="text-sm text-gray-500">
                Dernière connexion: {{ \Carbon\Carbon::parse(Auth::user()->last_login_at)->format('d M Y, H:i') }}
            </p>
            
            <!-- Prochain bilan médical -->
            <div class="mt-4 bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="rounded-full bg-red-100 p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-medium text-gray-900">Prochain bilan médical</h3>
                        <p class="text-gray-500">Dans {{ $prochainBilan ? $prochainBilan->jours_prochain_bilan : '30' }} jours</p>
                    </div>
                </div>
            </div>
            
            <!-- Actions rapides -->
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900">Actions rapides</h3>
                <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <a href="{{ route('rendez-vous.create') }}" class="bg-white rounded-lg shadow p-4 text-center hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="block mt-2 text-sm font-medium text-gray-900">Prendre RDV</span>
                    </a>
                    <a href="{{ route('dossiers.show') }}" class="bg-white rounded-lg shadow p-4 text-center hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="block mt-2 text-sm font-medium text-gray-900">Mon dossier</span>
                    </a>
                    <a href="{{ route('medicaments.index') }}" class="bg-white rounded-lg shadow p-4 text-center hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span class="block mt-2 text-sm font-medium text-gray-900">Médicaments</span>
                    </a>
                    <a href="{{ route('messages.index') }}" class="bg-white rounded-lg shadow p-4 text-center hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <span class="block mt-2 text-sm font-medium text-gray-900">Messages</span>
                    </a>
                </div>
            </div>
            
            <!-- Prochains rendez-vous -->
            <div class="mt-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Prochains rendez-vous</h3>
                    <a href="{{ route('rendez-vous.index') }}" class="text-sm text-blue-600 hover:text-blue-500">Voir tous</a>
                </div>
                <div class="mt-2 bg-white rounded-lg shadow overflow-hidden">
                    @forelse($rendezVous as $rdv)
                    <div class="border-b border-gray-200 last:border-b-0">
                        <div class="p-4 flex items-start">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="{{ $rdv->medecin->user->profile_photo_url }}" alt="{{ $rdv->medecin->user->nom }}">
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-sm font-medium">Consultation - Dr. {{ $rdv->medecin->user->nom }} {{ $rdv->medecin->user->prenom }}</h4>
                                    <span class="text-xs text-gray-500">{{ $rdv->type }}</span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">{{ $rdv->medecin->specialite }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('d M Y - H:i') }} ({{ \Carbon\Carbon::parse($rdv->date_heure)->diffForHumans() }})</p>
                                <div class="mt-2 flex space-x-2">
                                    @if(\Carbon\Carbon::parse($rdv->date_heure)->isToday())
                                    <a href="{{ route('consultations.join', $rdv->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded-md">Rejoindre</a>
                                    @endif
                                    <a href="{{ route('rendez-vous.edit', $rdv->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs px-3 py-1 rounded-md">Reprogrammer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-gray-500 text-sm">
                        Aucun rendez-vous à venir. <a href="{{ route('rendez-vous.create') }}" class="text-blue-600 hover:text-blue-500">Prendre un rendez-vous</a>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Rappels de médicaments -->
            <div class="mt-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Rappels de médicaments</h3>
                    <a href="{{ route('medicaments.rappels') }}" class="text-sm text-blue-600 hover:text-blue-500">Voir tous</a>
                </div>
                <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="font-medium text-gray-900">Aujourd'hui</h4>
                        <div class="mt-2 space-y-3">
                            @php $hasRappelsAujourdhui = false; @endphp
                            @foreach($ordonnances as $ordonnance)
                                @foreach($ordonnance->medicaments as $medicament)
                                    @if($medicament->pivot->rappel_date && \Carbon\Carbon::parse($medicament->pivot->rappel_date)->isToday())
                                    @php $hasRappelsAujourdhui = true; @endphp
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $medicament->nom }} {{ $medicament->dosage }}</p>
                                            <p class="text-xs text-gray-500">{{ $medicament->pivot->posologie }} · {{ \Carbon\Carbon::parse($medicament->pivot->rappel_date)->format('H:i') }}</p>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            @endforeach
                            @if(!$hasRappelsAujourdhui)
                            <p class="text-sm text-gray-500">Aucun rappel pour aujourd'hui</p>
                            @endif
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="font-medium text-gray-900">À venir</h4>
                        <div class="mt-2 space-y-3">
                            @php $hasRappelsAvenir = false; @endphp
                            @foreach($ordonnances as $ordonnance)
                                @foreach($ordonnance->medicaments as $medicament)
                                    @if($medicament->pivot->rappel_date && \Carbon\Carbon::parse($medicament->pivot->rappel_date)->isFuture() && !\Carbon\Carbon::parse($medicament->pivot->rappel_date)->isToday())
                                    @php $hasRappelsAvenir = true; @endphp
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $medicament->nom }} {{ $medicament->dosage }}</p>
                                            <p class="text-xs text-gray-500">{{ $medicament->pivot->posologie }} · {{ \Carbon\Carbon::parse($medicament->pivot->rappel_date)->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            @endforeach
                            @if(!$hasRappelsAvenir)
                            <p class="text-sm text-gray-500">Aucun rappel à venir</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Derniers paiements -->
            <div class="mt-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Derniers paiements</h3>
                    <a href="{{ route('paiements.index') }}" class="text-sm text-blue-600 hover:text-blue-500">Voir tous</a>
                </div>
                <div class="mt-2 bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Médecin</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Exemples de paiements -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">05/04/2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Consultation vidéo</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Dr. Kokou Mensah</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">5.000 FCFA</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Payé</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">28/03/2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Livraison médicaments</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Pharmacie Centrale</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12.500 FCFA</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Payé</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15/03/2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Abonnement mensuel</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">TéléSanté Bénin</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15.000 FCFA</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Payé</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Notifications -->
            <div class="mt-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Notifications</h3>
                    <a href="{{ route('notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-500">Voir toutes</a>
                </div>
                <div class="mt-2 bg-white rounded-lg shadow overflow-hidden">
                    @forelse($notifications as $notification)
                    <div class="border-b border-gray-200 last:border-b-0">
                        <div class="p-4 flex items-start">
                            <div class="flex-shrink-0">
                                @if($notification->type == 'rappel')
                                <span class="flex h-8 w-8 rounded-full bg-yellow-100 items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                @elseif($notification->type == 'alerte')
                                <span class="flex h-8 w-8 rounded-full bg-red-100 items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                @else
                                <span class="flex h-8 w-8 rounded-full bg-blue-100 items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                    </svg>
                                </span>
                                @endif
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm text-gray-900">{{ $notification->message }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Marquer comme lu</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-gray-500 text-sm">
                        Aucune notification non lue.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>