<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LensCamp</title>
</head>

<body class="bg-gray-50">

<!-- NAVBAR -->
<header class="fixed w-full z-20 top-0">
  <nav class="bg-white shadow">
      <div class="flex justify-between items-center mx-auto max-w-screen-xl p-4">

          <div class="flex items-center gap-2">
              <span class="text-xl font-bold text-blue-600">LensCamp</span>
          </div>

          <!-- 🔥 LOGIN / LOGOUT -->
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

  <!-- MENU -->
  <nav class="bg-gray-100 border-t">
      <div class="max-w-screen-xl px-4 py-3 mx-auto">
          <ul class="flex gap-8 text-sm font-medium">

              <li>
                  <a href="{{ route('home') }}" class="hover:text-blue-600">
                      Home
                  </a>
              </li>

              <li>
                  <a href="{{ url('/about') }}" class="hover:text-blue-600">
                      About
                  </a>
              </li>

              <li>
                  <a href="{{ route('products') }}" class="hover:text-blue-600">
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

<!-- SPACER -->
<div class="h-28"></div>

<!-- HERO -->
<section class="text-center py-16 px-4">
    <h1 class="text-4xl font-bold mb-4">
        Abadikan Momen, Jelajahi Alam Tanpa Batas
    </h1>

    <p class="text-gray-600 mb-6">
        Selamat Datang di Sewa Kamera & Alat Camping dengan Mudah, Cepat, dan Terpercaya
    </p>

    <input type="text" placeholder="Search..."
        class="border px-4 py-2 rounded w-80 shadow">
</section>

<!-- KATEGORI -->
<section class="max-w-7xl mx-auto py-10 px-4">
  <h2 class="text-2xl font-bold mb-6">Kategori</h2>

  <div class="grid md:grid-cols-2 gap-6">

    <div class="bg-white p-6 rounded shadow">
      <h3 class="font-semibold text-lg">Kamera</h3>
      <p class="text-gray-600">Sewa berbagai kamera DSLR & mirrorless</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
      <h3 class="font-semibold text-lg">Camping</h3>
      <p class="text-gray-600">Sewa perlengkapan outdoor lengkap</p>
    </div>

  </div>
</section>

<!-- PRODUK -->
<section class="max-w-7xl mx-auto py-10 px-4">
  <h2 class="text-2xl font-bold mb-6">Produk Populer</h2>

  <div class="grid md:grid-cols-3 gap-6">

    <!-- ITEM -->
    <div class="bg-white rounded shadow">
      <img src="https://via.placeholder.com/300" class="rounded-t">

      <div class="p-4">
        <h3 class="font-semibold">Canon EOS 80D</h3>
        <p class="text-gray-600">Rp 150.000 / hari</p>

        <a href="{{ route('products') }}"
           class="block mt-3 text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
           Lihat Detail
        </a>
      </div>
    </div>

    <div class="bg-white rounded shadow">
      <img src="https://via.placeholder.com/300" class="rounded-t">

      <div class="p-4">
        <h3 class="font-semibold">Tenda 4 Orang</h3>
        <p class="text-gray-600">Rp 100.000 / hari</p>

        <a href="{{ route('products') }}"
           class="block mt-3 text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
           Lihat Detail
        </a>
      </div>
    </div>

    <div class="bg-white rounded shadow">
      <img src="https://via.placeholder.com/300" class="rounded-t">

      <div class="p-4">
        <h3 class="font-semibold">Tripod Kamera</h3>
        <p class="text-gray-600">Rp 50.000 / hari</p>

        <a href="{{ route('products') }}"
           class="block mt-3 text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
           Lihat Detail
        </a>
      </div>
    </div>

  </div>
</section>

<!-- FOOTER -->
<footer class="bg-gray-200 py-6 mt-10">
  <div class="text-center text-sm text-gray-600">
    © 2026 LensCamp. All rights reserved.
  </div>
</footer>

</body>
</html>