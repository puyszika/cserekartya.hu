<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Üzenetek') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <h1>Kapott üzenetek</h1>

                        @isset($messages)
                            @if($messages->isEmpty())
                                <p>Nincsenek kapott üzeneteid.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Feladó</th>
                                        <th>Üzenet</th>
                                        <th>Érkezés ideje</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($messages as $message)
                                        <tr>
                                            <td>{{ $message->sender->name }}</td>
                                            <td>{{ $message->content }}</td>
                                            <td>{{ $message->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @endisset
                    </div>

                    <form method="POST" action="{{ route('messages.store') }}">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">

                        <!-- Üzenet tartalma -->
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Üzenet') }}</label>
                            <textarea name="content" id="content" rows="4" class="form-input rounded-md shadow-sm mt-1 block w-full" required></textarea>
                        </div>

                        <!-- Küldés gomb -->
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Üzenet Küldése') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
