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
                <p class="text-neutral-400 text-sm leading-relaxed">Browse the menu, add to cart, and pay with QRIS —
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

                <div class="bg-blue-50 border border-blue-200 rounded-md px-4 py-3 mb-6">
                    <p class="text-blue-700 text-xs font-semibold mb-1">Demo accounts:</p>
                    <p class="text-blue-600 text-xs leading-relaxed">User: budi@campus.ac.id | Admin: admin@kantin.id
                    </p>
                    <p class="text-blue-600 text-xs">Any password works.</p>
                </div>

                <form class="flex flex-col gap-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-800 mb-1.5">Email</label>
                        <input type="email" placeholder="you@campus.ac.id"
                            class="w-full border border-neutral-300 rounded-md px-3 py-2 text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-800 mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password" placeholder="••••••••••"
                                class="w-full border border-neutral-300 rounded-md px-3 py-2 pr-10 text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-neutral-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.774 3.162 10.066 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-neutral-600">
                            <input type="checkbox" class="rounded border-neutral-300 text-red-600 focus:ring-red-500">
                            Remember me
                        </label>
                        <a href="#" class="text-sm text-red-600 font-medium hover:text-red-700">Forgot password?</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-600/90 transition-colors text-white text-sm font-medium py-2.5 rounded-md mt-1">
                        Sign In
                    </button>

                    <p class="text-center text-sm text-neutral-500">
                        Don't have an account? <a href="#" class="text-red-600 font-medium hover:text-red-700">Create
                            one</a>
                    </p>
                </form>

            </div>
        </div>

    </div>

</body>

</html>