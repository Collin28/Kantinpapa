@extends('layouts.admin')

@section('content')
    <h1 class="font-bold text-neutral-950 text-4xl mb-1">Manage Users</h1>
    <p class="text-neutral-500 text-lg mb-6">View and manage all registered KantinPapa users.</p>

    @if (session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm font-medium px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div class="border border-teal-100 rounded-xl px-5 py-5">
            <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center text-lg mb-3">👤
            </div>
            <div class="font-bold text-neutral-950 text-2xl mb-0.5">{{ number_format($totalUsers) }}</div>
            <div class="text-neutral-500 text-sm">Total Users</div>
        </div>
        <div class="border border-teal-100 rounded-xl px-5 py-5">
            <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center text-lg mb-3">✅
            </div>
            <div class="font-bold text-neutral-950 text-2xl mb-0.5">{{ number_format($activeUsers) }}</div>
            <div class="text-neutral-500 text-sm">Active Users</div>
        </div>
        <div class="border border-teal-100 rounded-xl px-5 py-5">
            <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center text-lg mb-3">🧾
            </div>
            <div class="font-bold text-neutral-950 text-2xl mb-0.5">{{ number_format($totalOrders) }}</div>
            <div class="text-neutral-500 text-sm">Total Orders</div>
        </div>
        <div class="border border-teal-100 rounded-xl px-5 py-5">
            <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center text-lg mb-3">💰
            </div>
            <div class="font-bold text-neutral-950 text-2xl mb-0.5">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
            <div class="text-neutral-500 text-sm">Total Spent</div>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-2 mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="relative">
            @if ($selectedRole !== '')
                <input type="hidden" name="role" value="{{ $selectedRole }}">
            @endif
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-neutral-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35M18 10.5a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
            </svg>
            <input type="text" name="q" value="{{ $search }}" placeholder="Search name or email..."
                class="border border-neutral-200 text-sm text-neutral-700 placeholder-neutral-400 rounded-full pl-10 pr-4 py-2 w-64 focus:outline-none focus:border-neutral-400">
        </form>
        <a href="{{ route('admin.users.index', array_filter(['q' => $search])) }}"
            class="{{ $selectedRole === '' ? 'bg-neutral-950 text-white' : 'border border-neutral-200 text-neutral-500 hover:border-neutral-400' }} text-sm font-semibold px-5 py-2 rounded-full transition">
            All Roles
        </a>
        <a href="{{ route('admin.users.index', array_filter(['role' => 'user', 'q' => $search])) }}"
            class="{{ $selectedRole === 'user' ? 'bg-neutral-950 text-white' : 'border border-neutral-200 text-neutral-500 hover:border-neutral-400' }} text-sm font-semibold px-5 py-2 rounded-full transition">
            User
        </a>
        <a href="{{ route('admin.users.index', array_filter(['role' => 'admin', 'q' => $search])) }}"
            class="{{ $selectedRole === 'admin' ? 'bg-neutral-950 text-white' : 'border border-neutral-200 text-neutral-500 hover:border-neutral-400' }} text-sm font-semibold px-5 py-2 rounded-full transition">
            Admin
        </a>
    </div>

    <div class="border border-neutral-200 rounded-2xl overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-neutral-200">
                    <th class="text-left font-bold text-neutral-950 px-6 py-4 whitespace-nowrap">USER</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">EMAIL</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">ROLE</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">STATUS</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">ORDERS</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">TOTAL SPENT</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">JOINED</th>
                    <th class="text-left font-bold text-neutral-950 px-4 py-4 whitespace-nowrap">LAST ORDER</th>
                    <th class="text-left font-bold text-neutral-950 px-6 py-4 whitespace-nowrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $managedUser)
                    @php
                        $isSelf = $managedUser->id === auth()->id();
                        $lastOrder = $managedUser->orders_max_created_at
                            ? \Illuminate\Support\Carbon::parse($managedUser->orders_max_created_at)->format('d M Y')
                            : null;
                    @endphp
                    <tr class="border-b border-neutral-100 last:border-b-0">
                        <td class="px-6 py-4 font-semibold text-neutral-900 whitespace-nowrap">{{ $managedUser->name }}</td>
                        <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">{{ $managedUser->email }}</td>
                        <td class="px-4 py-4">
                            @if ($managedUser->isAdmin())
                                <span class="bg-purple-50 text-purple-500 text-xs font-semibold px-3 py-1.5 rounded-full">Admin</span>
                            @else
                                <span class="border border-neutral-200 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-full">User</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            @if ($managedUser->isActive())
                                <span class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-full">Active</span>
                            @else
                                <span class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-full">Suspended</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-neutral-700">{{ $managedUser->orders_count }}</td>
                        <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">Rp {{ number_format((int) ($managedUser->total_spent ?? 0), 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">{{ $managedUser->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">{{ $lastOrder ?? '–' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.edit', $managedUser) }}"
                                    class="border border-neutral-200 hover:bg-neutral-50 text-neutral-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap">
                                    Edit
                                </a>
                                @if (! $isSelf)
                                    @if ($managedUser->isActive())
                                        <form action="{{ route('admin.users.suspend', $managedUser) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="bg-orange-100 hover:bg-orange-200 text-orange-600 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap transition">
                                                Suspend
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.restore', $managedUser) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="bg-emerald-100 hover:bg-emerald-200 text-emerald-600 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap transition">
                                                Restore
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.users.destroy', $managedUser) }}" method="POST"
                                        onsubmit="return confirm('Delete user {{ $managedUser->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-50 hover:bg-red-100 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-lg whitespace-nowrap transition">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-10 text-center text-neutral-500">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
@endsection
