<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                        <span class="text-2xl font-bold text-[#003366] dark:text-white">Added <span class="text-[#00a859]">UT</span></span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">

                <a href="#" class="flex items-center gap-1 text-sm font-semibold text-[#003366] dark:text-gray-300 hover:text-green-600 transition">
                    <i class='bx bx-calendar text-xl'></i> Eventos
                </a>

                <a href="#" class="flex items-center gap-1 text-sm font-semibold text-[#003366] dark:text-gray-300 hover:text-green-600 transition">
                    <i class='bx bx-rss text-xl'></i> Noticias
                </a>

                {{-- CAMPANA DE NOTIFICACIONES --}}
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button class="relative inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 hover:text-[#00a859] focus:outline-none transition">
                                <i class='bx bx-bell text-2xl'></i>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <div class="absolute block w-2.5 h-2.5 bg-red-500 border-2 border-white dark:border-gray-800 rounded-full top-1 right-1"></div>
                                @endif
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-80">
                                <div class="flex justify-between items-center px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                                    <span class="text-xs text-gray-400 font-bold uppercase">Notificaciones</span>
                                    @if(Auth::user()->unreadNotifications->count() > 0)
                                        <form method="POST" action="{{ route('notificaciones.markAllRead') }}">
                                            @csrf
                                            <button type="submit" class="text-xs text-blue-500 hover:underline">
                                                Marcar todas como leídas
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <div class="max-h-64 overflow-y-auto">
                                    @forelse(Auth::user()->unreadNotifications as $notificacion)
                                        <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700 transition cursor-pointer">
                                            <div class="flex items-start">
                                                <i class='bx {{ $notificacion->data["tipo"] === "cambio" ? "bx-time-five text-amber-500" : "bx-x-circle text-red-500" }} text-lg mt-1'></i>
                                                <div class="ms-3">
                                                    <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $notificacion->data['titulo'] }}</p>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $notificacion->data['mensaje'] }}</p>
                                                    <p class="text-[10px] text-gray-400 mt-1">{{ $notificacion->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="px-4 py-6 text-center text-sm text-gray-400">
                                            <i class='bx bx-bell-off text-3xl block mb-1'></i>
                                            Sin notificaciones nuevas
                                        </div>
                                    @endforelse
                                </div>

                                <x-dropdown-link href="#" class="text-center text-xs text-blue-600 font-bold py-2 border-t border-gray-100 dark:border-gray-700">
                                    {{ __('Ver todo el historial') }}
                                </x-dropdown-link>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                {{-- MENÚ DE USUARIO --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-md text-[#003366] dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-[#00a859] focus:outline-none transition ease-in-out duration-150 gap-1">
                            <i class='bx bx-user-circle text-2xl'></i>
                            <div>{{ Auth::user()->name }}</div>
                            <i class='bx bx-chevron-down text-lg'></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- BOTÓN HAMBURGUESA MÓVIL --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150">
                    <i class='bx bx-menu text-2xl' :class="{'hidden': open, 'block': ! open }"></i>
                    <i class='bx bx-x text-2xl' :class="{'hidden': ! open, 'block': open }"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- MENÚ MÓVIL --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Eventos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Noticias') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#" class="flex justify-between items-center">
                {{ __('Notificaciones') }}
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full">
                        {{ Auth::user()->unreadNotifications->count() }}
                    </span>
                @endif
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4 font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Salir') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>