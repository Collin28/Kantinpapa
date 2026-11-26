@extends('layouts.admin')

@section('content')
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
@endsection
