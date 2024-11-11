<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @auth
                        <ul>
                            @foreach (auth()->user()->unreadNotifications as $notification)
                                <li>
                                    <a href="{{ route('notifications.markAsRead', $notification->id) }}">
                                        {{ $notification->data['sender_name'] }} küldött egy üzenetet: "{{ $notification->data['content'] }}"
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endauth
                    <h3 class="text-2xl font-semibold mb-4">Saját Hirdetéseid</h3>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
