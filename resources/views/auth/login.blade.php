<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinPapa - Login</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

    <div class="w-full min-h-screen flex flex-col lg:flex-row">

        <div class="lg:w-1/2 bg-neutral-950 flex flex-col justify-between px-10 py-10 lg:px-16 lg:py-14">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-red-600 inline-block"></span>
                    <span class="font-semibold text-lg">
                        <span class="text-white">Kantin</span><span class="text-red-500">Papa</span>
                    </span>
                </div>
            </div>

            <div class="max-w-md">
                <h1 class="text-white font-bold text-4xl leading-tight mb-4">Order campus food, effortlessly.</h1>
                <p class="text-neutral-400 text-sm leading-relaxed">Browse the menu, add to cart, and pay with QRIS -
                    all in minutes.</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <span class="bg-neutral-800 text-neutral-300 text-xs px-3 py-1.5 rounded-full">Nasi Ayam Bakar</span>
                <span class="bg-neutral-800 text-neutral-300 text-xs px-3 py-1.5 rounded-full">Mie Goreng</span>
                <span class="bg-neutral-800 text-neutral-300 text-xs px-3 py-1.5 rounded-full">Teh Es</span>
            </div>
        </div>


        <div class="lg:w-1/2 bg-white flex items-center justify-center px-6 py-14 lg:px-16">
            <div class="w-full max-w-sm">

                <h2 class="font-bold text-neutral-900 text-2xl mb-1">Welcome back</h2>
                <p class="text-neutral-500 text-sm mb-6">Sign in to your KantinPapa account</p>

                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-md px-4 py-3 mb-4 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="bg-blue-50 border border-blue-200 rounded-md px-4 py-3 mb-4 text-sm text-blue-700">
                        {{ session('info') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-md px-4 py-3 mb-4 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-neutral-800 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@campus.ac.id"
                            class="w-full border border-neutral-300 rounded-md px-3 py-2 text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-800 mb-1.5">Password</label>
                        <input type="password" name="password" placeholder="Password"
                            class="w-full border border-neutral-300 rounded-md px-3 py-2 text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            required>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-neutral-600">
                            <input type="checkbox" name="remember" value="1" class="rounded border-neutral-300 text-red-600 focus:ring-red-500">
                            Remember me
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-600/90 transition-colors text-white text-sm font-medium py-2.5 rounded-md mt-1">
                        Sign In
                    </button>

                    <p class="text-center text-sm text-neutral-500">
                        Don't have an account? <a href="{{ route('register') }}" class="text-red-600 font-medium hover:text-red-700">Create
                            one</a>
                    </p>
                </form>

            </div>
        </div>

    </div>

</body>

</html>
