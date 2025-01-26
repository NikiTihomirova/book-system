<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Лого -->
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/books-logo.png') }}" alt="Books Logo" class="h-9 w-auto">
                    </a>
                </div>

                <!-- Линкове за навигация -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @guest
                        <!-- Вход и регистрация за гости -->
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            {{ __('Вход') }}
                        </x-nav-link>
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('Регистрация') }}
                        </x-nav-link>
                    @else
                        <!-- Линк към страницата за книги -->
                        <x-nav-link :href="route('books.index')" :active="request()->routeIs('books.index')">
                            {{ __('Книги') }}
                        </x-nav-link>

                        <!-- Линк към кошницата -->
                        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                            {{ __('Кошница') }}
                        </x-nav-link>
                    @endguest
                </div>
            </div>
            

            <!-- Настройки за логнати потребители -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Профил') }}
                            </x-dropdown-link>

                            <!-- Логаут -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Изход') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Мобилно меню -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Мобилно меню (отварящо се при малки екрани) -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @guest
                <!-- Навигация за гости -->
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Вход') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    {{ __('Регистрация') }}
                </x-responsive-nav-link>
            @else
                <!-- Навигация за логнати потребители -->
                <x-responsive-nav-link :href="route('books.index')" :active="request()->routeIs('books.index')">
                    {{ __('Книги') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                    {{ __('Кошница') }}
                </x-responsive-nav-link>
            @endguest
        </div>
    </div>
</nav>