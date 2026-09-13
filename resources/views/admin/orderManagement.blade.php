<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinPapa - Order Management</title>
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
                    class="flex items-center gap-3 bg-red-600 text-white font-semibold text-base px-4 py-3.5 rounded-lg">
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
            <h1 class="font-bold text-neutral-950 text-4xl mb-1">Order Management</h1>
            <p class="text-neutral-500 text-lg mb-6">Monitor and update order statuses in real time.</p>


            <div class="flex flex-wrap items-center gap-2 mb-6">
                <button class="bg-neutral-950 text-white text-sm font-semibold px-5 py-2 rounded-full">All</button>
                <button
                    class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2 rounded-full">Pending</button>
                <button
                    class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2 rounded-full">Paid</button>
                <button
                    class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2 rounded-full">Preparing</button>
                <button
                    class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2 rounded-full">Ready</button>
                <button
                    class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2 rounded-full">Completed</button>
                <button
                    class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2 rounded-full">Cancelled</button>
            </div>

            <div class="border border-neutral-200 rounded-2xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-neutral-200">
                            <th class="text-left font-bold text-neutral-950 tracking-wide px-6 py-5 whitespace-nowrap">
                                ORDER ID</th>
                            <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                                CUSTOMERS</th>
                            <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                                ITEMS</th>
                            <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                                QTY</th>
                            <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                                TOTAL</th>
                            <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                                PAYMENT</th>
                            <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                                STATUS</th>
                            <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                                DATE</th>
                            <th class="text-left font-bold text-neutral-950 tracking-wide px-6 py-5 whitespace-nowrap">
                                ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>


                        <tr class="border-b border-neutral-100">
                            <td class="px-6 py-4 font-semibold text-neutral-800 whitespace-nowrap">KTG-891248</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Fajar Nugroho</td>
                            <td class="px-4 py-4 text-neutral-500">Nasi Goreng Kampung ×2</td>
                            <td class="px-4 py-4 text-neutral-700">2</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 33.000</td>
                            <td class="px-4 py-4"><span
                                    class="bg-orange-50 text-orange-600 text-xs font-semibold px-3 py-1.5 rounded-full">Pending</span>
                            </td>
                            <td class="px-4 py-4"><span
                                    class="bg-orange-50 text-orange-600 text-xs font-semibold px-3 py-1.5 rounded-full">Pending</span>
                            </td>
                            <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">20 Aug, 12:45</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button
                                        class="bg-neutral-950 text-white text-xs font-semibold px-3 py-2 rounded-lg whitespace-nowrap">→
                                        Paid</button>
                                    <button
                                        class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-2 rounded-lg whitespace-nowrap">Cancel</button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-neutral-100">
                            <td class="px-6 py-4 font-semibold text-neutral-800 whitespace-nowrap">KTG-891249</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Budi Santoso</td>
                            <td class="px-4 py-4 text-neutral-500">Nasi Ayam Bakar ×4</td>
                            <td class="px-4 py-4 text-neutral-700">4</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 50.600</td>
                            <td class="px-4 py-4"><span
                                    class="bg-indigo-50 text-indigo-500 text-xs font-semibold px-3 py-1.5 rounded-full">Paid</span>
                            </td>
                            <td class="px-4 py-4"><span
                                    class="bg-rose-50 text-rose-500 text-xs font-semibold px-3 py-1.5 rounded-full">Preparing</span>
                            </td>
                            <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">20 Aug, 12:32</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button
                                        class="bg-neutral-950 text-white text-xs font-semibold px-3 py-2 rounded-lg whitespace-nowrap">→
                                        Ready</button>
                                    <button
                                        class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-2 rounded-lg whitespace-nowrap">Cancel</button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-neutral-100">
                            <td class="px-6 py-4 font-semibold text-neutral-800 whitespace-nowrap">KTG-891250</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Siti Rahayu</td>
                            <td class="px-4 py-4 text-neutral-500">Mie Goreng Spesial ×1</td>
                            <td class="px-4 py-4 text-neutral-700">1</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 17.600</td>
                            <td class="px-4 py-4"><span
                                    class="bg-indigo-50 text-indigo-500 text-xs font-semibold px-3 py-1.5 rounded-full">Paid</span>
                            </td>
                            <td class="px-4 py-4"><span
                                    class="bg-emerald-50 text-emerald-400 text-xs font-semibold px-3 py-1.5 rounded-full">Ready</span>
                            </td>
                            <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">20 Aug, 11:55</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button
                                        class="bg-neutral-950 text-white text-xs font-semibold px-3 py-2 rounded-lg whitespace-nowrap leading-tight">→<br>Completed</button>
                                    <button
                                        class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-2 rounded-lg whitespace-nowrap">Cancel</button>
                                </div>
                            </td>
                        </tr>


                        <tr class="border-b border-neutral-100">
                            <td class="px-6 py-4 font-semibold text-neutral-800 whitespace-nowrap">KTG-891251</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Ahmad Rizki</td>
                            <td class="px-4 py-4 text-neutral-500">Bakso Sapi ×2, Jus ×1</td>
                            <td class="px-4 py-4 text-neutral-700">3</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 48.400</td>
                            <td class="px-4 py-4"><span
                                    class="bg-indigo-50 text-indigo-500 text-xs font-semibold px-3 py-1.5 rounded-full">Paid</span>
                            </td>
                            <td class="px-4 py-4"><span
                                    class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-full">Completed</span>
                            </td>
                            <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">20 Aug, 11:20</td>
                            <td class="px-6 py-4"></td>
                        </tr>


                        <tr class="border-b border-neutral-100">
                            <td class="px-6 py-4 font-semibold text-neutral-800 whitespace-nowrap">KTG-891252</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Dewi Susanti</td>
                            <td class="px-4 py-4 text-neutral-500">Pisang Goreng Keju ×3</td>
                            <td class="px-4 py-4 text-neutral-700">3</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 26.400</td>
                            <td class="px-4 py-4"><span
                                    class="bg-indigo-50 text-indigo-500 text-xs font-semibold px-3 py-1.5 rounded-full">Paid</span>
                            </td>
                            <td class="px-4 py-4"><span
                                    class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-full">Completed</span>
                            </td>
                            <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">20 Aug, 10:50</td>
                            <td class="px-6 py-4"></td>
                        </tr>

                        <tr class="border-b border-neutral-100">
                            <td class="px-6 py-4 font-semibold text-neutral-800 whitespace-nowrap">KTG-891253</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Reza Firmansyah</td>
                            <td class="px-4 py-4 text-neutral-500">Gado-Gado ×1, Es Campur ×2</td>
                            <td class="px-4 py-4 text-neutral-700">3</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 36.300</td>
                            <td class="px-4 py-4"><span
                                    class="bg-indigo-50 text-indigo-500 text-xs font-semibold px-3 py-1.5 rounded-full">Paid</span>
                            </td>
                            <td class="px-4 py-4"><span
                                    class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-full">Completed</span>
                            </td>
                            <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">20 Aug, 10:15</td>
                            <td class="px-6 py-4"></td>
                        </tr>


                        <tr>
                            <td class="px-6 py-4 font-semibold text-neutral-800 whitespace-nowrap">KTG-891254</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Linda Wati</td>
                            <td class="px-4 py-4 text-neutral-500">Martabak Telur ×2, Es Teh ×3</td>
                            <td class="px-4 py-4 text-neutral-700">5</td>
                            <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 49.500</td>
                            <td class="px-4 py-4"><span
                                    class="bg-indigo-50 text-indigo-500 text-xs font-semibold px-3 py-1.5 rounded-full">Paid</span>
                            </td>
                            <td class="px-4 py-4"><span
                                    class="bg-rose-50 text-rose-500 text-xs font-semibold px-3 py-1.5 rounded-full">Cancelled</span>
                            </td>
                            <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">20 Aug, 09:30</td>
                            <td class="px-6 py-4"></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </main>

    </div>

</body>

</html>