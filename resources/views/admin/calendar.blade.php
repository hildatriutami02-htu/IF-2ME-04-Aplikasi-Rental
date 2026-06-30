@extends('admin.dashboard-admin')

@section('title', 'Kalender Rental - LensCamp')
@section('page_title', 'Kalender Rental')
@section('page_desc', 'Pantau jadwal booking, sewa aktif, dan pengembalian barang')

@section('content')
@php
    use Carbon\Carbon;

    $rentals = $rentals ?? collect();

    $today = Carbon::today();
    $currentMonth = request('month') ? Carbon::parse(request('month')) : Carbon::today();

    $startOfMonth = $currentMonth->copy()->startOfMonth();
    $endOfMonth = $currentMonth->copy()->endOfMonth();

    $calendarStart = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
    $calendarEnd = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);

    $prevMonth = $currentMonth->copy()->subMonth()->format('Y-m-01');
    $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m-01');

    $summaryCardClass = 'bg-white rounded-2xl border border-[#dfe7df] shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg';
    $panelClass = 'bg-white rounded-2xl border border-[#dfe7df] shadow-sm p-5 transition-all duration-300 hover:shadow-md';
    $calendarDayClass = 'min-h-24 rounded-2xl bg-white border border-[#dfe7df] p-2';
    $calendarMutedDayClass = 'min-h-24 rounded-2xl bg-[#F8FAF7] border border-[#dfe7df] p-2 text-slate-400';
    $badgeBaseClass = 'inline-flex mt-4 px-2.5 py-1 rounded-full text-[11px] font-medium';
    $miniBadgeClass = 'mt-2 text-[10px] px-2 py-1 rounded-full w-fit';
    $agendaItemClass = 'rounded-xl border border-[#dfe7df] p-4 bg-[#F8FAF7]';

    $bookingHariIni = $rentals->where('status_transaksi', 'Booking')->count();

    $sedangDisewa = $rentals->filter(fn($r) =>
        in_array($r->status_transaksi, ['Booking', 'Diambil', 'Sedang Disewa', 'Menunggu Verifikasi'])
    )->count();

    $jatuhTempo = $rentals->filter(fn($r) =>
        $r->tanggal_kembali
        && Carbon::parse($r->tanggal_kembali)->lte($today)
        && $r->status_transaksi !== 'Dikembalikan'
    )->count();

    $selesaiHariIni = $rentals->where('status_transaksi', 'Dikembalikan')->count();

    $legendItems = [
        ['color' => 'bg-amber-400', 'label' => 'Booking'],
        ['color' => 'bg-blue-500', 'label' => 'Disewa'],
        ['color' => 'bg-[#437057]', 'label' => 'Sudah Dikembalikan'],
        ['color' => 'bg-red-500', 'label' => 'Jatuh Tempo'],
    ];

    $agendaToday = $rentals->filter(function ($r) use ($today) {
        $tanggalPinjam = $r->tanggal_pinjam ? Carbon::parse($r->tanggal_pinjam)->isSameDay($today) : false;
        $tanggalKembali = $r->tanggal_kembali ? Carbon::parse($r->tanggal_kembali)->isSameDay($today) : false;
        $tanggalReal = $r->tanggal_kembali_real ? Carbon::parse($r->tanggal_kembali_real)->isSameDay($today) : false;

        return $tanggalPinjam || $tanggalKembali || $tanggalReal;
    });
@endphp

<div class="max-w-7xl mx-auto space-y-5 animate-fade-up">

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        <div class="{{ $summaryCardClass }}">
            <p class="text-sm text-slate-500">Booking Hari Ini</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">{{ $bookingHariIni }}</h3>
            <span class="{{ $badgeBaseClass }} bg-amber-100 text-amber-700">Jadwal masuk</span>
        </div>

        <div class="{{ $summaryCardClass }}">
            <p class="text-sm text-slate-500">Sedang Disewa</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">{{ $sedangDisewa }}</h3>
            <span class="{{ $badgeBaseClass }} bg-blue-100 text-blue-700">Rental aktif</span>
        </div>

        <div class="{{ $summaryCardClass }}">
            <p class="text-sm text-slate-500">Jatuh Tempo Kembali</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">{{ $jatuhTempo }}</h3>
            <span class="{{ $badgeBaseClass }} bg-red-100 text-red-700">Perlu dipantau</span>
        </div>

        <div class="{{ $summaryCardClass }}">
            <p class="text-sm text-slate-500">Selesai Hari Ini</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">{{ $selesaiHariIni }}</h3>
            <span class="{{ $badgeBaseClass }} bg-[#DDE8DF] text-[#437057]">Dikembalikan</span>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <div class="xl:col-span-2 bg-white rounded-2xl border border-[#dfe7df] shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
            <div class="px-5 py-4 border-b border-[#dfe7df] flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-[#2F5249]">
                        {{ $currentMonth->translatedFormat('F Y') }}
                    </h3>
                    <p class="text-sm text-slate-500">Kalender jadwal rental bulanan</p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.calendar', ['month' => $prevMonth]) }}"
                       class="px-3 py-2 rounded-xl bg-[#DDE8DF] hover:bg-[#C8D8CC] text-[#2F5249] text-sm transition-all duration-300">
                        ←
                    </a>

                    <a href="{{ route('admin.calendar', ['month' => $nextMonth]) }}"
                       class="px-3 py-2 rounded-xl bg-[#DDE8DF] hover:bg-[#C8D8CC] text-[#2F5249] text-sm transition-all duration-300">
                        →
                    </a>
                </div>
            </div>

            <div class="p-5">
                <div class="grid grid-cols-7 gap-3 text-center text-sm font-semibold text-slate-500 mb-3">
                    <div>Sen</div>
                    <div>Sel</div>
                    <div>Rab</div>
                    <div>Kam</div>
                    <div>Jum</div>
                    <div>Sab</div>
                    <div>Min</div>
                </div>

                <div class="grid grid-cols-7 gap-3">
                    @for ($date = $calendarStart->copy(); $date->lte($calendarEnd); $date->addDay())
                        @php
    $isCurrentMonth = $date->month === $currentMonth->month;
    $isToday = $date->isSameDay($today);

    $bookingCount = $rentals->filter(function ($r) use ($date) {
        return $r->tanggal_pinjam
            && Carbon::parse($r->tanggal_pinjam)->isSameDay($date)
            && in_array($r->status_transaksi, ['Booking', 'Menunggu Verifikasi']);
    })->count();

    $rentCount = $rentals->filter(function ($r) use ($date) {
        if (!$r->tanggal_pinjam || !$r->tanggal_kembali) {
            return false;
        }

        return Carbon::parse($date)->between(
            Carbon::parse($r->tanggal_pinjam),
            Carbon::parse($r->tanggal_kembali)
        ) && in_array($r->status_transaksi, ['Sedang Disewa', 'Diambil']);
    })->count();

    $returnCount = $rentals->filter(function ($r) use ($date) {
        return $r->tanggal_kembali
            && Carbon::parse($r->tanggal_kembali)->isSameDay($date)
            && !in_array($r->status_transaksi, ['Dikembalikan']);
    })->count();

    $doneCount = $rentals->filter(function ($r) use ($date) {
        return $r->tanggal_kembali_real
            && Carbon::parse($r->tanggal_kembali_real)->isSameDay($date)
            && $r->status_transaksi === 'Dikembalikan';
    })->count();

    $dayClass = $isCurrentMonth ? $calendarDayClass : $calendarMutedDayClass;

    if ($isToday) {
        $dayClass = 'min-h-24 rounded-2xl bg-[#DDE8DF] border border-[#437057] p-2 shadow-sm';
    }
@endphp

                        <div class="{{ $dayClass }}">
                            <div class="text-sm font-semibold {{ $isToday ? 'text-[#2F5249]' : 'text-slate-700' }}">
                                {{ $date->day }}
                            </div>

                            @if ($bookingCount > 0)
                                <div class="{{ $miniBadgeClass }} bg-amber-100 text-amber-700">
                                    {{ $bookingCount }} Booking
                                </div>
                            @endif

                            @if ($rentCount > 0)
                                <div class="{{ $miniBadgeClass }} bg-blue-100 text-blue-700">
                                    {{ $rentCount }} Disewa
                                </div>
                            @endif

                            @if ($returnCount > 0)
                                <div class="{{ $miniBadgeClass }} bg-red-100 text-red-700">
                                    {{ $returnCount }} Jatuh Tempo
                                </div>
                            @endif

                            @if ($doneCount > 0)
                                <div class="{{ $miniBadgeClass }} bg-[#DDE8DF] text-[#437057]">
                                    {{ $doneCount }} Selesai
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="space-y-5">

            <div class="{{ $panelClass }}">
                <h3 class="text-lg font-bold text-[#2F5249] mb-4">Legenda</h3>
                <div class="space-y-3">
                    @foreach ($legendItems as $legend)
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full {{ $legend['color'] }}"></span>
                            <span class="text-sm text-slate-600">{{ $legend['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="{{ $panelClass }}">
                <h3 class="text-lg font-bold text-[#2F5249] mb-4">Agenda Hari Ini</h3>

                <div class="space-y-4">
                    @forelse ($agendaToday as $agenda)
                        @php
                            $badgeClass = 'bg-blue-100 text-blue-700';
                            $badgeText = $agenda->status_transaksi ?? '-';

                            if (($agenda->status_transaksi ?? '') === 'Booking') {
                                $badgeClass = 'bg-amber-100 text-amber-700';
                            } elseif (($agenda->status_transaksi ?? '') === 'Dikembalikan') {
                                $badgeClass = 'bg-[#DDE8DF] text-[#437057]';
                            } elseif ($agenda->tanggal_kembali && Carbon::parse($agenda->tanggal_kembali)->isSameDay($today)) {
                                $badgeClass = 'bg-red-100 text-red-700';
                                $badgeText = 'Jatuh Tempo';
                            }
                        @endphp

                        <div class="{{ $agendaItemClass }}">
                            <p class="font-semibold text-slate-800">{{ $agenda->nama_barang ?? '-' }}</p>
                            <p class="text-sm text-slate-500 mt-1">
                                {{ $agenda->nama_pelanggan ?? '-' }}
                            </p>
                            <p class="text-xs text-slate-400 mt-1">
                                {{ $agenda->tanggal_pinjam }} - {{ $agenda->tanggal_kembali }}
                            </p>

                            <span class="inline-flex mt-3 px-2.5 py-1 rounded-full text-[11px] font-medium {{ $badgeClass }}">
                                {{ $badgeText }}
                            </span>
                        </div>
                    @empty
                        <div class="rounded-xl border border-[#dfe7df] p-4 bg-[#F8FAF7]">
                            <p class="text-sm text-slate-500">Tidak ada agenda hari ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>
@endsection