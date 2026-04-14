<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - LensCamp</title>
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
                  <a href="{{ route('products') }}" class="hover:text-blue-600">
                      Product
                  </a>
              </li>

              <li>
                  <a href="{{ route('contact') }}" class="text-blue-600 font-semibold">
                      Contact Us
                  </a>
              </li>

          </ul>
      </div>
  </nav>
</header>

<div class="h-28"></div>

<section class="max-w-6xl mx-auto py-12 px-4">
  <div class="bg-white rounded-xl shadow p-8 grid md:grid-cols-2 gap-8">
      <div>
          <h1 class="text-3xl font-bold mb-4">Contact Us</h1>
          <p class="text-gray-600 mb-6">
              Jika ada pertanyaan atau ingin bekerja sama, silakan hubungi kami melalui kontak berikut.
          </p>

          <div class="space-y-3 text-gray-700">
              <p><strong>Alamat:</strong> Batam, Indonesia</p>
              <p><strong>Telepon:</strong> +62 83809158590</p>
              <p><strong>Email:</strong> putriaudry@gmail.com</p>
          </div>
      </div>

      <div>
          <form class="space-y-4">
              <input type="text" placeholder="Nama kamu" class="w-full border rounded p-3">
              <input type="email" placeholder="Email kamu" class="w-full border rounded p-3">
              <textarea rows="5" placeholder="Tulis pesan..." class="w-full border rounded p-3"></textarea>
              <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded hover:bg-blue-700">
                  Send Message
              </button>
          </form>
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