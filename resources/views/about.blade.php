<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - LensCamp</title>
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
                  <a href="{{ route('about') }}" class="text-blue-600 font-semibold">
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

<div class="h-28"></div>

<section class="bg-gray-50">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
        <div class="bg-white border border-gray-200 rounded-xl p-8 md:p-12 mb-8 shadow-sm">
            <span class="inline-flex items-center bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded">
                Tentang Kami
            </span>

            <h1 class="tracking-tight text-3xl md:text-5xl font-bold my-6 text-gray-900">
                LensCamp
            </h1>

            <p class="md:text-lg font-normal text-gray-600 mb-6 leading-8">
                Aplikasi rental kamera dan alat camping ini dirancang untuk memudahkan pengguna dalam menyewa berbagai perlengkapan fotografi dan kebutuhan outdoor secara online. Melalui aplikasi ini, pengguna dapat melihat daftar produk, mengecek ketersediaan, melakukan pemesanan, hingga mengatur jadwal penyewaan dengan mudah.
                <br><br>
                Kami menyediakan berbagai pilihan kamera seperti DSLR, mirrorless, hingga action camera, serta perlengkapan camping seperti tenda, sleeping bag, dan peralatan masak portable. Semua peralatan yang tersedia dijaga kualitas dan kondisinya agar tetap layak pakai dan aman digunakan.
                <br><br>
                Dengan sistem yang sederhana dan user-friendly, aplikasi ini membantu pengguna menghemat waktu dan biaya tanpa perlu membeli perlengkapan yang jarang digunakan. Kami juga menyediakan layanan dukungan untuk memastikan proses penyewaan berjalan lancar dan nyaman.
            </p>

            <a href="{{ route('products') }}" class="inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-base px-5 py-3">
                Getting started
                <svg class="w-4 h-4 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m14 0-4 4m4-4-4-4"/>
                </svg>
            </a>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white border border-gray-200 rounded-xl p-8 md:p-12 shadow-sm">
                <span class="inline-flex items-center bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded">
                    Design
                </span>

                <h2 class="text-gray-900 text-3xl font-semibold my-4">Peralatan Berkualitas & Terawat</h2>

                <p class="font-normal text-gray-600 mb-4 leading-8">
                    Kami hadir untuk memudahkan kamu dalam mengabadikan momen dan menjelajahi alam tanpa harus khawatir dengan perlengkapan sendiri.
                </p>

                <a href="{{ route('products') }}" class="text-blue-600 hover:underline font-medium text-lg inline-flex items-center">
                    Lihat Produk
                    <svg class="w-5 h-5 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m14 0-4 4m4-4-4-4"/>
                    </svg>
                </a>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-8 md:p-12 shadow-sm">
                <span class="inline-flex items-center bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded">
                    Code
                </span>

                <h2 class="text-gray-900 text-3xl font-semibold my-4">Proses Sewa Cepat & Mudah</h2>

                <p class="font-normal text-gray-600 mb-4 leading-8">
                    Jangan tunda lagi rencana Anda. Pilih perlengkapan yang Anda butuhkan, lakukan pemesanan dalam hitungan menit, dan mulai petualangan Anda sekarang juga!
                </p>

                <a href="{{ route('products') }}" class="text-blue-600 hover:underline font-medium text-lg inline-flex items-center">
                    Sewa Sekarang
                    <svg class="w-5 h-5 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m14 0-4 4m4-4-4-4"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<footer class="bg-gray-200 py-6 mt-10">
  <div class="max-w-screen-xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-4">
    <div class="text-sm text-gray-600">
      © 2026 LensCamp™. All Rights Reserved.
    </div>

    <ul class="flex flex-wrap items-center gap-6 text-sm font-medium text-gray-700">
      <li><a href="{{ route('about') }}" class="hover:underline">About</a></li>
      <li><a href="#" class="hover:underline">Privacy Policy</a></li>
      <li><a href="#" class="hover:underline">Licensing</a></li>
      <li><a href="{{ route('contact') }}" class="hover:underline">Contact</a></li>
    </ul>
  </div>
</footer>

</body>
</html>