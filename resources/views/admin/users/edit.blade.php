@extends('layouts.admin')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="text-sm text-neutral-500 hover:text-neutral-800">← Back to User Management</a>
            <h1 class="font-bold text-neutral-950 text-3xl mt-2">Edit User</h1>
        </div>

        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm font-medium px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.users.update', $managedUser) }}" method="POST"
            class="border border-neutral-200 rounded-xl p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-neutral-800 mb-1.5">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $managedUser->name) }}" required
                    class="w-full border border-neutral-300 rounded-lg px-3.5 py-2.5 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-neutral-800 mb-1.5">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $managedUser->email) }}" required
                    class="w-full border border-neutral-300 rounded-lg px-3.5 py-2.5 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="role" class="block text-sm font-medium text-neutral-800 mb-1.5">Role</label>
                    <select id="role" name="role" required
                        class="w-full border border-neutral-300 rounded-lg px-3.5 py-2.5 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-red-500">
                        @foreach ($roles as $role)
                            <option value="{{ $role->value }}" @selected(old('role', $managedUser->role->value) === $role->value)>
                                {{ ucfirst($role->value) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-neutral-800 mb-1.5">Status</label>
                    <select id="status" name="status" required
                        class="w-full border border-neutral-300 rounded-lg px-3.5 py-2.5 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="active" @selected(old('status', $managedUser->status) === 'active')>Active</option>
                        <option value="suspended" @selected(old('status', $managedUser->status) === 'suspended')>Suspended</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-neutral-100">
                <div>
                    <label for="password" class="block text-sm font-medium text-neutral-800 mb-1.5">New Password (optional)</label>
                    <input type="password" id="password" name="password" placeholder="Leave blank to keep current"
                        class="w-full border border-neutral-300 rounded-lg px-3.5 py-2.5 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-red-500">
                    @error('password')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-neutral-800 mb-1.5">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full border border-neutral-300 rounded-lg px-3.5 py-2.5 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition">
                    Update User
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="border border-neutral-200 hover:bg-neutral-50 text-neutral-600 text-sm font-medium px-5 py-2.5 rounded-lg">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
