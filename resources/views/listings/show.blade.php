<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hirdetés Részletei') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Kép megjelenítése -->
                    @if($listing->images->isNotEmpty())
                        @foreach($listing->images as $image)
                            <img src="{{ asset('storage/' . $image->filename) }}" alt="Hirdetés képe" class="w-full h-96 object-cover mb-4 rounded">
                        @endforeach
                    @else
                        <img src="https://via.placeholder.com/600x400" alt="Nincs kép" class="w-full h-96 object-cover mb-4 rounded">
                    @endif

                    <!-- Hirdetés adatai -->
                    <h2 class="font-semibold text-2xl">{{ $listing->title }}</h2>
                    <p class="mt-4 text-gray-800">{{ $listing->description }}</p>
                    <p class="mt-4 font-bold">{{ $listing->price }} Ft</p>
                    <p class="mt-2 text-sm text-gray-600">Város: {{ $listing->city }}</p>
                    <p class="mt-2 text-sm text-gray-600">Hirdetés típusa: {{ ucfirst($listing->delivery_method) }}</p>

                    <!-- Hozzászólások szekció -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold">Hozzászólások</h3>
                        <form method="POST" action="{{ route('comments.store', $listing->id) }}" class="mt-4">
                            @csrf
                            <textarea name="content" class="form-input rounded-md shadow-sm mt-1 block w-full" rows="3" placeholder="Írj egy hozzászólást..." required></textarea>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Hozzászólás Küldése</button>
                        </form>

                        <div class="mt-6">
                            @foreach($listing->comments as $comment)
                                <div class="border-b border-gray-200 pb-4 mb-4">
                                    <p class="font-semibold">{{ $comment->user->name }}:</p>
                                    <p>{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Üzenetküldési lehetőség -->
                    <div class="mt-8">
                        <a href="{{ route('messages.create', ['receiver_id' => $listing->user_id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Üzenet küldése a hirdetőnek') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
