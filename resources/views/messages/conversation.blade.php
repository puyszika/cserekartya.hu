<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beszélgetés') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($messages->isNotEmpty())
                    <div class="mb-8 border-b pb-4">
                        <h3 class="text-lg font-semibold">
                            Beszélgetés {{ $messages->first()->sender->id === auth()->id() ? 'Te' : ($messages->first()->sender->id !== auth()->id() ? $messages->first()->sender->name : $messages->first()->receiver->name) }}-val/vel:
                        </h3>
                        <p><strong>Hirdetés:</strong> {{ optional($messages->first()->listing)->title ?? 'Ismeretlen hirdetés' }}</p>
                        <ul class="mt-4">
                            @foreach ($messages as $message)
                                <li class="mb-4 p-4 border rounded shadow">
                                    <p><strong>{{ $message->sender->id === auth()->id() ? 'Te' : $message->sender->name }}:</strong> {{ $message->content }}</p>
                                    <p><small><em>Küldve: {{ $message->created_at->format('Y-m-d H:i:s') }}</em></small></p>
                                </li>
                            @endforeach
                        </ul>
                        <form method="POST" action="{{ route('messages.sendReply', ['receiver_id' => $messages->first()->sender->id === auth()->id() ? $messages->first()->receiver_id : $messages->first()->sender_id, 'listing_id' => optional($messages->first()->listing)->id]) }}" class="mt-4">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700">Válasz</label>
                                <textarea name="content" id="content" rows="3" class="form-input rounded-md shadow-sm mt-1 block w-full" required></textarea>
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Küldés
                            </button>
                        </form>
                    </div>
                @else
                    <p>Nincsenek megjeleníthető üzenetek.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
