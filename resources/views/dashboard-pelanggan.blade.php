<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-5xl mx-auto py-10 px-6">
        <div class="bg-white rounded-xl shadow p-8">
            <h1 class="text-3xl font-bold text-green-700 mb-4">Dashboard Pelanggan</h1>
            <p class="text-gray-700 mb-6">
                Selamat datang, <span class="font-semibold">{{ session('user') }}</span>
            </p>

            <div class="grid md:grid-cols-3 gap-4 mb-8">
                <div class="bg-green-100 p-5 rounded-lg">Lihat Produk</div>
                <div class="bg-green-100 p-5 rounded-lg">Pesanan Saya</div>
                <div class="bg-green-100 p-5 rounded-lg">Riwayat Rental</div>
            </div>

            <a href="{{ route('logout') }}"
               class="inline-block bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-lg">
                Logout
            </a>
        </div>
    </div>

</body>
</html>