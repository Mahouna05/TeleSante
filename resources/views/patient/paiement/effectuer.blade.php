<!-- resources/views/patient/paiements/effectuer.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Effectuer un paiement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Détails du paiement') }}</h3>
                    
                    <div class="bg-gray-50 p-4 rounded mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Description') }}</p>
                                <p class="font-medium">
                                    @if($paiement->consultation)
                                        Consultation avec Dr. {{ $paiement->consultation->medecin->user->nom }} {{ $paiement->consultation->medecin->user->prenom }}
                                    @elseif($paiement->commande)
                                        Commande de médicaments #{{ $paiement->commande->id }}
                                    @else
                                        Paiement #{{ $paiement->id }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Date') }}</p>
                                <p class="font-medium">{{ $paiement->date->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Montant') }}</p>
                                <p class="font-medium text-lg text-blue-700">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Statut') }}</p>
                                <p>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $paiement->statut == 'en attente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $paiement->statut == 'en cours' ? 'bg-blue-100 text-blue-800' : '' }}">
                                        {{ ucfirst($paiement->statut) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('paiements.traiter', $paiement) }}">
                        @csrf
                        
                        <div class="mb-6">
                            <h4 class="text-md font-medium text-gray-900 mb-2">{{ __('Choisir un mode de paiement') }}</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="border rounded p-4 cursor-pointer hover:border-blue-500 transition" id="mobile-money">
                                    <div class="flex items-center">
                                        <input type="radio" name="methode" value="MobileMoney" id="method-mobile" class="h-4 w-4 text-blue-600 border-gray-300">
                                        <label for="method-mobile" class="ml-2 block text-sm font-medium text-gray-700 cursor-pointer">
                                            {{ __('Mobile Money') }}
                                        </label>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">{{ __('Paiement via MTN, Moov, Wave') }}</p>
                                    <img src="{{ asset('images/mobile-money-logos.png') }}" alt="Mobile Money options" class="h-8 mt-2">
                                </div>
                                
                                <div class="border rounded p-4 cursor-pointer hover:border-blue-500 transition" id="carte">
                                    <div class="flex items-center">
                                        <input type="radio" name="methode" value="Carte" id="method-card" class="h-4 w-4 text-blue-600 border-gray-300">
                                        <label for="method-card" class="ml-2 block text-sm font-medium text-gray-700 cursor-pointer">
                                            {{ __('Carte bancaire') }}
                                        </label>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">{{ __('Visa, Mastercard, etc.') }}</p>
                                    <img src="{{ asset('images/card-logos.png') }}" alt="Card options" class="h-8 mt-2">
                                </div>
                            </div>
                            
                            @error('methode')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Champs conditionnels pour Mobile Money -->
                        <div id="mobile-money-fields" class="hidden mb-6 p-4 border border-gray-200 rounded">
                            <h5 class="font-medium mb-4">{{ __('Informations Mobile Money') }}</h5>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="mobile-operator" class="block text-sm font-medium text-gray-700">{{ __('Opérateur') }}</label>
                                    <select id="mobile-operator" name="mobile_operator" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">{{ __('Sélectionner un opérateur') }}</option>
                                        <option value="mtn">MTN</option>
                                        <option value="moov">Moov</option>
                                        <option value="wave">Wave</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="mobile-number" class="block text-sm font-medium text-gray-700">{{ __('Numéro de téléphone') }}</label>
                                    <input type="text" name="mobile_number" id="mobile-number" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Ex: 97123456">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Champs conditionnels pour Carte bancaire -->
                        <div id="card-fields" class="hidden mb-6 p-4 border border-gray-200 rounded">
                            <h5 class="font-medium mb-4">{{ __('Informations de carte') }}</h5>
                            
                            <div class="mb-4">
                                <label for="card-number" class="block text-sm font-medium text-gray-700">{{ __('Numéro de carte') }}</label>
                                <input type="text" name="card_number" id="card-number" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="XXXX XXXX XXXX XXXX">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="card-expiry" class="block text-sm font-medium text-gray-700">{{ __('Date d\'expiration') }}</label>
                                    <input type="text" name="card_expiry" id="card-expiry" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="MM/AA">
                                </div>
                                
                                <div>
                                    <label for="card-cvv" class="block text-sm font-medium text-gray-700">{{ __('CVV') }}</label>
                                    <input type="text" name="card_cvv" id="card-cvv" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="123">
                                </div>
                            </div>
                            
                            <div>
                                <label for="card-name" class="block text-sm font-medium text-gray-700">{{ __('Nom sur la carte') }}</label>
                                <input type="text" name="card_name" id="card-name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        
                        <div class="flex justify-between">
                            <a href="{{ route('paiements.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition">
                                {{ __('Annuler') }}
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition">
                                {{ __('Payer maintenant') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMoneyRadio = document.getElementById('method-mobile');
            const cardRadio = document.getElementById('method-card');
            const mobileMoneyFields = document.getElementById('mobile-money-fields');
            const cardFields = document.getElementById('card-fields');
            const mobileMoneyBox = document.getElementById('mobile-money');
            const cardBox = document.getElementById('carte');
            
            mobileMoneyRadio.addEventListener('change', togglePaymentFields);
            cardRadio.addEventListener('change', togglePaymentFields);
            
            mobileMoneyBox.addEventListener('click', function() {
                mobileMoneyRadio.checked = true;
                togglePaymentFields();
            });
            
            cardBox.addEventListener('click', function() {
                cardRadio.checked = true;
                togglePaymentFields();
            });
            
            function togglePaymentFields() {
                if (mobileMoneyRadio.checked) {
                    mobileMoneyFields.classList.remove('hidden');
                    cardFields.classList.add('hidden');
                    mobileMoneyBox.classList.add('border-blue-500');
                    cardBox.classList.remove('border-blue-500');
                } else if (cardRadio.checked) {
                    mobileMoneyFields.classList.add('hidden');
                    cardFields.classList.remove('hidden');
                    mobileMoneyBox.classList.remove('border-blue-500');
                    cardBox.classList.add('border-blue-500');
                } else {
                    mobileMoneyFields.classList.add('hidden');
                    cardFields.classList.add('hidden');
                    mobileMoneyBox.classList.remove('border-blue-500');
                    cardBox.classList.remove('border-blue-500');
                }
            }
        });
    </script>
</x-app-layout>