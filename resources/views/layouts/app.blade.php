<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KantinPapa - {{ $title ?? 'Campus Food' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white min-h-screen text-neutral-900 font-sans">

    {{-- Customer Navbar --}}
    <header class="bg-white border-b border-neutral-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            {{-- Logo --}}
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-red-600 rounded-lg"></div>
                <a href="{{ route('menu.index') }}" class="text-xl font-bold">
                    <span class="text-neutral-900">Kantin</span><span class="text-red-600">Papa</span>
                </a>
            </div>

            {{-- Nav Links --}}
            <nav class="hidden sm:flex items-center gap-8 text-sm">
                <a href="{{ route('menu.index') }}"
                   class="{{ request()->routeIs('menu.*') ? 'text-red-600 font-semibold' : 'text-neutral-500 hover:text-neutral-800' }}">
                    Menu
                </a>
                @auth
                <a href="{{ route('orders.index') }}"
                   class="{{ request()->routeIs('orders.*') ? 'text-red-600 font-semibold' : 'text-neutral-500 hover:text-neutral-800' }}">
                    My Orders
                </a>
                @endauth
            </nav>

            {{-- Right Side --}}
            <div class="flex items-center gap-4">
                @php($cartCount = app(\App\Services\CartService::class)->count())
                <a href="{{ route('cart.index') }}" class="relative p-1 text-neutral-700 hover:text-neutral-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.98-4.804 2.545-7.454A1.125 1.125 0 0019.905 4.5H5.106M7.5 14.25L5.106 4.5M7.5 14.25L5.25 20.25M17.25 20.25a.75.75 0 100-1.5.75.75 0 000 1.5zm-9 0a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                    </svg>
                    @if ($cartCount > 0)
                        <span class="absolute -top-1.5 -right-1.5 bg-red-600 text-white text-[10px] font-semibold rounded-full min-w-4 h-4 px-1 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                @auth
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-semibold text-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden sm:inline text-sm text-neutral-800">{{ auth()->user()->name }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-medium text-neutral-500 hover:text-red-600 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Page Content --}}
    @yield('content')

    @stack('scripts')
</body>

</html>
