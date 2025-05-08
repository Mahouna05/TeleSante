<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Prendre un rendez-vous') }}
            </h2>

            <div class="mt-4 bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('rendez-vous.store') }}" method="POST">
                    @csrf
                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="col-span-1 sm:col-span-2">
                                <label for="medecin_id" class="block text-sm font-medium text-gray-700">Médecin</label>
                                <select id="medecin_id" name="medecin_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">Sélectionnez un médecin</option>
                                    @foreach($medecins as $medecin)
                                    <option value="{{ $medecin->id }}">Dr. {{ $medecin->user->nom }} {{ $medecin->user->prenom }} - {{ $medecin->specialite }}</option>
                                    @endforeach
                                </select>
                                @error('medecin_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" name="date" id="date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="heure" class="block text-sm font-medium text-gray-700">Heure</label>
                                <input type="time" name="heure" id="heure" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('heure')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Type de consultation</label>
                                <select id="type" name="type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="video">Vidéo</option>
                                    <option value="audio">Audio</option>
                                    <option value="chat">Chat</option>
                                </select>
                                @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1 sm:col-span-2">
                                <label for="motif" class="block text-sm font-medium text-gray-700">Motif de la consultation</label>
                                <textarea id="motif" name="motif" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                @error('motif')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('rendez-vous.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Annuler
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Demander un rendez-vous
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>