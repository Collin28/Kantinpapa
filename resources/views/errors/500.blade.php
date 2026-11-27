<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Server Error - KantinPapa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-100 min-h-screen flex items-center justify-center p-6 text-neutral-900">
    <div class="max-w-md w-full bg-white border border-neutral-200 rounded-2xl p-8 text-center shadow-xs">
        <div class="w-14 h-14 mx-auto rounded-full bg-red-50 text-red-600 font-black text-xl flex items-center justify-center mb-4">
            500
        </div>
        <h1 class="text-2xl font-bold text-neutral-950 mb-2">Something Went Wrong</h1>
        <p class="text-sm text-neutral-500 mb-6">An unexpected error occurred on our server. Please try again in a moment.</p>
        <a href="{{ route('menu.index') }}"
            class="inline-block bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-6 py-2.5 rounded-full transition">
            Back to Menu
        </a>
    </div>
</body>
</html>
