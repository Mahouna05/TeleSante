<!-- resources/views/consultation/video-call.blade.php -->
<x-app-layout>
    <div class="h-screen flex flex-col bg-gray-100">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Consultation avec Dr.') }} {{ $rendezVous->consultation->medecin->user->nom }} {{ $rendezVous->consultation->medecin->user->prenom }}
                </h2>
                <div class="flex space-x-2">
                    <button id="toggleVideo" class="p-2 bg-gray-200 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                    <button id="toggleAudio" class="p-2 bg-gray-200 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                    </button>
                    <a href="{{ route('consultations.index') }}" class="p-2 bg-red-500 text-white rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                </div>
            </div>
        </header>

        <div class="flex-1 flex overflow-hidden">
            <main class="flex-1 flex flex-col">
                <!-- Zone vidéo principale -->
                <div class="flex-1 bg-black relative">
                    <video id="remoteVideo" class="w-full h-full object-cover" autoplay></video>
                    <div class="absolute bottom-4 right-4 w-1/5 h-1/5 bg-gray-800 rounded overflow-hidden shadow-lg">
                        <video id="localVideo" class="w-full h-full object-cover" autoplay muted></video>
                    </div>
                </div>
                
                <!-- Informations de consultation et notes -->
                <div class="h-1/4 bg-white p-4 overflow-y-auto">
                    <div class="mb-4">
                        <h3 class="font-medium text-gray-900">{{ __('Notes de consultation') }}</h3>
                        <textarea id="consultationNotes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Prenez des notes pendant votre consultation..."></textarea>
                    </div>
                </div>
            </main>
            
            <!-- Sidebar - Optionnelle: informations du médecin, chat, etc. -->
            <aside class="w-80 bg-white border-l border-gray-200 overflow-y-auto hidden md:block">
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <img src="{{ $rendezVous->consultation->medecin->user->profilePhotoUrl }}" alt="Photo du médecin" class="h-12 w-12 rounded-full mr-4">
                        <div>
                            <h3 class="font-medium">Dr. {{ $rendezVous->consultation->medecin->user->nom }} {{ $rendezVous->consultation->medecin->user->prenom }}</h3>
                            <p class="text-sm text-gray-600">{{ $rendezVous->consultation->medecin->specialite }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-4">
                    <h4 class="font-medium mb-2">{{ __('Chat') }}</h4>
                    <div id="chatMessages" class="h-96 overflow-y-auto border rounded-md p-2 mb-2 bg-gray-50">
                        <!-- Les messages apparaîtront ici -->
                    </div>
                    <div class="flex">
                        <input type="text" id="chatInput" class="flex-1 rounded-l-md border-gray-300 shadow-sm" placeholder="Tapez un message...">
                        <button id="sendMessage" class="bg-blue-500 text-white px-4 py-2 rounded-r-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/simple-peer@9.11.0/simplepeer.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Code de WebRTC pour l'appel vidéo
            // Cette partie nécessiterait l'intégration avec un service comme WebRTC ou Agora.io
            
            // Exemple simplifié:
            navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                .then(stream => {
                    const localVideo = document.getElementById('localVideo');
                    localVideo.srcObject = stream;
                    
                    // Ici, connectez le flux à votre service de WebRTC
                    // Cette partie dépend de votre implémentation réelle
                })
                .catch(err => {
                    console.error('Erreur d\'accès à la caméra et au micro:', err);
                    alert('Impossible d\'accéder à votre caméra ou microphone. Veuillez vérifier vos permissions.');
                });
                
            // Gestion des boutons de contrôle
            document.getElementById('toggleVideo').addEventListener('click', function() {
                // Code pour activer/désactiver la vidéo
            });
            
            document.getElementById('toggleAudio').addEventListener('click', function() {
                // Code pour activer/désactiver l'audio
            });
            
            // Gestion du chat
            document.getElementById('sendMessage').addEventListener('click', function() {
                const input = document.getElementById('chatInput');
                const message = input.value.trim();
                
                if (message) {
                    // Envoyer le message via WebSocket ou autre méthode
                    addMessageToChat('Vous', message);
                    input.value = '';
                }
            });
            
            function addMessageToChat(sender, message) {
                const chatMessages = document.getElementById('chatMessages');
                const messageElement = document.createElement('div');
                messageElement.className = 'mb-2';
                messageElement.innerHTML = `<strong>${sender}:</strong> ${message}`;
                chatMessages.appendChild(messageElement);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>
    @endpush
</x-app-layout>