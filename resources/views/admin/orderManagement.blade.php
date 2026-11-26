@extends('layouts.admin')

@section('content')
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
@endsection
