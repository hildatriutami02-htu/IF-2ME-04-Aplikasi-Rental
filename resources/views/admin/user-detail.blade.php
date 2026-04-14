<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User - LensCamp</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

@php
    $namaLengkap = $user['nama_lengkap'] ?? $user['nama'] ?? '-';
    $kodeUser = $user['kode_user'] ?? '-';
    $noKtp = $user['no_ktp'] ?? '-';
    $noTelp = $user['no_telp'] ?? '-';
    $noWa = $user['no_wa'] ?? '-';
    $tempatLahir = $user['tempat_lahir'] ?? '-';
    $tanggalLahir = $user['tanggal_lahir'] ?? '-';
    $jenisKelamin = $user['jenis_kelamin'] ?? '-';
    $alamat = $user['alamat'] ?? '-';
    $fotoKtp = $user['foto_ktp'] ?? null;

    $rentals = $user['rentals'] ?? [];
@endphp

<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Detail User</h1>
            <p class="text-sm text-slate-500 mt-1">Profil pengguna dan riwayat sewa LensCamp</p>
        </div>
        <a href="{{ route('admin.users') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-medium">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- PROFILE CARD -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex flex-col items-center text-center">
                @if($fotoKtp)
                    <img src="{{ asset('storage/' . $fotoKtp) }}"
                         alt="Foto User"
                         class="w-32 h-32 rounded-full object-cover border-4 border-orange-400 shadow">
                @else
                    <div class="w-32 h-32 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 text-sm font-semibold border-4 border-slate-300">
                        No Image
                    </div>
                @endif

                <h2 class="mt-4 text-2xl font-bold text-slate-800">{{ $namaLengkap }}</h2>
                <p class="text-sm text-slate-500">{{ $kodeUser }}</p>

                <span class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                    Pengguna LensCamp
                </span>
            </div>

            <div class="mt-6 border-t pt-6 space-y-4">
                <div>
                    <p class="text-xs text-slate-500">No KTP</p>
                    <p class="font-semibold text-slate-800">{{ $noKtp }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">No Telepon</p>
                    <p class="font-semibold text-slate-800">{{ $noTelp }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">No WhatsApp</p>
                    <p class="font-semibold text-slate-800">{{ $noWa }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Tempat Lahir</p>
                    <p class="font-semibold text-slate-800">{{ $tempatLahir }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Tanggal Lahir</p>
                    <p class="font-semibold text-slate-800">{{ $tanggalLahir }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Jenis Kelamin</p>
                    <p class="font-semibold text-slate-800">{{ $jenisKelamin }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Alamat</p>
                    <p class="font-semibold text-slate-800 leading-relaxed">{{ $alamat }}</p>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="xl:col-span-2 bg-white rounded-2xl shadow overflow-hidden">
            <!-- TAB HEADER -->
            <div class="border-b border-slate-200 px-4 md:px-6">
                <div class="flex flex-wrap gap-2">
                    <button onclick="showTab('aktivitas')"
                        id="tab-aktivitas"
                        class="tab-btn px-4 py-4 text-sm font-semibold border-b-2 border-blue-600 text-blue-600">
                        Aktivitas
                    </button>

                    <button onclick="showTab('riwayat')"
                        id="tab-riwayat"
                        class="tab-btn px-4 py-4 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700">
                        Riwayat Sewa
                    </button>

                    <button onclick="showTab('pengaturan')"
                        id="tab-pengaturan"
                        class="tab-btn px-4 py-4 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700">
                        Pengaturan
                    </button>
                </div>
            </div>

            <!-- TAB CONTENT -->
            <div class="p-4 md:p-6">

                <!-- AKTIVITAS -->
                <div id="content-aktivitas" class="tab-content">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Aktivitas User</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="rounded-xl bg-slate-100 p-5">
                            <p class="text-sm text-slate-500">Total Transaksi</p>
                            <h4 class="text-2xl font-bold text-slate-800 mt-2">{{ count($rentals) }}</h4>
                        </div>

                        <div class="rounded-xl bg-slate-100 p-5">
                            <p class="text-sm text-slate-500">Sudah Bayar</p>
                            <h4 class="text-2xl font-bold text-slate-800 mt-2">
                                {{ collect($rentals)->where('status_pembayaran', 'Sudah Bayar')->count() }}
                            </h4>
                        </div>

                        <div class="rounded-xl bg-slate-100 p-5">
                            <p class="text-sm text-slate-500">Sudah Dikembalikan</p>
                            <h4 class="text-2xl font-bold text-slate-800 mt-2">
                                {{ collect($rentals)->where('status_transaksi', 'Sudah Dikembalikan')->count() }}
                            </h4>
                        </div>
                    </div>

                    <div class="mt-6 rounded-xl bg-blue-50 border border-blue-100 p-4">
                        <p class="text-sm text-blue-700">
                            Halaman ini menampilkan ringkasan aktivitas user, termasuk jumlah transaksi, status pembayaran, dan status pengembalian.
                        </p>
                    </div>
                </div>

                <!-- RIWAYAT SEWA -->
                <div id="content-riwayat" class="tab-content hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-slate-800">Riwayat Sewa</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[760px] text-sm text-left text-slate-600">
                            <thead class="text-xs uppercase bg-slate-50 text-slate-700 border-b">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Produk</th>
                                    <th class="px-4 py-3">Tanggal Sewa</th>
                                    <th class="px-4 py-3">Tanggal Kembali</th>
                                    <th class="px-4 py-3">Status Bayar</th>
                                    <th class="px-4 py-3">Status Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rentals as $index => $rental)
                                    <tr class="border-b bg-white hover:bg-slate-50">
                                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-medium text-slate-800">{{ $rental['produk'] ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $rental['tanggal_sewa'] ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $rental['tanggal_kembali'] ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            @php $statusBayar = $rental['status_pembayaran'] ?? '-'; @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                                {{ $statusBayar === 'Sudah Bayar' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $statusBayar }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @php $statusTransaksi = $rental['status_transaksi'] ?? '-'; @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                                {{ $statusTransaksi === 'Sudah Dikembalikan' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ $statusTransaksi }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-slate-500">
                                            Belum ada riwayat sewa untuk user ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PENGATURAN -->
                <div id="content-pengaturan" class="tab-content hidden">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Pengaturan User</h3>

                    <div class="space-y-4">
                        <div class="rounded-xl border border-slate-200 p-4">
                            <p class="font-semibold text-slate-800">Status Akun</p>
                            <p class="text-sm text-slate-500 mt-1">Pengaturan status akun user bisa ditaruh di bagian ini.</p>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-4">
                            <p class="font-semibold text-slate-800">Edit Data User</p>
                            <p class="text-sm text-slate-500 mt-1">Arahkan tombol edit ke halaman update user bila diperlukan.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    function showTab(tabName) {
        const tabs = ['aktivitas', 'riwayat', 'pengaturan'];

        tabs.forEach(tab => {
            document.getElementById('content-' + tab).classList.add('hidden');

            const btn = document.getElementById('tab-' + tab);
            btn.classList.remove('border-blue-600', 'text-blue-600');
            btn.classList.add('border-transparent', 'text-slate-500');
        });

        document.getElementById('content-' + tabName).classList.remove('hidden');

        const activeBtn = document.getElementById('tab-' + tabName);
        activeBtn.classList.remove('border-transparent', 'text-slate-500');
        activeBtn.classList.add('border-blue-600', 'text-blue-600');
    }
</script>

</body>
</html>