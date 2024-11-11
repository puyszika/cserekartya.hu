<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Kapcsolat
    </h1>

    <p class="mt-6 text-gray-500 leading-relaxed">
    Mindenféle probléma/hiba illetve egyéb panasszal kapcsolatban itt jelezzétek felénk!

    </p>
    Köszönettel: CsereKártya.hu csapata
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
    <div>
        <div class="container mx-auto px-4 py-8">
            <form action="{{ route('contact.send') }}" method="POST" class="mt-8 space-y-6">
                @csrf
                <form action="{{ route('contact.send') }}" method="POST" class="mt-8 space-y-6">
                    @csrf

                    <!-- Név -->
                    <div>
                        <label for="name" class="block text-lg font-medium text-gray-700">Név</label>
                        <input type="text" id="name" name="name" class="w-full mt-2 p-3 border border-gray-300 rounded-md" required>
                    </div>

                    <!-- E-mail -->
                    <div>
                        <label for="email" class="block text-lg font-medium text-gray-700">E-mail cím</label>
                        <input type="email" id="email" name="email" class="w-full mt-2 p-3 border border-gray-300 rounded-md" required>
                    </div>

                    <!-- Üzenet -->
                    <div>
                        <label for="message" class="block text-lg font-medium text-gray-700">Üzenet</label>
                        <textarea id="message" name="message" class="w-full mt-2 p-3 border border-gray-300 rounded-md" rows="4" required></textarea>
                    </div>

                    <!-- Küldés gomb -->
                    <div>
                        <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700">
                            Üzenet küldése
                        </button>
                    </div>
                </form>
                <button type="submit" class="p-3 mb-2 w-full bg-dark-500 text-dark">
                    Üzenet küldése
                </button>
            </form>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            Köszönjük, hogy ezzel is segítitek a munkánkat!
        </p>
    </div>
</div>
