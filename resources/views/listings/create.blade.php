<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hirdetés Feladása') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Cím -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Cím') }}</label>
                            <input type="text" name="title" id="title" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        </div>

                        <!-- Ár -->
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700">{{ __('Ár') }}</label>
                            <input type="number" name="price" id="price" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        </div>

                        <!-- Leírás -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Leírás') }}</label>
                            <textarea name="description" id="description" rows="4" class="form-input rounded-md shadow-sm mt-1 block w-full" required></textarea>
                        </div>

                        <!-- Város -->
                        <div class="mb-4">
                            <label for="city" class="block text-sm font-medium text-gray-700">{{ __('Város') }}</label>
                            <input type="text" name="city" id="city" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        </div>

                        <!-- Kategória -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">{{ __('Kategória') }}</label>
                            <select name="category_id" id="category_id" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="">Válassz kategóriát</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Hirdetés Típusa -->
                        <div class="mb-4">
                            <label for="delivery_method" class="block text-sm font-medium text-gray-700">{{ __('Átvétel') }}</label>
                            <select name="delivery_method" id="delivery_method" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="házhozszállítás">Házhozszállítás</option>
                                <option value="személyesen">Személyesen</option>
                                <option value="mindkettő">Mindkettő</option>
                            </select>
                        </div>

                        <!-- Képek -->
                        <div class="mb-4">
                            <label for="images" class="block text-sm font-medium text-gray-700">{{ __('Képek') }}</label>
                            <input type="file" name="images[]" id="images" class="form-input rounded-md shadow-sm mt-1 block w-full" multiple>
                        </div>

                        <!-- Küldés gomb -->
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Hirdetés Feladása') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
