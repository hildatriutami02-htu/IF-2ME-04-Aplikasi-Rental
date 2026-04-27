@extends('admin.dashboard-admin')

@section('title', 'Detail User - LensCamp')
@section('page_title', 'Detail User')
@section('page_desc', 'Profil pengguna dan riwayat sewa LensCamp')

@section('content')
@php
    $namaLengkap = $user->nama_lengkap ?? '-';
    $kodeUser = $user->kode_user ?? '-';
    $noKtp = $user->no_ktp ?? '-';
    $noTelp = $user->no_telp ?? '-';
    $noWa = $user->no_wa ?? '-';
    $tempatLahir = $user->tempat_lahir ?? '-';
    $tanggalLahir = $user->tanggal_lahir ?? '-';
    $jenisKelamin = $user->jenis_kelamin ?? '-';
    $alamat = $user->alamat ?? '-';
    $fotoKtp = $user->foto_ktp ?? null;
    $rentals = $user->rentals ?? collect();
@endphp

<div class="max-w-7xl mx-auto py-8 px-4 animate-fade-up">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Detail User</h1>
            <p class="text-sm text-slate-500 mt-1">Profil pengguna dan riwayat sewa LensCamp</p>
        </div>
        <a href="{{ route('admin.users.index') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-medium transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 transition-all duration-300 hover:shadow-md">
            <div class="flex flex-col items-center text-center">
                @if($fotoKtp)
                    <img src="{{ asset('storage/' . $fotoKtp) }}"
                         class="w-32 h-32 rounded-full object-cover border-4 border-blue-400 shadow">
                @else
                    <div class="w-32 h-32 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 text-sm font-semibold border-4 border-slate-300">
                        No Image
                    </div>
                @endif

                <h2 class="mt-4 text-2xl font-bold text-slate-800">{{ $namaLengkap }}</h2>
                <p class="text-sm text-slate-500">{{ $kodeUser }}</p>

                <span class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                    Pengguna LensCamp
                </span>
            </div>

            <div class="mt-6 border-t pt-6 space-y-4">
                <div><p class="text-xs text-slate-500">No KTP</p><p class="font-semibold">{{ $noKtp }}</p></div>
                <div><p class="text-xs text-slate-500">No Telepon</p><p class="font-semibold">{{ $noTelp }}</p></div>
                <div><p class="text-xs text-slate-500">No WhatsApp</p><p class="font-semibold">{{ $noWa }}</p></div>
                <div><p class="text-xs text-slate-500">Tempat Lahir</p><p class="font-semibold">{{ $tempatLahir }}</p></div>
                <div><p class="text-xs text-slate-500">Tanggal Lahir</p><p class="font-semibold">{{ $tanggalLahir }}</p></div>
                <div><p class="text-xs text-slate-500">Jenis Kelamin</p><p class="font-semibold">{{ $jenisKelamin }}</p></div>
                <div><p class="text-xs text-slate-500">Alamat</p><p class="font-semibold leading-relaxed">{{ $alamat }}</p></div>
            </div>
        </div>

        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">

            <div class="border-b border-slate-200 px-4 md:px-6">
                <div class="flex flex-wrap gap-2">
                    <button onclick="showTab('aktivitas')" id="tab-aktivitas"
                        class="tab-btn px-4 py-4 text-sm font-semibold border-b-2 border-blue-600 text-blue-600">
                        Aktivitas
                    </button>

                    <button onclick="showTab('riwayat')" id="tab-riwayat"
                        class="tab-btn px-4 py-4 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700">
                        Riwayat Sewa
                    </button>

                    <button onclick="showTab('pengaturan')" id="tab-pengaturan"
                        class="tab-btn px-4 py-4 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700">
                        Pengaturan
                    </button>
                </div>
            </div>

            <div class="p-4 md:p-6">

                <div id="content-aktivitas" class="tab-content">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Aktivitas User</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="rounded-xl bg-slate-50 border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">Total Transaksi</p>
                            <h4 class="text-2xl font-bold mt-2">{{ $rentals->count() }}</h4>
                        </div>

                        <div class="rounded-xl bg-slate-50 border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">Sudah Bayar</p>
                            <h4 class="text-2xl font-bold mt-2">
                                {{ $rentals->where('status_pembayaran', 'Sudah Bayar')->count() }}
                            </h4>
                        </div>

                        <div class="rounded-xl bg-slate-50 border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">Sudah Dikembalikan</p>
                            <h4 class="text-2xl font-bold mt-2">
                                {{ $rentals->where('status_transaksi', 'Sudah Dikembalikan')->count() }}
                            </h4>
                        </div>
                    </div>
                </div>

                <div id="content-riwayat" class="tab-content hidden">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Riwayat Sewa</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[760px] text-sm text-left text-slate-600">
                            <thead class="text-xs uppercase bg-slate-50 text-slate-700 border-b border-slate-200">
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
                                    <tr class="border-b border-slate-200 hover:bg-slate-50">
                                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $rental->produk ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $rental->tanggal_sewa ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $rental->tanggal_kembali ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                {{ $rental->status_pembayaran ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                                {{ $rental->status_transaksi ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-6 text-slate-500">
                                            Belum ada riwayat
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="content-pengaturan" class="tab-content hidden">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Pengaturan User</h3>

                    <div class="space-y-4">
                        <div class="rounded-xl border border-slate-200 p-4">
                            <p class="font-semibold">Status Akun</p>
                            <p class="text-sm text-slate-500">Pengaturan status akun user</p>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-4">
                            <p class="font-semibold">Edit Data User</p>
                            <p class="text-sm text-slate-500">Edit dilakukan dari halaman tabel user</p>
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
        document.getElementById('tab-' + tab).classList.remove('border-blue-600','text-blue-600');
        document.getElementById('tab-' + tab).classList.add('text-slate-500');
    });

    document.getElementById('content-' + tabName).classList.remove('hidden');
    document.getElementById('tab-' + tabName).classList.add('border-blue-600','text-blue-600');
}
</script>
@endsection