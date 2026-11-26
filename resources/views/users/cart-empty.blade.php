@extends('layouts.app')

@section('content')
    <div class="w-full min-h-[70vh] bg-neutral-100">
        <main class="flex flex-col items-center justify-center px-4 py-24 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-neutral-300 mb-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.98-4.804 2.545-7.454A1.125 1.125 0 0019.905 4.5H5.106M7.5 14.25L5.106 4.5M7.5 14.25L5.25 20.25M17.25 20.25a.75.75 0 100-1.5.75.75 0 000 1.5zm-9 0a.75.75 0 100-1.5.75.75 0 000 1.5z" />
            </svg>

            <h1 class="font-semibold text-neutral-900 text-base mb-1">Your Cart Is Empty</h1>
            <p class="text-sm text-neutral-500 mb-6">Add some items from the menu to get started</p>

            <a href="{{ route('menu.index') }}"
               class="bg-red-600 hover:bg-red-700 transition-colors text-white text-sm font-medium px-6 py-2.5 rounded-md">
                Browse Menu
            </a>
        </main>
    </div>
@endsection
