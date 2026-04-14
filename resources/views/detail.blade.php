<!DOCTYPE html>
<html lang="id">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - LensCamp</title>
</head>
<body class="bg-gray-50">

<header class="fixed w-full z-20 top-0 start-0">
    <nav class="bg-neutral-primary">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-7" alt="LensCamp Logo" />
                <span class="self-center text-xl text-heading font-semibold whitespace-nowrap">LensCamp</span>
            </a>

            <div class="flex items-center space-x-6 rtl:space-x-reverse">
                @if(session('user'))
                    <span class="text-sm text-body">{{ session('user') }}</span>
                    <a href="{{ route('logout') }}" class="text-sm font-medium text-fg-brand hover:underline">Logout</a>
                @else
                    <a href="{{ route('daftar') }}" class="text-sm text-body hover:underline">Register</a>
                    <a href="{{ route('login') }}" class="text-sm font-medium text-fg-brand hover:underline">Login</a>
                @endif
            </div>
        </div>
    </nav>

    <nav class="bg-neutral-secondary-soft border-y border-default">
        <div class="max-w-screen-xl px-4 py-3 mx-auto">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li><a href="{{ route('home') }}" class="text-heading hover:underline">Home</a></li>
                <li><a href="{{ route('about') }}" class="text-heading hover:underline">About</a></li>
                <li><a href="{{ route('products') }}" class="text-heading font-semibold underline">Product</a></li>
                <li><a href="{{ route('contact') }}" class="text-heading hover:underline">Contact Us</a></li>
            </ul>
        </div>
    </nav>
</header>

<div class="h-28"></div>

<div class="max-w-6xl mx-auto p-6">
    <div class="bg-white rounded-2xl shadow-lg p-6 grid md:grid-cols-2 gap-8">

        <div>
            <img src="https://via.placeholder.com/600x400?text=Canon+EOS+1500D" class="w-full h-96 object-cover rounded-lg" alt="Canon EOS 1500D">
        </div>

        <div>
            <h1 class="text-3xl font-bold mb-3 text-heading">
                Canon EOS 1500D
            </h1>

            <p class="text-body mb-4">
                Sewa kamera DSLR dengan kualitas terbaik untuk kebutuhan fotografi, event, dan dokumentasi perjalanan.
            </p>

            <p class="text-2xl font-semibold text-fg-brand mb-4">
                Rp 100.000 / hari
            </p>

            <span class="bg-brand-softer text-fg-brand-strong text-sm font-medium px-3 py-1 rounded">
                Tersedia
            </span>

            <div class="mt-4">
                <label class="block mb-2 font-semibold text-heading">Tanggal Mulai:</label>
                <input type="date" class="w-full border border-default rounded-lg p-2 mb-3">

                <label class="block mb-2 font-semibold text-heading">Tanggal Selesai:</label>
                <input type="date" class="w-full border border-default rounded-lg p-2">
            </div>

            <div class="flex items-center gap-3 mt-4 mb-6">
                <button onclick="kurang()" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300" type="button">-</button>
                <span id="qty" class="font-semibold">1</span>
                <button onclick="tambah()" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300" type="button">+</button>
            </div>

            <div class="flex gap-4">
                <button class="bg-brand text-white px-6 py-3 rounded-lg hover:bg-brand-strong transition">
                    Sewa Sekarang
                </button>

                <button class="border border-brand text-fg-brand px-6 py-3 rounded-lg hover:bg-brand-softer transition">
                    + Keranjang
                </button>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-heading mb-4">Deskripsi</h2>
        <p class="text-body mb-4">
            Kamera ini cocok untuk kebutuhan pemula hingga profesional dengan hasil gambar yang tajam dan warna yang natural.
        </p>

        <h2 class="text-xl font-bold text-heading mb-4">Syarat</h2>
        <p class="text-body">
            - Wajib KTP<br>
            - Denda keterlambatan berlaku<br>
            - Barang harus dikembalikan dalam kondisi baik
        </p>
    </div>

    <div class="mt-6">
        <a href="{{ route('products') }}" class="text-fg-brand hover:underline">
            ← Kembali ke halaman products
        </a>
    </div>
</div>

<footer class="bg-neutral-primary-soft rounded-base shadow-xs border border-default m-4">
    <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
        <span class="text-sm text-body sm:text-center">
            © 2026 <a href="{{ route('home') }}" class="hover:underline">LensCamp™</a>. All Rights Reserved.
        </span>
    </div>
</footer>

<script>
let qty = 1;
function tambah() {
    qty++;
    document.getElementById("qty").innerText = qty;
}
function kurang() {
    if (qty > 1) {
        qty--;
        document.getElementById("qty").innerText = qty;
    }
}
</script>

</body>
</html>