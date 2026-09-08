<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account - KantinPapa</title>
    <!-- Include Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Font Awesome for Eye Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-white min-h-screen flex flex-col justify-center items-center p-4">

    <!-- Logo Section -->
    <div class="flex items-center justify-center gap-2 mb-8">
        <div class="w-8 h-8 bg-red-600 rounded-lg"></div>
        <span class="text-2xl font-bold tracking-tight text-black">
            Kantin<span class="text-red-600">Papa</span>
        </span>
    </div>

    <!-- Main Card Container -->
    <div class="w-full max-w-[480px] bg-white rounded-2xl border border-gray-300 p-8 shadow-sm">
        
        <!-- Header Text -->
        <h1 class="text-2xl font-bold text-gray-900 mb-1">Create account</h1>
        <p class="text-gray-500 text-sm font-medium mb-6">
            Join KantinPapa to start ordering food on campus.
        </p>

        <!-- Form -->
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-gray-600 text-sm font-semibold mb-1.5">
                    Full Name
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    placeholder="Budi Santoso"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                    required
                >
                @error('name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-600 text-sm font-semibold mb-1.5">
                    Email
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="you@campus.ac.id"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                    required
                >
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-600 text-sm font-semibold mb-1.5">
                    Password
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Min. 6 characters"
                        class="w-full px-4 py-2.5 pr-10 rounded-lg border border-gray-300 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                        required
                    >
                    <button 
                        type="button" 
                        onclick="togglePasswordVisibility('password', 'eye-icon')" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                    >
                        <i id="eye-icon" class="fa-regular fa-eye-slash text-lg"></i>
                    </button>
                </div>
                @error('password')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-gray-600 text-sm font-semibold mb-1.5">
                    Confirm Password
                </label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Re-enter password"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                    required
                >
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-sm text-sm"
                >
                    Create account
                </button>
            </div>
        </form>
    </div>

    <!-- Footer / Already have account -->
    <p class="mt-6 text-center text-sm font-medium text-gray-500">
        Already have account? 
        <a href="{{ route('login') }}" class="text-red-600 font-semibold hover:underline">
            Sign in
        </a>
    </p>

    <!-- JavaScript to toggle Password Visibility -->
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>
</html>