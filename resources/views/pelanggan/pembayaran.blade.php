@extends('pelanggan.layouts.app')

@php
    $title = 'Pembayaran - LensCamp';
    $headerTitle = 'Pembayaran';
    $headerDesc = 'Lihat status pembayaran dan tagihan kamu';
@endphp

@section('content')
@php
    $payments = $payments ?? [];

    $summaryCards = [
        [
            'label' => 'Total Tagihan',
            'value' => 'Rp ' . number_format(collect($payments)->sum('nominal'), 0, ',', '.'),
            'valueClass' => 'text-slate-800',
        ],
        [
            'label' => 'Sudah Lunas',
            'value' => collect($payments)->where('status', 'Lunas')->count(),
            'valueClass' => 'text-blue-600',
        ],
        [
            'label' => 'Belum Lunas',
            'value' => collect($payments)->where('status', '!=', 'Lunas')->count(),
            'valueClass' => 'text-amber-600',
        ],
    ];

    $tableHeaders = ['Invoice', 'Produk', 'Tanggal', 'Nominal', 'Status', 'Aksi'];
@endphp

<div class="space-y-6">
    <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
        @foreach ($summaryCards as $card)
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">{{ $card['label'] }}</p>
                <h3 class="mt-2 text-3xl font-bold {{ $card['valueClass'] }}">
                    {{ $card['value'] }}
                </h3>
            </div>
        @endforeach
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-left">
                <thead>
                    <tr class="border-b border-slate-200 text-sm text-slate-500">
                        @foreach ($tableHeaders as $header)
                            <th class="px-4 py-4 font-semibold">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @forelse($payments as $item)
                        @php
                            $modalId = 'qrisModal' . $item['invoice'];
                        @endphp

                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-5 text-sm font-semibold text-slate-800">
                                {{ $item['invoice'] }}
                            </td>

                            <td class="px-4 py-5 text-sm text-slate-700">
                                {{ $item['produk'] }}
                            </td>

                            <td class="px-4 py-5 text-sm text-slate-700">
                                {{ $item['tanggal'] }}
                            </td>

                            <td class="px-4 py-5 text-sm font-semibold text-blue-600">
                                Rp {{ number_format($item['nominal'], 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-5">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $item['warna'] === 'blue' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>

                            <td class="px-4 py-5">
                                @if($item['status'] === 'Lunas')
                                    <span class="rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-500">
                                        Lunas
                                    </span>
                                @else
                                    <button
                                        type="button"
                                        onclick="document.getElementById('{{ $modalId }}').classList.remove('hidden')"
                                        class="rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                                    >
                                        Bayar
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td colspan="6" class="p-0">
                              <div
                               id="{{ $modalId }}"
                                 onclick="this.classList.add('hidden')"
                                 class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
                                >
                                    <div
                                     onclick="event.stopPropagation()"
                                      class="relative w-full max-w-md rounded-3xl bg-white p-6 text-center shadow-xl"
                                    >
                                        <button
                                            type="button"
                                            onclick="document.getElementById('{{ $modalId }}').classList.add('hidden')"
                                            class="absolute right-4 top-4 rounded-full bg-slate-100 px-3 py-1 text-sm font-bold text-slate-600 hover:bg-slate-200"
                                        >
                                            ×
                                        </button>

                                        <h3 class="text-xl font-bold text-slate-800">
                                            Pembayaran QRIS
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500">
                                            Scan QRIS untuk membayar invoice
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-slate-800">
                                            {{ $item['invoice'] }}
                                        </p>

                                        <div class="mt-5 rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                            <img
                                                src="{{ asset('images/qris-dana.jpeg') }}"
                                                alt="QRIS Pembayaran LensCamp"
                                                class="mx-auto h-72 w-72 rounded-2xl bg-white object-contain"
                                            >
                                        </div>

                                        <div class="mt-5 rounded-2xl bg-blue-50 p-4 text-left">
                                            <p class="text-sm text-slate-600">Produk</p>
                                            <p class="text-base font-semibold text-slate-800">
                                                {{ $item['produk'] }}
                                            </p>

                                            <p class="mt-3 text-sm text-slate-600">Total Bayar</p>
                                            <p class="text-2xl font-bold text-blue-600">
                                                Rp {{ number_format($item['nominal'], 0, ',', '.') }}
                                            </p>
                                        </div>

                                        <div class="mt-4 rounded-2xl bg-amber-50 p-4 text-left text-sm text-amber-700">
                                            <p class="font-semibold">Instruksi Pembayaran:</p>
                                            <ol class="mt-2 list-decimal space-y-1 pl-5">
                                                <li>Scan QRIS menggunakan DANA, mobile banking, atau e-wallet lain.</li>
                                                <li>Masukkan nominal sesuai total tagihan.</li>
                                                <li>Simpan bukti pembayaran.</li>
                                                <li>Hubungi admin LensCamp untuk konfirmasi pembayaran.</li>
                                            </ol>
                                        </div>

                                        <a
                                            href="{{ asset('images/qris-dana.jpeg') }}"
                                            download="qris-lenscamp.jpeg"
                                            class="mt-5 inline-flex w-full justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                                        >
                                            Download QRIS
                                        </a>

                                        <button
                                            type="button"
                                            onclick="document.getElementById('{{ $modalId }}').classList.add('hidden')"
                                            class="mt-3 w-full rounded-2xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200"
                                        >
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">
                                Belum ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection