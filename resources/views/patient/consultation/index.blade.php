<!-- resources/consultation/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes consultations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Consultations à venir -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Prochaines consultations') }}</h3>
                        <a href="#" class="text-blue-500 text-sm">{{ __('Voir tous') }}</a>
                    </div>
                    
                    @if($consultationsAVenir->count() > 0)
                        <div class="space-y-4">
                            @foreach($consultationsAVenir as $consultation)
                                <div class="flex items-start p-4 border-l-4 {{ $consultation->type == 'video' ? 'border-blue-500' : 'border-green-500' }} bg-gray-50 rounded-md">
                                    <div class="flex-shrink-0 mr-4">
                                        <img src="{{ $consultation->medecin->user->profilePhotoUrl }}" alt="Photo du médecin" class="h-12 w-12 rounded-full">
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="font-medium">
                                            {{ $consultation->type == 'video' ? 'Consultation' : 'Suivi' }} - Dr. {{ $consultation->medecin->user->nom }} {{ $consultation->medecin->user->prenom }}
                                        </h4>
                                        <p class="text-sm text-gray-600">{{ $consultation->medecin->specialite }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ Carbon\Carbon::parse($consultation->date)->format('d M Y') }} - 
                                            {{ Carbon\Carbon::parse($consultation->date)->format('H:i') }}
                                            ({{ Carbon\Carbon::parse($consultation->date)->diffForHumans() }})
                                        </p>
                                    </div>
                                    <div class="flex space-x-2">
                                        @if(Carbon\Carbon::parse($consultation->date)->diffInMinutes(now()) <= 15)
                                            <a href="{{ route('consultations.join', $consultation->rendezVous) }}" 
                                               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                                {{ __('Rejoindre') }}
                                            </a>
                                        @endif
                                        <button 
                                            onclick="openRescheduleModal('{{ $consultation->id }}')"
                                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                            {{ __('Reprogrammer') }}
                                        </button>
                                        <form action="{{ route('consultations.cancel', $consultation) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette consultation?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100">
                                                {{ __('Annuler') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('Aucune consultation à venir.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Consultations passées -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Historique des consultations') }}</h3>
                        <a href="#" class="text-blue-500 text-sm">{{ __('Voir tous') }}</a>
                    </div>
                    
                    @if($consultationsPassees->count() > 0)
                        <div class="space-y-4">
                            @foreach($consultationsPassees as $consultation)
                                <div class="flex items-start p-4 bg-gray-50 rounded-md">
                                    <div class="flex-shrink-0 mr-4">
                                        <img src="{{ $consultation->medecin->user->profilePhotoUrl }}" alt="Photo du médecin" class="h-12 w-12 rounded-full">
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="font-medium">{{ $consultation->type == 'video' ? 'Consultation' : 'Suivi' }} - Dr. {{ $consultation->medecin->user->nom }} {{ $consultation->medecin->user->prenom }}</h4>
                                        <p class="text-sm text-gray-600">{{ $consultation->medecin->specialite }}</p>
                                        <p class="text-sm text-gray-500">{{ Carbon\Carbon::parse($consultation->date)->format('d M Y') }} - {{ Carbon\Carbon::parse($consultation->date)->format('H:i') }}</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('consultations.show', $consultation) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                            {{ __('Détails') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('Aucune consultation passée.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de reprogrammation -->
    <div id="rescheduleModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <form id="rescheduleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Reprogrammer la consultation') }}</h3>
                    <div class="mt-4">
                        <label for="dateHeure" class="block text-sm font-medium text-gray-700">{{ __('Nouvelle date et heure') }}</label>
                        <input type="datetime-local" name="dateHeure" id="dateHeure" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Confirmer') }}
                    </button>
                    <button type="button" onclick="closeRescheduleModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Annuler') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRescheduleModal(consultationId) {
            document.getElementById('rescheduleForm').action = `/consultations/${consultationId}/reschedule`;
            document.getElementById('rescheduleModal').classList.remove('hidden');
        }
        
        function closeRescheduleModal() {
            document.getElementById('rescheduleModal').classList.add('hidden');
        }
    </script>
</x-app-layout>