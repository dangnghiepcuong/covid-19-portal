<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('navigation.dashboard') }}
                    </x-nav-link>
                    @auth
                        @switch(Auth::user()->role_id)
                            @case($roles::ROLE_ADMIN)
                                <x-nav-link :href="route('businesses.index')">
                                    {{ __('object.management', ['object' => __('business.business')]) }}
                                </x-nav-link>

                                <x-nav-link :href="route('vaccines.index')">
                                    {{ __('object.management', ['object' => __('vaccine.vaccine')]) }}
                                </x-nav-link>
                            @break

                            @case($roles::ROLE_BUSINESS)
                                <x-nav-link :href="route('vaccine-lots.index')">
                                    {{ __('object.management', ['object' => __('vaccine-lot.vaccine_lot')]) }}
                                </x-nav-link>

                                <x-nav-link :href="route('schedules.index')">
                                    {{ __('object.management', ['object' => __('schedule.schedule')]) }}
                                </x-nav-link>
                            @break

                            @case($roles::ROLE_USER)
                                <x-nav-link :href="route('vaccination.index')">
                                    {{ __('vaccination.vaccination') }}
                                </x-nav-link>

                                <x-nav-link :href="route('registrations.index')">
                                    {{ __('registration.log') }}
                                </x-nav-link>
                            @break

                            @default
                        @endswitch
                    @endauth
                </div>
            </div>


            <!-- NAV RIGHT SIDE -->
            <div class="flex">
                {{-- NOTIFICATION BELL --}}
                <div class="notifications">
                    <div class="flex icon_wrap">
                        <i class="far fa-bell"></i>
                        <div id="new_notification_dot" class="new_notification_dot"></div>
                    </div>
                    <div id="notification_dd" class="notification_dd">
                        <input id="markAllAsReadToken" type="hidden" value="{{ csrf_token() }}">
                        <input type="hidden" id="last_page" value="0">
                        <input type="hidden" id="current_page" value="-1">
                        <ul id="notification_ul" class="notification_ul">
                            <li class="show_all">
                                <p class="link">{{ __('notification.mark_all_as_read') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <a href="{{ route('locale', ['lang' => 'vi']) }}" class="mx-1 my-auto">
                    <img class="w-25px" alt="VN"
                        src="http://purecatamphetamine.github.io/country-flag-icons/3x2/VN.svg" />
                </a>
                <a href="{{ route('locale', ['lang' => 'en']) }}" class="mx-1 my-auto">
                    <img class="w-25px" alt="US"
                        src="http://purecatamphetamine.github.io/country-flag-icons/3x2/US.svg" />
                </a>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->email }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @switch(Auth::user()->role_id)
                                @case($roles::ROLE_ADMIN)
                                @case($roles::ROLE_BUSINESS)
                                    <x-dropdown-link :href="route('businesses.profile')">
                                        {{ Auth::user()->email }}
                                    </x-dropdown-link>
                                @break

                                @case($roles::ROLE_USER)
                                    <x-dropdown-link :href="route('users.profile')">
                                        {{ Auth::user()->email }}
                                    </x-dropdown-link>
                                @break

                                @default
                            @endswitch

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('navigation.logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-responsive-nav-link :href="route('dashboard')">
                    {{ __('navigation.dashboard') }}
                </x-responsive-nav-link>
                @switch(Auth::user()->role_id)
                    @case($roles::ROLE_ADMIN)
                        <x-responsive-nav-link :href="route('businesses.index')">
                            {{ __('object.management', ['object' => __('business.business')]) }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('vaccines.index')">
                            {{ __('object.management', ['object' => __('vaccine.vaccine')]) }}
                        </x-responsive-nav-link>
                    @break

                    @case($roles::ROLE_BUSINESS)
                        <x-responsive-nav-link :href="route('vaccine-lots.index')">
                            {{ __('object.management', ['object' => __('vaccine-lot.vaccine_lot')]) }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('schedules.index')">
                            {{ __('object.management', ['object' => __('schedule.schedule')]) }}
                        </x-responsive-nav-link>
                    @break

                    @case($roles::ROLE_USER)
                        <x-responsive-nav-link :href="route('vaccination.index')">
                            {{ __('vaccination.vaccination') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('registrations.index')">
                            {{ __('registration.log') }}
                        </x-responsive-nav-link>
                    @break

                    @default
                @endswitch
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->email }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('navigation.logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
