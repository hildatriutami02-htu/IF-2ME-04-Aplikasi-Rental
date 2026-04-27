@extends('admin.dashboard-admin')

@section('title', 'Kalender Rental - LensCamp')
@section('page_title', 'Kalender Rental')
@section('page_desc', 'Pantau jadwal booking, sewa aktif, dan pengembalian barang')

@section('content')
@php
    $summaryCardClass = 'bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg';
    $panelClass = 'bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md';
    $calendarDayClass = 'h-24 rounded-2xl bg-white border border-slate-200 p-2';
    $calendarMutedDayClass = 'h-24 rounded-2xl bg-slate-50 border border-slate-200 p-2 text-slate-400';
    $badgeBaseClass = 'inline-flex mt-4 px-2.5 py-1 rounded-full text-[11px] font-medium';
    $miniBadgeClass = 'mt-2 text-[10px] px-2 py-1 rounded-full w-fit';
    $agendaItemClass = 'rounded-xl border border-slate-200 p-4 bg-slate-50';

    $summaryCards = [
        [
            'title' => 'Booking Hari Ini',
            'value' => '8',
            'badgeText' => 'Jadwal masuk',
            'badgeClass' => 'bg-yellow-100 text-yellow-700',
        ],
        [
            'title' => 'Sedang Disewa',
            'value' => '14',
            'badgeText' => 'Rental aktif',
            'badgeClass' => 'bg-blue-100 text-blue-700',
        ],
        [
            'title' => 'Jatuh Tempo Kembali',
            'value' => '5',
            'badgeText' => 'Perlu dipantau',
            'badgeClass' => 'bg-red-100 text-red-700',
        ],
        [
            'title' => 'Selesai Hari Ini',
            'value' => '3',
            'badgeText' => 'Dikembalikan',
            'badgeClass' => 'bg-green-100 text-green-700',
        ],
    ];

    $calendarDays = [
        ['day' => '30', 'type' => 'muted'],
        ['day' => '31', 'type' => 'muted'],
        ['day' => '1', 'type' => 'normal'],
        [
            'day' => '2',
            'type' => 'normal',
            'badges' => [
                ['text' => '1 Booking', 'class' => 'bg-yellow-100 text-yellow-700'],
            ],
        ],
        ['day' => '3', 'type' => 'normal'],
        [
            'day' => '4',
            'type' => 'normal',
            'badges' => [
                ['text' => '2 Aktif', 'class' => 'bg-blue-100 text-blue-700'],
            ],
        ],
        ['day' => '5', 'type' => 'normal'],
        ['day' => '6', 'type' => 'normal'],
        [
            'day' => '7',
            'type' => 'normal',
            'badges' => [
                ['text' => 'Return', 'class' => 'bg-red-100 text-red-700'],
            ],
        ],
        ['day' => '8', 'type' => 'normal'],
        ['day' => '9', 'type' => 'normal'],
        [
            'day' => '10',
            'type' => 'active',
            'badges' => [
                ['text' => '2 Booking', 'class' => 'bg-yellow-100 text-yellow-700'],
                ['text' => '1 Aktif', 'class' => 'bg-blue-100 text-blue-700', 'extraClass' => 'mt-1'],
            ],
        ],
        ['day' => '11', 'type' => 'normal'],
        ['day' => '12', 'type' => 'normal'],
        ['day' => '13', 'type' => 'normal'],
        [
            'day' => '14',
            'type' => 'normal',
            'badges' => [
                ['text' => 'Selesai', 'class' => 'bg-green-100 text-green-700'],
            ],
        ],
        ['day' => '15', 'type' => 'normal'],
        ['day' => '16', 'type' => 'normal'],
        ['day' => '17', 'type' => 'normal'],
        ['day' => '18', 'type' => 'normal'],
        ['day' => '19', 'type' => 'normal'],
        ['day' => '20', 'type' => 'normal'],
        ['day' => '21', 'type' => 'normal'],
        ['day' => '22', 'type' => 'normal'],
        ['day' => '23', 'type' => 'normal'],
        ['day' => '24', 'type' => 'normal'],
        ['day' => '25', 'type' => 'normal'],
        ['day' => '26', 'type' => 'normal'],
        ['day' => '27', 'type' => 'normal'],
        ['day' => '28', 'type' => 'normal'],
        ['day' => '29', 'type' => 'normal'],
        ['day' => '30', 'type' => 'normal'],
        ['day' => '1', 'type' => 'muted'],
        ['day' => '2', 'type' => 'muted'],
        ['day' => '3', 'type' => 'muted'],
    ];

    $legendItems = [
        ['color' => 'bg-yellow-400', 'label' => 'Booking'],
        ['color' => 'bg-blue-500', 'label' => 'Sedang Disewa'],
        ['color' => 'bg-green-500', 'label' => 'Sudah Dikembalikan'],
        ['color' => 'bg-red-500', 'label' => 'Jatuh Tempo Return'],
    ];

    $agendaItems = [
        [
            'title' => 'Canon EOS 80D',
            'desc' => 'Booking oleh Ahmad Nasrulloh',
            'badgeText' => 'Booking',
            'badgeClass' => 'bg-yellow-100 text-yellow-700',
        ],
        [
            'title' => 'Tenda 4 Orang',
            'desc' => 'Masih dalam masa sewa',
            'badgeText' => 'Sedang Disewa',
            'badgeClass' => 'bg-blue-100 text-blue-700',
        ],
        [
            'title' => 'Tripod Kamera',
            'desc' => 'Jadwal pengembalian hari ini',
            'badgeText' => 'Return',
            'badgeClass' => 'bg-red-100 text-red-700',
        ],
    ];
@endphp

<div class="max-w-7xl mx-auto space-y-5 animate-fade-up">

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        @foreach ($summaryCards as $card)
            <div class="{{ $summaryCardClass }}">
                <p class="text-sm text-slate-500">{{ $card['title'] }}</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-2">{{ $card['value'] }}</h3>
                <span class="{{ $badgeBaseClass }} {{ $card['badgeClass'] }}">
                    {{ $card['badgeText'] }}
                </span>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">April 2026</h3>
                    <p class="text-sm text-slate-500">Kalender jadwal rental bulanan</p>
                </div>

                <div class="flex items-center gap-2">
                    <button class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm transition-all duration-300">
                        ←
                    </button>
                    <button class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm transition-all duration-300">
                        →
                    </button>
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
                    @foreach ($calendarDays as $day)
                        @php
                            $dayClass = $calendarDayClass;
                            $textClass = 'text-sm font-semibold text-slate-700';

                            if ($day['type'] === 'muted') {
                                $dayClass = $calendarMutedDayClass;
                                $textClass = '';
                            } elseif ($day['type'] === 'active') {
                                $dayClass = 'h-24 rounded-2xl bg-blue-50 border border-blue-200 p-2 shadow-sm';
                                $textClass = 'text-sm font-semibold text-blue-700';
                            }
                        @endphp

                        <div class="{{ $dayClass }}">
                            <div class="{{ $textClass }}">{{ $day['day'] }}</div>

                            @if (!empty($day['badges']))
                                @foreach ($day['badges'] as $badge)
                                    <div class="{{ $miniBadgeClass }} {{ $badge['class'] }} {{ $badge['extraClass'] ?? '' }}">
                                        {{ $badge['text'] }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-5">

            <div class="{{ $panelClass }}">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Legenda</h3>
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
                <h3 class="text-lg font-bold text-slate-800 mb-4">Agenda Hari Ini</h3>

                <div class="space-y-4">
                    @foreach ($agendaItems as $agenda)
                        <div class="{{ $agendaItemClass }}">
                            <p class="font-semibold text-slate-800">{{ $agenda['title'] }}</p>
                            <p class="text-sm text-slate-500 mt-1">{{ $agenda['desc'] }}</p>
                            <span class="inline-flex mt-3 px-2.5 py-1 rounded-full text-[11px] font-medium {{ $agenda['badgeClass'] }}">
                                {{ $agenda['badgeText'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>
@endsection