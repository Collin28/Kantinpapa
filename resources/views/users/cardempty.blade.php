<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KantinPapa - Shopping Cart</title>

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>

  <div class="w-full min-h-screen bg-neutral-100">


    <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-neutral-200">
      <div class="flex items-center gap-2">
        <span class="w-3 h-3 bg-red-600 inline-block"></span>
        <span class="font-semibold text-lg">
          <span class="text-neutral-900">Kantin</span><span class="text-red-600">Papa</span>
        </span>
      </div>

      <nav>
        <a href="#" class="text-red-600 font-medium text-sm">Menu</a>
      </nav>

      <div class="flex items-center gap-5">
        <div class="relative flex">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-neutral-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.98-4.804 2.545-7.454A1.125 1.125 0 0019.905 4.5H5.106M7.5 14.25L5.106 4.5M7.5 14.25L5.25 20.25M17.25 20.25a.75.75 0 100-1.5.75.75 0 000 1.5zm-9 0a.75.75 0 100-1.5.75.75 0 000 1.5z"/>
          </svg>
        </div>
        <button class="bg-red-600 hover:bg-red-600/90 transition-colors text-white text-sm font-medium px-5 py-2 rounded-md">
          Login
        </button>
      </div>
    </header>


    <main class="flex flex-col items-center justify-center px-4 py-24 text-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-neutral-300 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.98-4.804 2.545-7.454A1.125 1.125 0 0019.905 4.5H5.106M7.5 14.25L5.106 4.5M7.5 14.25L5.25 20.25M17.25 20.25a.75.75 0 100-1.5.75.75 0 000 1.5zm-9 0a.75.75 0 100-1.5.75.75 0 000 1.5z"/>
      </svg>

      <h1 class="font-semibold text-neutral-900 text-base mb-1">Your Cart Is Empty</h1>
      <p class="text-sm text-neutral-500 mb-6">Add some items from the menu to get started</p>

      <button class="bg-red-600 hover:bg-red-600/90 transition-colors text-white text-sm font-medium px-6 py-2.5 rounded-md">
        Browse Menu
      </button>
    </main>

  </div>

</body>
</html>