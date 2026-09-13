<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinPapa - Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-white min-h-screen">

    <div class="flex min-h-screen">


        <aside class="w-64 bg-neutral-950 flex flex-col shrink-0">


            <div class="flex items-center gap-3 px-6 py-6 border-b border-neutral-800">
                <div class="w-12 h-12 rounded-md bg-red-600 shrink-0"></div>
                <div>
                    <div class="font-bold text-lg leading-tight">
                        <span class="text-white">Kantin</span><span class="text-red-500">Papa</span>
                    </div>
                    <div class="text-neutral-400 text-sm">Admin Panel</div>
                </div>
            </div>


            <nav class="flex flex-col gap-2 px-4 py-5">
                <a href="#"
                    class="flex items-center gap-3 bg-red-600 text-white font-semibold text-base px-4 py-3.5 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </a>
                <a href="#"
                    class="flex items-center gap-3 text-neutral-400 hover:text-neutral-200 font-semibold text-base px-4 py-3.5 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75M3.75 6.75h16.5M3.75 6.75v10.5A2.25 2.25 0 006 19.5h12a2.25 2.25 0 002.25-2.25V6.75M3.75 6.75L5.106 3.375A1.5 1.5 0 016.512 2.25h10.976a1.5 1.5 0 011.406 1.125L20.25 6.75" />
                    </svg>
                    Orders
                </a>
                <a href="#"
                    class="flex items-center gap-3 text-neutral-400 hover:text-neutral-200 font-semibold text-base px-4 py-3.5 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 5.25h16.5M3.75 12h16.5M3.75 18.75h16.5" />
                    </svg>
                    Menu
                </a>
                <a href="#"
                    class="flex items-center gap-3 text-neutral-400 hover:text-neutral-200 font-semibold text-base px-4 py-3.5 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                    Users
                </a>
            </nav>

            <div class="mt-auto flex flex-col gap-1 px-4 py-5 border-t border-neutral-800">
                <a href="#"
                    class="flex items-center gap-3 text-neutral-300 hover:text-white font-semibold text-base px-4 py-3 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Log out
                </a>
            </div>
        </aside>


        <main class="flex-1 px-10 py-10">
            <h1 class="font-bold text-neutral-950 text-4xl mb-1">Dashboard</h1>
            <p class="text-neutral-500 text-lg mb-8">Kamis, 20 Agustus 2026</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-4xl">


                <div class="border border-teal-100 rounded-xl px-6 py-6">
                    <div class="w-11 h-11 rounded-lg bg-neutral-100 flex items-center justify-center text-xl mb-4">💰
                    </div>
                    <div class="font-bold text-neutral-950 text-2xl mb-1">Rp 12.480.000</div>
                    <div class="text-neutral-700 font-medium text-sm">Total Revenue</div>
                    <div class="text-neutral-400 text-sm">+12% vs last week</div>
                </div>

                <div class="border border-teal-100 rounded-xl px-6 py-6">
                    <div class="w-11 h-11 rounded-lg bg-neutral-100 flex items-center justify-center text-xl mb-4">📈
                    </div>
                    <div class="font-bold text-neutral-950 text-2xl mb-1">Rp 845.000</div>
                    <div class="text-neutral-700 font-medium text-sm">Today's Revenue</div>
                    <div class="text-neutral-400 text-sm">23 orders today</div>
                </div>


                <div class="border border-teal-100 rounded-xl px-6 py-6">
                    <div class="w-11 h-11 rounded-lg bg-neutral-100 flex items-center justify-center text-xl mb-4">🧾
                    </div>
                    <div class="font-bold text-neutral-950 text-2xl mb-1">1,284</div>
                    <div class="text-neutral-700 font-medium text-sm">Total Orders</div>
                    <div class="text-neutral-400 text-sm">All time</div>
                </div>

                <div class="border border-teal-100 rounded-xl px-6 py-6">
                    <div class="w-11 h-11 rounded-lg bg-neutral-100 flex items-center justify-center text-xl mb-4">⏳
                    </div>
                    <div class="font-bold text-neutral-950 text-2xl mb-1">8</div>
                    <div class="text-neutral-700 font-medium text-sm">Pending Orders</div>
                    <div class="text-neutral-400 text-sm">Needs attention</div>
                </div>

                <div class="border border-teal-100 rounded-xl px-6 py-6">
                    <div class="w-11 h-11 rounded-lg bg-neutral-100 flex items-center justify-center text-xl mb-4">✅
                    </div>
                    <div class="font-bold text-neutral-950 text-2xl mb-1">1,241</div>
                    <div class="text-neutral-700 font-medium text-sm">Completed</div>
                    <div class="text-neutral-400 text-sm">96.6% success rate</div>
                </div>

                <div class="border border-teal-100 rounded-xl px-6 py-6">
                    <div class="w-11 h-11 rounded-lg bg-neutral-100 flex items-center justify-center text-xl mb-4">🍽️
                    </div>
                    <div class="font-bold text-neutral-950 text-2xl mb-1">12</div>
                    <div class="text-neutral-700 font-medium text-sm">Menu Items</div>
                    <div class="text-neutral-400 text-sm">11 available</div>
                </div>

            </div>
        </main>

    </div>

</body>

</html>