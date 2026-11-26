@extends('layouts.admin')

@section('content')
    <h1 class="font-bold text-neutral-950 text-4xl mb-1">Manage Users</h1>
    <p class="text-neutral-500 text-lg mb-6">View and manage all registered KantinPapa users.</p>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div class="border border-teal-100 rounded-xl px-5 py-5">
            <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center text-lg mb-3">👤
            </div>
            <div class="font-bold text-neutral-950 text-2xl mb-0.5">8</div>
            <div class="text-neutral-500 text-sm">Total Users</div>
        </div>
        <div class="border border-teal-100 rounded-xl px-5 py-5">
            <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center text-lg mb-3">✅
            </div>
            <div class="font-bold text-neutral-950 text-2xl mb-0.5">7</div>
            <div class="text-neutral-500 text-sm">Active Users</div>
        </div>
        <div class="border border-teal-100 rounded-xl px-5 py-5">
            <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center text-lg mb-3">🧾
            </div>
            <div class="font-bold text-neutral-950 text-2xl mb-0.5">217</div>
            <div class="text-neutral-500 text-sm">Total Orders</div>
        </div>
        <div class="border border-teal-100 rounded-xl px-5 py-5">
            <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center text-lg mb-3">💰
            </div>
            <div class="font-bold text-neutral-950 text-2xl mb-0.5">Rp 6.480.000</div>
            <div class="text-neutral-500 text-sm">Total Spent</div>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-2 mb-6">
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-neutral-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35M18 10.5a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
            </svg>
            <input type="text" placeholder="Search name or email..."
                class="border border-neutral-200 text-sm text-neutral-700 placeholder-neutral-400 rounded-full pl-10 pr-4 py-2 w-64 focus:outline-none focus:border-neutral-400">
        </div>
        <button class="bg-neutral-950 text-white text-sm font-semibold px-5 py-2 rounded-full">All
            Roles</button>
        <button
            class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2 rounded-full">User</button>
        <button
            class="border border-neutral-200 text-neutral-500 hover:border-neutral-400 text-sm font-semibold px-5 py-2 rounded-full">Admin</button>
    </div>

    <div class="border border-neutral-200 rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-neutral-200">
                    <th class="text-left font-bold text-neutral-950 px-6 py-4 whitespace-nowrap">USER</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">EMAIL</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">ROLE</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">STATUS</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">ORDERS</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">TOTAL SPENT
                    </th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">JOINED</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">LAST ORDER</th>
                    <th class="text-left font-bold text-neutral-950 px-6 py-4 whitespace-nowrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>

                <tr class="border-b border-neutral-100">
                    <td class="px-6 py-4 font-semibold text-neutral-900 whitespace-nowrap">Budi Santoso</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">budi@campus.ac.id</td>
                    <td class="px-4 py-4"><span
                            class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-full">User</span>
                    </td>
                    <td class="px-4 py-4"><span
                            class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-full">Active</span>
                    </td>
                    <td class="px-4 py-4 text-neutral-700">42</td>
                    <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 1.240.000</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">12 Jan 2026</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">20 Aug 2026</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button
                                class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Edit</button>
                            <button
                                class="bg-orange-100 text-orange-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Suspend</button>
                            <button
                                class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Delete</button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-neutral-100">
                    <td class="px-6 py-4 font-semibold text-neutral-900 whitespace-nowrap">Siti Rahayu</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">siti@campus.ac.id</td>
                    <td class="px-4 py-4"><span
                            class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-full">User</span>
                    </td>
                    <td class="px-4 py-4"><span
                            class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-full">Active</span>
                    </td>
                    <td class="px-4 py-4 text-neutral-700">31</td>
                    <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 890.000</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">25 Feb 2026</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">19 Aug 2026</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button
                                class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Edit</button>
                            <button
                                class="bg-orange-100 text-orange-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Suspend</button>
                            <button
                                class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Delete</button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-neutral-100">
                    <td class="px-6 py-4 font-semibold text-neutral-900 whitespace-nowrap">Ahmad Rizki</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">ahmad@campus.ac.id</td>
                    <td class="px-4 py-4"><span
                            class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-full">User</span>
                    </td>
                    <td class="px-4 py-4"><span
                            class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-full">Active</span>
                    </td>
                    <td class="px-4 py-4 text-neutral-700">58</td>
                    <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 1.760.000</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">8 Mar 2026</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">20 Aug 2026</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button
                                class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Edit</button>
                            <button
                                class="bg-orange-100 text-orange-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Suspend</button>
                            <button
                                class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Delete</button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-neutral-100">
                    <td class="px-6 py-4 font-semibold text-neutral-900 whitespace-nowrap">Dewi Susanti</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">dewi@campus.ac.id</td>
                    <td class="px-4 py-4"><span
                            class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-full">User</span>
                    </td>
                    <td class="px-4 py-4"><span
                            class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-full">Suspended</span>
                    </td>
                    <td class="px-4 py-4 text-neutral-700">7</td>
                    <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 210.000</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">14 Apr 2026</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">5 Jul 2026</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button
                                class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Edit</button>
                            <button
                                class="bg-emerald-100 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Restore</button>
                            <button
                                class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Delete</button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-neutral-100">
                    <td class="px-6 py-4 font-semibold text-neutral-900 whitespace-nowrap">Reza Firmansyah</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">reza@campus.ac.id</td>
                    <td class="px-4 py-4"><span
                            class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-full">User</span>
                    </td>
                    <td class="px-4 py-4"><span
                            class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-full">Active</span>
                    </td>
                    <td class="px-4 py-4 text-neutral-700">24</td>
                    <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 720.000</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">2 May 2026</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">18 Aug 2026</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button
                                class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Edit</button>
                            <button
                                class="bg-orange-100 text-orange-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Suspend</button>
                            <button
                                class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Delete</button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-neutral-100">
                    <td class="px-6 py-4 font-semibold text-neutral-900 whitespace-nowrap">Linda Wati</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">linda@campus.ac.id</td>
                    <td class="px-4 py-4"><span
                            class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-full">User</span>
                    </td>
                    <td class="px-4 py-4"><span
                            class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-full">Active</span>
                    </td>
                    <td class="px-4 py-4 text-neutral-700">19</td>
                    <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 580.000</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">17 May 2026</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">17 Aug 2026</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button
                                class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Edit</button>
                            <button
                                class="bg-orange-100 text-orange-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Suspend</button>
                            <button
                                class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Delete</button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-neutral-100">
                    <td class="px-6 py-4 font-semibold text-neutral-900 whitespace-nowrap">Fajar Nugroho</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">fajar@campus.ac.id</td>
                    <td class="px-4 py-4"><span
                            class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-full">User</span>
                    </td>
                    <td class="px-4 py-4"><span
                            class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-full">Active</span>
                    </td>
                    <td class="px-4 py-4 text-neutral-700">36</td>
                    <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 1.080.000</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">30 May 2026</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">20 Aug 2026</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button
                                class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Edit</button>
                            <button
                                class="bg-orange-100 text-orange-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Suspend</button>
                            <button
                                class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Delete</button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="px-6 py-4 font-semibold text-neutral-900 whitespace-nowrap">Admin Kantin</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">admin@kantin.id</td>
                    <td class="px-4 py-4"><span
                            class="bg-purple-50 text-purple-500 text-xs font-semibold px-3 py-1.5 rounded-full">Admin</span>
                    </td>
                    <td class="px-4 py-4"><span
                            class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-full">Active</span>
                    </td>
                    <td class="px-4 py-4 text-neutral-700">0</td>
                    <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp 0</td>
                    <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">1 Jan 2026</td>
                    <td class="px-4 py-4 text-neutral-400 whitespace-nowrap">–</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button
                                class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Edit</button>
                            <button
                                class="bg-orange-100 text-orange-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Suspend</button>
                            <button
                                class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">Delete</button>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
@endsection
