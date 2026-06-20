@extends('pelanggan.layouts.app')

@php
    $title = 'Pembayaran - LensCamp';
    $headerTitle = 'Pembayaran';
    $headerDesc = 'Upload bukti pembayaran dan lihat status tagihan kamu';
@endphp

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="rounded-2xl border border-[#dfe7df] bg-[#eef3ee] px-4 py-3 text-sm text-[#2F5249]">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Tagihan</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-800">
            Rp {{ number_format($payments->where('status', 'Menunggu Verifikasi')->sum('nominal'), 0, ',', '.') }}
            </h3>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Sudah Lunas</p>
            <h3 class="mt-2 text-3xl font-bold text-[#2F5249]">
                {{ $payments->where('status', 'Lunas')->count() }}
            </h3>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Menunggu Verifikasi</p>
            <h3 class="mt-2 text-3xl font-bold text-amber-600">
                {{ $payments->where('status', 'Menunggu Verifikasi')->count() }}
            </h3>
        </div>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[950px] text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-[#F8FAF7] text-sm text-[#2F5249]">
                        <th class="px-4 py-4 font-semibold">Invoice</th>
                        <th class="px-4 py-4 font-semibold">Pelanggan</th>
                        <th class="px-4 py-4 font-semibold">Nominal</th>
                        <th class="px-4 py-4 font-semibold">Metode</th>
                        <th class="px-4 py-4 font-semibold">Status</th>
                        <th class="px-4 py-4 font-semibold">Bukti</th>
                        <th class="px-4 py-4 font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($payments as $payment)
                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-5 text-sm font-semibold text-slate-800">
                                {{ $payment->kode_transaksi }}
                            </td>

                            <td class="px-4 py-5 text-sm text-slate-700">
                                {{ $payment->nama_pelanggan }}
                            </td>

                            <td class="px-4 py-5 text-sm font-semibold text-[#2F5249]">
                                Rp {{ number_format($payment->nominal, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-5 text-sm">
                                <button
                                    type="button"
                                    onclick="openQrisModal()"
                                    class="font-semibold text-[#2F5249] hover:underline"
                                >
                                    {{ $payment->metode ?? 'QRIS Dana' }}
                                </button>
                            </td>

                            <td class="px-4 py-5">
                                @if($payment->status === 'Lunas')
                                    <span class="rounded-full bg-[#eef3ee] px-3 py-1 text-xs font-semibold text-[#2F5249]">
                                        Lunas
                                    </span>
                                @elseif($payment->status === 'Ditolak')
                                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                        Menunggu Verifikasi
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-5">
                                @if($payment->bukti_bayar)
                                    <a href="{{ asset('storage/' . $payment->bukti_bayar) }}"
                                       target="_blank"
                                       class="text-sm font-semibold text-[#2F5249] hover:underline">
                                        Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-sm text-slate-400">
                                        Belum upload
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-5">
                                @if($payment->status !== 'Lunas')
                                    <form action="{{ route('pelanggan.pembayaran.upload', $payment->id) }}"
                                          method="POST"
                                          enctype="multipart/form-data"
                                          class="space-y-2">
                                        @csrf

                                        <input
                                            type="file"
                                            name="bukti_bayar"
                                            accept="image/*"
                                            required
                                            class="block w-full text-sm text-slate-700 file:mr-3 file:rounded-xl file:border-0 file:bg-[#eef3ee] file:px-3 file:py-2 file:text-sm file:font-semibold file:text-[#2F5249]"
                                        >

                                        <button
                                            type="submit"
                                            class="rounded-2xl bg-[#2F5249] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#437057]"
                                        >
                                            Upload Bukti
                                        </button>
                                    </form>
                                @else
                                    <span class="rounded-2xl bg-[#eef3ee] px-4 py-2 text-sm font-semibold text-[#2F5249]">
                                        Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">
                                Belum ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div
        id="qrisModal"
        class="fixed inset-0 z-[9999] hidden items-center justify-center p-4"
    >
        <div
            onclick="closeQrisModal()"
            class="absolute inset-0 bg-black/40"
        ></div>

        <div class="relative w-full max-w-md overflow-hidden rounded-3xl bg-white shadow-2xl">
            <div class="border-b border-slate-200 px-5 py-4">
                <h3 class="text-lg font-bold text-[#2F5249]">
                    QRIS Dana
                </h3>
                <p class="mt-1 text-xs text-slate-500">
                    Scan QRIS lalu upload bukti pembayaran.
                </p>
            </div>

            <div class="bg-[#F8FAF7] p-5">
                <img
                    src="{{ asset('images/qris-dana.jpeg') }}"
                    alt="QRIS Dana"
                    class="mx-auto max-h-[70vh] w-auto rounded-2xl"
                >
            </div>
        </div>
    </div>

</div>

<script>
    function openQrisModal() {
        const modal = document.getElementById('qrisModal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeQrisModal() {
        const modal = document.getElementById('qrisModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection