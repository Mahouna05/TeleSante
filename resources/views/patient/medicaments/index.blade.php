<!-- resources/views/patient/medicaments/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes médicaments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Ordonnances actives -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Ordonnances actives') }}</h3>
                    
                    @if($ordonnancesActives->count() > 0)
                        <div class="space-y-4">
                            @foreach($ordonnancesActives as $ordonnance)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <div>
                                            <h4 class="font-medium">Ordonnance #{{ $ordonnance->id }}</h4>
                                            <p class="text-sm text-gray-600">Dr. {{ $ordonnance->consultation->medecin->user->nom }} {{ $ordonnance->consultation->medecin->user->prenom }} - {{ $ordonnance->consultation->medecin->specialite }}</p>
                                            <p class="text-sm text-gray-500">Émise le {{ $ordonnance->date_creation->format('d/m/Y') }} - Valide jusqu'au {{ $ordonnance->date_expiration->format('d/m/Y') }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('medicaments.ordonnance.show', $ordonnance) }}" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200">
                                                {{ __('Détails') }}
                                            </a>
                                            <a href="{{ route('medicaments.ordonnance.imprimer', $ordonnance) }}" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                                                {{ __('Imprimer') }}
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <h5 class="text-sm font-medium mb-2">{{ __('Médicaments prescrits') }}</h5>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach($ordonnance->medicaments as $medicament)
                                                <div class="border rounded p-2 flex justify-between items-center">
                                                    <div>
                                                        <p class="font-medium">{{ $medicament->nom }}</p>
                                                        <p class="text-sm text-gray-600">{{ $medicament->dosage }} - {{ $medicament->forme }}</p>
                                                        <p class="text-xs text-gray-500">{{ $medicament->instructions }}</p>
                                                    </div>
                                                    <input type="checkbox" name="medicaments[]" value="{{ $medicament->id }}" class="form-checkbox h-5 w-5 text-blue-600">
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="mt-4 flex justify-end">
                                            <button onclick="commanderMedicaments('{{ $ordonnance->id }}')" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                                {{ __('Commander les médicaments sélectionnés') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('Aucune ordonnance active.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Commandes en cours -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Commandes en cours') }}</h3>
                    
                    @if($commandes->where('statut', '!=', 'livré')->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('N° Commande') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Date') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Montant') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Statut') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($commandes->where('statut', '!=', 'livré') as $commande)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">CMD-{{ $commande->id }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $commande->date_commande->format('d/m/Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $commande->statut == 'en attente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $commande->statut == 'confirmé' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $commande->statut == 'en cours de livraison' ? 'bg-indigo-100 text-indigo-800' : '' }}">
                                                    {{ ucfirst($commande->statut) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="#" class="text-blue-600 hover:text-blue-900">{{ __('Détails') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('Aucune commande en cours.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Historique des commandes livrées -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Historique des commandes') }}</h3>
                    
                    @if($commandes->where('statut', 'livré')->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('N° Commande') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Date') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Montant') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Date de livraison') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($commandes->where('statut', 'livré') as $commande)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">CMD-{{ $commande->id }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $commande->date_commande->format('d/m/Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $commande->date_livraison->format('d/m/Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="#" class="text-blue-600 hover:text-blue-900">{{ __('Détails') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('Aucune commande livrée.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de commande de médicaments -->
    <div id="commandeModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <form id="commandeForm" method="POST" action="{{ route('medicaments.commander') }}">
                @csrf
                <input type="hidden" name="ordonnance_id" id="ordonnance_id">
                <div id="medicaments_selected_container"></div>

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Commander des médicaments') }}</h3>
                    <div class="mt-4">
                        <label for="adresse_livraison" class="block text-sm font-medium text-gray-700">{{ __('Adresse de livraison') }}</label>
                        <textarea name="adresse_livraison" id="adresse_livraison" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Confirmer la commande') }}
                    </button>
                    <button type="button" onclick="closeCommandeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Annuler') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function commanderMedicaments(ordonnanceId) {
            // Récupérer les médicaments sélectionnés
            const checkboxes = document.querySelectorAll('input[name="medicaments[]"]:checked');
            if (checkboxes.length === 0) {
                alert('Veuillez sélectionner au moins un médicament.');
                return;
            }
            
            // Préparer le formulaire
            document.getElementById('ordonnance_id').value = ordonnanceId;
            
            // Ajouter les médicaments sélectionnés au formulaire
            const container = document.getElementById('medicaments_selected_container');
            container.innerHTML = '';
            checkboxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'medicaments[]';
                input.value = checkbox.value;
                container.appendChild(input);
            });
            
            // Afficher le modal
            document.getElementById('commandeModal').classList.remove('hidden');
        }
        
        function closeCommandeModal() {
            document.getElementById('commandeModal').classList.add('hidden');
        }
    </script>
</x-app-layout>