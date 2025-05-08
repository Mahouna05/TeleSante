<!-- resources/views/patient/notifications/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notifications') }}
            </h2>
            <div>
                <form action="{{ route('notifications.tout-marquer-comme-lu') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">
                        {{ __('Tout marquer comme lu') }}
                    </button>
                </form>
                <span class="mx-2 text-gray-400">|</span>
                <form action="{{ route('notifications.tout-supprimer') }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800" onclick="return confirm('Êtes-vous sûr de vouloir supprimer toutes vos notifications ?')">
                        {{ __('Tout supprimer') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($notifications->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($notifications as $notification)
                                <div class="py-4 flex items-start {{ $notification->lu ? 'opacity-75' : 'bg-blue-50' }}">
                                    <!-- Icône en fonction du type de notification -->
                                    <div class="flex-shrink-0 mr-4">
                                        @if($notification->type == 'rappel')
                                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-yellow-100">
                                                <svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                        @elseif($notification->type == 'alerte')
                                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-red-100">
                                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                                                <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Contenu de la notification -->
                                    <div class="flex-1">
                                        <div class="flex justify-between items-center">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $notification->type == 'rappel' ? 'Rappel' : ($notification->type == 'alerte' ? 'Alerte' : 'Information') }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $notification->dateEnvoi->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="mt-1 text-sm text-gray-700">
                                            {{ $notification->message }}
                                        </div>
                                        
                                        @if(!$notification->lu)
                                            <div class="mt-2">
                                                <form action="{{ route('notifications.marquer-comme-lu', $notification) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">
                                                        {{ __('Marquer comme lu') }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="ml-4">
                                        <form action="{{ route('notifications.supprimer', $notification) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-gray-500" title="Supprimer">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('Aucune notification') }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Vous n\'avez pas encore reçu de notification.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>