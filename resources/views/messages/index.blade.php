<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Üzenetek') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @forelse ($messageGroups as $group)
                    <button onclick="window.location.href='{{ route('messages.conversation', ['sender_id' => $group['sender']->id, 'listing_id' => optional($group['listing'])->id]) }}'" class="w-full text-left p-4 mb-4 border rounded shadow focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-semibold">
                                    {{ optional($group['sender'])->name }}
                                </h3>
                                <p><strong>Hirdetés:</strong> {{ optional($group['listing'])->title ?? 'Ismeretlen hirdetés' }}</p>
                                <p><strong>Legutóbbi üzenet:</strong> {{ optional($group['latest_message'])->content }}</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                <em>{{ optional($group['latest_message'])->created_at->format('Y-m-d H:i:s') }}</em>
                            </div>
                        </div>
                    </button>
                @empty
                    <p>Nincsenek kapott üzenetek.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function toggleMessages(groupId) {
        const messagesDiv = document.getElementById('messages-' + groupId);
        if (messagesDiv) {
            messagesDiv.classList.toggle('hidden');
        }
    }
</script>
