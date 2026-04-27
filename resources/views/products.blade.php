<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - LensCamp</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

@php
    $navMenu = [
        ['route'=>'home','label'=>'Beranda'],
        ['route'=>'about','label'=>'Tentang'],
        ['route'=>'products','label'=>'Produk','active'=>true],
        ['route'=>'contact','label'=>'Hubungi Kami'],
    ];

    $inputClass = 'rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500 w-full';

    $filters = [
        ['type'=>'input','placeholder'=>'Cari produk...'],
        ['type'=>'select','options'=>['Semua Kategori','Tas','Tenda','Aksesoris']],
        ['type'=>'select','options'=>['Urutkan','Harga Termurah','Harga Termahal','Stok Terbanyak']],
    ];

    $produk = [
        [
            'nama' => 'Tas Slempang',
            'kategori' => 'Tas',
            'deskripsi' => 'Tas untuk perlengkapan outdoor.',
            'harga' => 12000,
            'stok' => 10,
        ],
        [
            'nama' => 'Tenda 4 Orang',
            'kategori' => 'Tenda',
            'deskripsi' => 'Tenda camping untuk kebutuhan outdoor.',
            'harga' => 100000,
            'stok' => 8,
        ],
        [
            'nama' => 'Tripod Kamera',
            'kategori' => 'Aksesoris',
            'deskripsi' => 'Tripod stabil untuk hasil foto dan video.',
            'harga' => 55000,
            'stok' => 15,
        ],
    ];
@endphp

<body class="bg-slate-50 text-slate-800">

<!-- HEADER -->
<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between gap-4">

        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-lg font-extrabold shadow">L</div>
            <div>
                <h1 class="text-xl font-bold">LensCamp</h1>
                <p class="text-xs text-slate-500">Sewa perlengkapan dengan cepat</p>
            </div>
        </a>

        <nav class="hidden md:flex items-center gap-6">
            @foreach($navMenu as $menu)
                <a href="{{ route($menu['route']) }}"
                   class="text-sm font-medium {{ isset($menu['active']) ? 'text-blue-600 font-semibold' : 'text-slate-700 hover:text-blue-600' }}">
                    {{ $menu['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="bg-slate-100 px-4 py-2 rounded-xl text-sm font-semibold">Masuk</a>
            <a href="{{ route('daftar') }}" class="bg-blue-600 px-4 py-2 rounded-xl text-sm font-semibold text-white">Daftar</a>
        </div>

    </div>
</header>

<!-- CONTENT -->
<main class="max-w-screen-xl mx-auto px-4 sm:px-6 py-10 space-y-8">

    <!-- HERO -->
    <section class="rounded-[28px] bg-gradient-to-r from-blue-600 to-blue-500 p-8 text-white shadow-lg">
        <h2 class="text-3xl sm:text-5xl font-extrabold">
            Pilih perlengkapan terbaik sesuai kebutuhanmu.
        </h2>
        <p class="mt-4 text-blue-50">
            Jelajahi produk rental yang tersedia.
        </p>
    </section>

    <!-- FILTER -->
    <section class="bg-white rounded-3xl border p-6 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            @foreach($filters as $filter)

                @if($filter['type'] == 'input')
                    <input type="text" placeholder="{{ $filter['placeholder'] }}" class="{{ $inputClass }}">
                @else
                    <select class="{{ $inputClass }}">
                        @foreach($filter['options'] as $opt)
                            <option>{{ $opt }}</option>
                        @endforeach
                    </select>
                @endif

            @endforeach

        </div>
    </section>

    <!-- PRODUK -->
    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        @foreach($produk as $item)
            <div class="bg-white rounded-3xl border p-5 shadow-sm hover:shadow-md transition">

                <div class="h-44 bg-slate-100 rounded-2xl flex items-center justify-center text-4xl font-bold text-slate-400">
                    {{ strtoupper(substr($item['nama'],0,1)) }}
                </div>

                <div class="mt-4">
                    <h4 class="text-lg font-bold">{{ $item['nama'] }}</h4>
                    <p class="text-sm text-slate-500">{{ $item['kategori'] }}</p>

                    <p class="mt-3 text-sm text-slate-500">
                        {{ $item['deskripsi'] }}
                    </p>

                    <p class="mt-4 font-bold text-blue-600">
                        Rp {{ number_format($item['harga'],0,',','.') }}
                    </p>

                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white py-3 rounded-xl text-center text-sm">
                            Sewa
                        </a>
                        <a href="{{ route('contact') }}" class="bg-slate-100 py-3 rounded-xl text-center text-sm">
                            Tanya
                        </a>
                    </div>
                </div>

            </div>
        @endforeach

    </section>

</main>
</body>
</html>