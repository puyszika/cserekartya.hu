<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hirdetések') }}
        </h2>
    </x-slot>

    <!-- Hirdetések listázása -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Keresési űrlap -->
                <form action="{{ route('listings.search') }}" method="GET" class="mb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <input type="text" name="title" placeholder="Keresés cím szerint" value="{{ request('title') }}"
                                   class="w-full border rounded p-2" />
                        </div>
                        <div>
                            <select name="category_id" class="w-full border rounded p-2">
                                <option value="">Válassz kategóriát</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <input type="text" name="city" placeholder="Város" value="{{ request('city') }}"
                                   class="w-full border rounded p-2" />
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-500 text-white rounded p-2 w-full">Keresés</button>
                        </div>
                    </div>
                </form>

                <!-- Hirdetések listázása -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    @foreach ($listings as $listing)
                        <div class="border p-4 rounded shadow-lg @auth {{ $listing->user_id == auth()->id() ? 'bg-yellow-100' : '' }} @endauth">
                            <!-- Kép megjelenítése -->
                            @if($listing->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $listing->images->first()->filename) }}" alt="Hirdetés képe" class="w-19 h-19 object-cover mb-4 rounded">
                            @else
                                <img src="https://via.placeholder.com/150" alt="Nincs kép" class="w-32 h-32 object-cover mb-4 rounded">
                            @endif

                            <!-- Hirdetés adatai -->
                            <h2 class="font-semibold text-lg">{{ $listing->title }}</h2>
                            <p>{{ \Illuminate\Support\Str::limit($listing->description, 100) }}</p>
                            <p class="mt-2 font-bold">{{ $listing->price }} Ft</p>
                            <p class="mt-1 text-sm text-gray-600">Város: {{ $listing->city }}</p>
                            <p class="mt-1 text-sm text-gray-600">Hirdetés típusa: {{ ucfirst($listing->delivery_method) }}</p>
                            <a href="{{ route('listings.show', $listing->id) }}" class="text-blue-500 mt-2 inline-block">További részletek</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
