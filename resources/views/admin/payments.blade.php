@extends('admin.dashboard-admin')

@section('title', 'Pembayaran - LensCamp')
@section('page_title', 'Pembayaran')
@section('page_desc', 'Verifikasi bukti pembayaran pelanggan')

@section('content')
<div class="max-w-7xl mx-auto space-y-4 animate-fade-up">

    @if(session('success'))
        <div class="rounded-2xl border border-[#dfe7df] bg-[#eef3ee] text-[#2F5249] px-4 py-3 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-[#dfe7df] p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total Pembayaran</p>
            <h3 class="mt-2 text-2xl font-bold text-[#2F5249]">{{ $payments->count() }}</h3>
        </div>

        <div class="bg-white rounded-2xl border border-[#dfe7df] p-5 shadow-sm">
            <p class="text-sm text-slate-500">Menunggu Verifikasi</p>
            <h3 class="mt-2 text-2xl font-bold text-amber-600">
                {{ $payments->where('status', 'Menunggu Verifikasi')->count() }}
            </h3>
        </div>

        <div class="bg-white rounded-2xl border border-[#dfe7df] p-5 shadow-sm">
            <p class="text-sm text-slate-500">Sudah Lunas</p>
            <h3 class="mt-2 text-2xl font-bold text-[#2F5249]">
                {{ $payments->where('status', 'Lunas')->count() }}
            </h3>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-[#dfe7df] shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-[#dfe7df]">
            <h3 class="text-xl font-bold text-[#2F5249]">Daftar Pembayaran</h3>
            <p class="text-sm text-slate-500">Cek bukti bayar lalu verifikasi pembayaran pelanggan.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#F8FAF7] text-[#2F5249] uppercase text-xs">
                    <tr>
                        <th class="px-5 py-3">Kode</th>
                        <th class="px-5 py-3">Pelanggan</th>
                        <th class="px-5 py-3">Nominal</th>
                        <th class="px-5 py-3">Metode</th>
                        <th class="px-5 py-3">Bukti</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#dfe7df]">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-[#F8FAF7] transition">
                            <td class="px-5 py-4 font-semibold text-slate-800">
                                {{ $payment->kode_transaksi }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $payment->nama_pelanggan }}
                            </td>

                            <td class="px-5 py-4 font-semibold text-[#2F5249]">
                                Rp {{ number_format($payment->nominal, 0, ',', '.') }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $payment->metode ?? 'QRIS Dana' }}
                            </td>

                            <td class="px-5 py-4">
                                @if($payment->bukti_bayar)
                                   <div x-data="{ open: false }" class="inline-block">
    <button
        type="button"
        @click="open = true"
        class="inline-flex rounded-xl bg-[#eef3ee] px-3 py-2 text-xs font-semibold text-[#2F5249] hover:bg-[#dfe7df]"
    >
        Lihat Bukti
    </button>

    <div
    x-show="open"
    class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
>
        <div
            @click="open = false"
            class="absolute inset-0"
        ></div>

        <div
            @click.stop
            class="relative w-full max-w-lg overflow-hidden rounded-3xl bg-white shadow-2xl"
        >
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <div>
                    <h3 class="text-lg font-bold text-[#2F5249]">Bukti Pembayaran</h3>
                    <p class="text-xs text-slate-500">{{ $payment->kode_transaksi }}</p>
                </div>

                <button
                    type="button"
                    @click="open = false"
                    class="rounded-full bg-slate-100 px-3 py-1 text-sm font-bold text-slate-600 hover:bg-slate-200"
                >
                     ×
                </button>
            </div>

            <div class="bg-[#F8FAF7] p-5">
                <img
                    src="{{ asset('storage/' . $payment->bukti_bayar) }}"
                    alt="Bukti Pembayaran"
                    class="mx-auto max-h-[65vh] w-auto max-w-full rounded-2xl object-contain shadow-sm"
                        >
                    </div>
                </div>
            </div>
        </div>
                                @else
                                    <span class="text-slate-400">Belum upload</span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                @if($payment->status === 'Lunas')
                                    <span class="rounded-full bg-[#eef3ee] px-3 py-1 text-xs font-bold text-[#2F5249]">
                                        Lunas
                                    </span>
                                @elseif($payment->status === 'Ditolak')
                                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700">
                                        Menunggu Verifikasi
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                            @if($payment->status === 'Menunggu Verifikasi' && $payment->bukti_bayar)
    <form action="{{ route('admin.payments.reject', $payment->id) }}"
          method="POST"
          onsubmit="return confirm('Tolak bukti pembayaran ini?')">
        @csrf

        <button type="submit"
                class="rounded-xl bg-red-600 px-3 py-2 text-xs font-bold text-white hover:bg-red-700">
            Tolak
        </button>
    </form>
                                </div>
                            @elseif($payment->status === 'Ditolak')
                                <span class="text-xs font-semibold text-red-600">
                                    Menunggu upload ulang
                                </span>
                            @elseif($payment->status === 'Lunas')
                                <span class="rounded-xl bg-[#eef3ee] px-3 py-2 text-xs font-bold text-[#2F5249]">
                                    Selesai
                                </span>
                            @else
                                <span class="text-xs text-slate-400">
                                    Tunggu bukti
                                </span>
                            @endif
                        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-slate-500">
                                Belum ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection