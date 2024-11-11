<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        {{ __('Kezdőlap') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('listings.index') }}" :active="request()->routeIs('listings.index')">
                        {{ __('Hirdetések') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">
                        {{ __('Kapcsolat') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Hirdetés Feladása Gomb -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <a href="{{ auth()->check() ? route('listings.create') : route('login') }}" style="background-color: #28a745; color: white; font-weight: bold; padding: 10px 20px; border-radius: 5px; text-align: center; z-index: 10;" class="hover:bg-green-700">
                    {{ __('Hirdetés Feladása') }}
                </a>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-4">
                    @guest
                        <!-- Bejelentkezés és Regisztráció linkek a lenyitható menüben -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Fiók') }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Bejelentkezés link -->
                                <x-dropdown-link href="{{ route('login') }}">
                                    {{ __('Bejelentkezés') }}
                                </x-dropdown-link>

                                <!-- Regisztráció link -->
                                <x-dropdown-link href="{{ route('register') }}">
                                    {{ __('Regisztráció') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <!-- Authenticated user dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Dashboard link -->
                                <x-dropdown-link href="{{ route('dashboard') }}">
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>

                                <!-- Üzenetek link, az olvasatlan üzenetek számával -->
                                <x-dropdown-link href="{{ route('messages.index') }}">
                                    {{ __('Üzenetek') }}
                                    @php
                                        $unreadMessagesCount = Auth::user()->receivedMessages()->unread()->count();
                                    @endphp
                                    @if($unreadMessagesCount > 0)
                                        <span class="ml-2 text-sm text-red-500">({{ $unreadMessagesCount }})</span>
                                    @endif
                                </x-dropdown-link>

                                <!-- Logout link -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                                     onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                        {{ __('Kijelentkezés') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</nav>
