@extends('layouts.admin')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('admin.menus.index') }}" class="text-sm text-neutral-500 hover:text-neutral-800">← Back to Menu Management</a>
            <h1 class="font-bold text-neutral-950 text-3xl mt-2">Add Menu Item</h1>
        </div>

        <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data"
            class="border border-neutral-200 rounded-xl p-6 space-y-6">
            @csrf

            @include('admin.menus._form')

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition">
                    Save Menu Item
                </button>
                <a href="{{ route('admin.menus.index') }}"
                    class="border border-neutral-200 hover:bg-neutral-50 text-neutral-600 text-sm font-medium px-5 py-2.5 rounded-lg">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
