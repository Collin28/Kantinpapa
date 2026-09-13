<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinPapa - Menu Management</title>
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
                    class="flex items-center gap-3 text-neutral-400 hover:text-neutral-200 font-semibold text-base px-4 py-3.5 rounded-lg transition-colors">
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
                    class="flex items-center gap-3 bg-red-600 text-white font-semibold text-base px-4 py-3.5 rounded-lg">
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

            <div class="flex items-start justify-between mb-6">
                <div>
                    <h1 class="font-bold text-neutral-950 text-4xl mb-1">Menu Management</h1>
                    <p class="text-neutral-500 text-lg">8 items total - 7 available</p>
                </div>
                <button
                    class="bg-red-600 hover:bg-red-600/90 transition-colors text-white text-sm font-semibold px-6 py-3 rounded-lg whitespace-nowrap">
                    + Add items
                </button>
            </div>


            <div class="flex flex-wrap items-center gap-2 mb-8">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-neutral-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M18 10.5a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
                    </svg>
                    <input type="text" placeholder="Search menu..."
                        class="border border-neutral-200 text-sm text-neutral-700 placeholder-neutral-400 rounded-lg pl-11 pr-4 py-2.5 w-64 focus:outline-none focus:border-neutral-400">
                </div>
                <button class="bg-neutral-950 text-white text-sm font-semibold px-5 py-2.5 rounded-full">All</button>
                <button
                    class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2.5 rounded-full">Rice
                    Bowls</button>
                <button
                    class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2.5 rounded-full">Noodles</button>
                <button
                    class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2.5 rounded-full">Snacks</button>
                <button
                    class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2.5 rounded-full">Drinks</button>
                <button
                    class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2.5 rounded-full">Desserts</button>
            </div>


            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">


                <article class="border border-neutral-200 rounded-xl overflow-hidden">
                    <div class="relative h-36 bg-neutral-100">
                        <img src="https://images.unsplash.com/photo-1610057099431-d73a1c9d2f2f?w=400&q=80"
                            alt="Nasi Ayam Bakar" class="w-full h-full object-cover">
                        <span
                            class="absolute top-2.5 right-2.5 bg-green-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full">Active</span>
                    </div>
                    <div class="px-4 pt-3 pb-4">
                        <h3 class="font-semibold text-neutral-950 text-sm">Nasi Ayam Bakar</h3>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-neutral-800 text-sm">Rp 18.000</span>
                            <span class="text-emerald-600 text-xs font-medium">24 left</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                class="flex-1 border border-neutral-200 text-neutral-600 text-sm font-medium py-2 rounded-lg">Edit</button>
                            <button
                                class="flex-1 bg-red-50 text-red-500 text-sm font-medium py-2 rounded-lg">Delete</button>
                        </div>
                    </div>
                </article>


                <article class="border border-neutral-200 rounded-xl overflow-hidden">
                    <div class="relative h-36 bg-neutral-100">
                        <img src="https://images.unsplash.com/photo-1610057099431-d73a1c9d2f2f?w=400&q=80"
                            alt="Nasi Ayam Bakar" class="w-full h-full object-cover">
                        <span
                            class="absolute top-2.5 right-2.5 bg-green-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full">Active</span>
                    </div>
                    <div class="px-4 pt-3 pb-4">
                        <h3 class="font-semibold text-neutral-950 text-sm">Nasi Ayam Bakar</h3>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-neutral-800 text-sm">Rp 18.000</span>
                            <span class="text-emerald-600 text-xs font-medium">24 left</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                class="flex-1 border border-neutral-200 text-neutral-600 text-sm font-medium py-2 rounded-lg">Edit</button>
                            <button
                                class="flex-1 bg-red-50 text-red-500 text-sm font-medium py-2 rounded-lg">Delete</button>
                        </div>
                    </div>
                </article>


                <article class="border border-neutral-200 rounded-xl overflow-hidden">
                    <div class="relative h-36 bg-neutral-100">
                        <img src="https://images.unsplash.com/photo-1610057099431-d73a1c9d2f2f?w=400&q=80"
                            alt="Nasi Ayam Bakar" class="w-full h-full object-cover">
                        <span
                            class="absolute top-2.5 right-2.5 bg-green-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full">Active</span>
                    </div>
                    <div class="px-4 pt-3 pb-4">
                        <h3 class="font-semibold text-neutral-950 text-sm">Nasi Ayam Bakar</h3>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-neutral-800 text-sm">Rp 18.000</span>
                            <span class="text-emerald-600 text-xs font-medium">24 left</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                class="flex-1 border border-neutral-200 text-neutral-600 text-sm font-medium py-2 rounded-lg">Edit</button>
                            <button
                                class="flex-1 bg-red-50 text-red-500 text-sm font-medium py-2 rounded-lg">Delete</button>
                        </div>
                    </div>
                </article>


                <article class="border border-neutral-200 rounded-xl overflow-hidden">
                    <div class="relative h-36 bg-neutral-100">
                        <img src="https://images.unsplash.com/photo-1610057099431-d73a1c9d2f2f?w=400&q=80"
                            alt="Nasi Ayam Bakar" class="w-full h-full object-cover">
                        <span
                            class="absolute top-2.5 right-2.5 bg-green-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full">Active</span>
                    </div>
                    <div class="px-4 pt-3 pb-4">
                        <h3 class="font-semibold text-neutral-950 text-sm">Nasi Ayam Bakar</h3>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-neutral-800 text-sm">Rp 18.000</span>
                            <span class="text-emerald-600 text-xs font-medium">24 left</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                class="flex-1 border border-neutral-200 text-neutral-600 text-sm font-medium py-2 rounded-lg">Edit</button>
                            <button
                                class="flex-1 bg-red-50 text-red-500 text-sm font-medium py-2 rounded-lg">Delete</button>
                        </div>
                    </div>
                </article>


                <article class="border border-neutral-200 rounded-xl overflow-hidden">
                    <div class="relative h-36 bg-neutral-100">
                        <img src="https://images.unsplash.com/photo-1610057099431-d73a1c9d2f2f?w=400&q=80"
                            alt="Nasi Ayam Bakar" class="w-full h-full object-cover">
                        <span
                            class="absolute top-2.5 right-2.5 bg-green-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full">Active</span>
                    </div>
                    <div class="px-4 pt-3 pb-4">
                        <h3 class="font-semibold text-neutral-950 text-sm">Nasi Ayam Bakar</h3>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-neutral-800 text-sm">Rp 18.000</span>
                            <span class="text-emerald-600 text-xs font-medium">24 left</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                class="flex-1 border border-neutral-200 text-neutral-600 text-sm font-medium py-2 rounded-lg">Edit</button>
                            <button
                                class="flex-1 bg-red-50 text-red-500 text-sm font-medium py-2 rounded-lg">Delete</button>
                        </div>
                    </div>
                </article>


                <article class="border border-neutral-200 rounded-xl overflow-hidden">
                    <div class="relative h-36 bg-neutral-100">
                        <img src="https://images.unsplash.com/photo-1610057099431-d73a1c9d2f2f?w=400&q=80"
                            alt="Nasi Ayam Bakar" class="w-full h-full object-cover">
                        <span
                            class="absolute top-2.5 right-2.5 bg-green-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full">Active</span>
                    </div>
                    <div class="px-4 pt-3 pb-4">
                        <h3 class="font-semibold text-neutral-950 text-sm">Nasi Ayam Bakar</h3>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-neutral-800 text-sm">Rp 18.000</span>
                            <span class="text-emerald-600 text-xs font-medium">24 left</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                class="flex-1 border border-neutral-200 text-neutral-600 text-sm font-medium py-2 rounded-lg">Edit</button>
                            <button
                                class="flex-1 bg-red-50 text-red-500 text-sm font-medium py-2 rounded-lg">Delete</button>
                        </div>
                    </div>
                </article>

                <article class="border border-neutral-200 rounded-xl overflow-hidden">
                    <div class="relative h-36 bg-neutral-100">
                        <img src="https://images.unsplash.com/photo-1610057099431-d73a1c9d2f2f?w=400&q=80"
                            alt="Nasi Ayam Bakar" class="w-full h-full object-cover grayscale">
                        <span
                            class="absolute top-2.5 right-2.5 bg-neutral-600 text-white text-xs font-semibold px-2.5 py-1 rounded-full">Off</span>
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                            <span
                                class="bg-neutral-900 text-white text-xs font-medium px-4 py-1.5 rounded-full">Unavailable</span>
                        </div>
                    </div>
                    <div class="px-4 pt-3 pb-4">
                        <h3 class="font-semibold text-neutral-950 text-sm">Nasi Ayam Bakar</h3>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-neutral-800 text-sm">Rp 18.000</span>
                            <span class="text-emerald-600 text-xs font-medium">24 left</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                class="flex-1 border border-neutral-200 text-neutral-600 text-sm font-medium py-2 rounded-lg">Edit</button>
                            <button
                                class="flex-1 bg-red-50 text-red-500 text-sm font-medium py-2 rounded-lg">Delete</button>
                        </div>
                    </div>
                </article>


                <article class="border border-neutral-200 rounded-xl overflow-hidden">
                    <div class="relative h-36 bg-neutral-100">
                        <img src="https://images.unsplash.com/photo-1610057099431-d73a1c9d2f2f?w=400&q=80"
                            alt="Nasi Ayam Bakar" class="w-full h-full object-cover">
                        <span
                            class="absolute top-2.5 right-2.5 bg-green-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full">Active</span>
                    </div>
                    <div class="px-4 pt-3 pb-4">
                        <h3 class="font-semibold text-neutral-950 text-sm">Nasi Ayam Bakar</h3>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-neutral-800 text-sm">Rp 18.000</span>
                            <span class="text-emerald-600 text-xs font-medium">24 left</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                class="flex-1 border border-neutral-200 text-neutral-600 text-sm font-medium py-2 rounded-lg">Edit</button>
                            <button
                                class="flex-1 bg-red-50 text-red-500 text-sm font-medium py-2 rounded-lg">Delete</button>
                        </div>
                    </div>
                </article>

            </div>
        </main>

    </div>

</body>

</html>