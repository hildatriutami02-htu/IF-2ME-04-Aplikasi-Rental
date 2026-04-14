<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - LensCamp</title>
</head>

<body class="bg-gray-50">

<!-- NAVBAR -->
<header class="fixed w-full z-20 top-0">
  <nav class="bg-white shadow">
      <div class="flex justify-between items-center mx-auto max-w-screen-xl p-4">

          <div class="flex items-center gap-2">
              <span class="text-xl font-bold text-blue-600">LensCamp</span>
          </div>

          <div class="flex items-center gap-4">
              @if(session('user'))
                  <span class="text-gray-700 text-sm">
                      {{ session('user') }}
                  </span>

                  <a href="{{ url('/logout') }}" class="text-red-600 font-semibold">
                      Logout
                  </a>
              @else
                  <a href="{{ route('daftar') }}" class="text-blue-600 font-semibold">
                      Register
                  </a>

                  <a href="{{ route('login') }}" class="text-black font-semibold">
                      Login
                  </a>
              @endif
          </div>
      </div>
  </nav>

  <nav class="bg-gray-100 border-t">
      <div class="max-w-screen-xl px-4 py-3 mx-auto">
          <ul class="flex gap-8 text-sm font-medium">

              <li>
                  <a href="{{ route('home') }}" class="hover:text-blue-600">
                      Home
                  </a>
              </li>

              <li>
                  <a href="{{ route('about') }}" class="hover:text-blue-600">
                      About
                  </a>
              </li>

              <li>
                  <a href="{{ route('products') }}" class="text-blue-600 font-semibold">
                      Product
                  </a>
              </li>

              <li>
                  <a href="{{ route('contact') }}" class="hover:text-blue-600">
                      Contact Us
                  </a>
              </li>

          </ul>
      </div>
  </nav>
</header>

<div class="h-28"></div>

<section class="max-w-7xl mx-auto py-10 px-4">
  <h1 class="text-3xl font-bold mb-8">Produk Rental</h1>

  <div class="grid md:grid-cols-3 gap-6">

    <div class="bg-white rounded shadow">
      <img src="https://via.placeholder.com/300" class="rounded-t w-full" alt="Canon EOS 80D">

      <div class="p-4">
        <h3 class="font-semibold">Canon EOS 80D</h3>
        <p class="text-gray-600">Rp 150.000 / hari</p>

        <a href="{{ route('products.detail') }}"
           class="block mt-3 text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
           Lihat Detail
        </a>
      </div>
    </div>

    <div class="bg-white rounded shadow">
      <img src="https://via.placeholder.com/300" class="rounded-t w-full" alt="Tenda 4 Orang">

      <div class="p-4">
        <h3 class="font-semibold">Tenda 4 Orang</h3>
        <p class="text-gray-600">Rp 100.000 / hari</p>

        <a href="{{ route('products.detail') }}"
           class="block mt-3 text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
           Lihat Detail
        </a>
      </div>
    </div>

    <div class="bg-white rounded shadow">
      <img src="https://via.placeholder.com/300" class="rounded-t w-full" alt="Tripod Kamera">

      <div class="p-4">
        <h3 class="font-semibold">Tripod Kamera</h3>
        <p class="text-gray-600">Rp 50.000 / hari</p>

        <a href="{{ route('products.detail') }}"
           class="block mt-3 text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
           Lihat Detail
        </a>
      </div>
    </div>

  </div>
</section>

<footer class="bg-gray-200 py-6 mt-10">
  <div class="text-center text-sm text-gray-600">
    © 2026 LensCamp. All rights reserved.
  </div>
</footer>

</body>
</html>