<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - LensCamp</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

@php
    $navMenu = [
        ['route'=>'home','label'=>'Beranda','active'=>false],
        ['route'=>'about','label'=>'Tentang','active'=>false],
        ['route'=>'products','label'=>'Produk','active'=>false],
        ['route'=>'contact','label'=>'Hubungi Kami','active'=>true],
    ];

    $contacts = [
        ['label'=>'Email','value'=>'admin@lenscamp.com'],
        ['label'=>'WhatsApp','value'=>'081234567890'],
        ['label'=>'Jam Operasional','value'=>'08:00 - 20:00 WIB'],
    ];

    $inputClass = 'w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#2F5249] focus:ring-[#2F5249]';
    $labelClass = 'block text-sm font-medium text-slate-700 mb-2';
@endphp

<body class="bg-[#F8FAF7] text-slate-800">

<header class="sticky top-0 z-30 border-b border-[#dfe7df] bg-white/95 backdrop-blur">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between gap-4">

        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-[#2F5249] text-white flex items-center justify-center text-lg font-extrabold shadow">
                L
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight text-[#2F5249]">LensCamp</h1>
                <p class="text-xs text-[#437057]">Sewa perlengkapan dengan cepat</p>
            </div>
        </a>

        <nav class="hidden md:flex items-center gap-6">
            @foreach($navMenu as $item)
                <a href="{{ route($item['route']) }}"
                   class="text-sm font-medium transition 
                   {{ $item['active'] ? 'text-[#2F5249] font-semibold' : 'text-slate-700 hover:text-[#2F5249]' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}"
               class="inline-flex rounded-xl bg-[#eef3ee] px-4 py-2 text-sm font-semibold text-[#2F5249] hover:bg-[#dfe7df] transition">
                Masuk
            </a>

            <a href="{{ route('daftar') }}"
               class="inline-flex rounded-xl bg-[#2F5249] px-4 py-2 text-sm font-semibold text-white hover:bg-[#437057] transition">
                Daftar
            </a>
        </div>

    </div>
</header>

<main class="max-w-screen-xl mx-auto px-4 sm:px-6 py-10 space-y-8">

    <section class="rounded-[28px] bg-gradient-to-r from-[#2F5249] to-[#437057] p-8 sm:p-10 text-white shadow-lg">
        <div class="max-w-3xl">
            <p class="text-sm font-medium text-[#DDE8DF]">Hubungi Kami</p>

            <h2 class="mt-3 text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                Kami siap membantu kebutuhan rental kamu.
            </h2>

            <p class="mt-5 text-sm sm:text-base text-[#F1F6F2] leading-7">
                Hubungi admin kami untuk pertanyaan mengenai stok barang, jadwal sewa, ataupun bantuan pemesanan.
            </p>
        </div>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
            @foreach($contacts as $item)
                <div class="rounded-2xl bg-[#F8FAF7] border border-slate-200 p-4">
                    <p class="text-sm text-slate-500">{{ $item['label'] }}</p>
                    <p class="mt-1 font-semibold text-slate-800">{{ $item['value'] }}</p>
                </div>
            @endforeach

            <a href="https://wa.me/6281234567890"
               target="_blank"
               class="inline-flex rounded-2xl bg-[#2F5249] px-5 py-3 text-sm font-semibold text-white hover:bg-[#437057] transition">
                Chat via WhatsApp
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <h3 class="text-2xl font-bold text-[#2F5249]">Kirim Pesan</h3>
            <p class="mt-2 text-sm text-slate-500">Isi form berikut jika kamu ingin menghubungi kami.</p>

            <form class="mt-6 space-y-4">

                @foreach([
                    ['label'=>'Nama','type'=>'text','placeholder'=>'Masukkan nama'],
                    ['label'=>'Email','type'=>'email','placeholder'=>'Masukkan email'],
                ] as $field)

                <div>
                    <label class="{{ $labelClass }}">{{ $field['label'] }}</label>
                    <input type="{{ $field['type'] }}"
                        placeholder="{{ $field['placeholder'] }}"
                        class="{{ $inputClass }}">
                </div>

                @endforeach

                <div>
                    <label class="{{ $labelClass }}">Pesan</label>
                    <textarea rows="5"
                        placeholder="Tulis pesan kamu"
                        class="{{ $inputClass }}"></textarea>
                </div>

                <button type="button"
                    class="rounded-2xl bg-[#2F5249] px-6 py-3 text-sm font-semibold text-white hover:bg-[#437057] transition">
                    Kirim Pesan
                </button>

            </form>
        </div>

    </section>

</main>

</body>
</html>