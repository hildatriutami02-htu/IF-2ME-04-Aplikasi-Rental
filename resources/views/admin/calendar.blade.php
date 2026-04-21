@extends('admin.dashboard-admin')

@section('title', 'Kalender Rental - LensCamp')
@section('page_title', 'Kalender Rental')
@section('page_desc', 'Pantau jadwal booking, sewa aktif, dan pengembalian barang')

@section('content')
<div class="max-w-7xl mx-auto space-y-5 animate-fade-up">

    <!-- RINGKASAN -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <p class="text-sm text-slate-500">Booking Hari Ini</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">8</h3>
            <span class="inline-flex mt-4 px-2.5 py-1 rounded-full text-[11px] font-medium bg-yellow-100 text-yellow-700">
                Jadwal masuk
            </span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <p class="text-sm text-slate-500">Sedang Disewa</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">14</h3>
            <span class="inline-flex mt-4 px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-100 text-blue-700">
                Rental aktif
            </span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <p class="text-sm text-slate-500">Jatuh Tempo Kembali</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">5</h3>
            <span class="inline-flex mt-4 px-2.5 py-1 rounded-full text-[11px] font-medium bg-red-100 text-red-700">
                Perlu dipantau
            </span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <p class="text-sm text-slate-500">Selesai Hari Ini</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">3</h3>
            <span class="inline-flex mt-4 px-2.5 py-1 rounded-full text-[11px] font-medium bg-green-100 text-green-700">
                Dikembalikan
            </span>
        </div>
    </div>

    <!-- KALENDER + SIDEPANEL -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <!-- KALENDER -->
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
                    <div class="h-24 rounded-2xl bg-slate-50 border border-slate-200 p-2 text-slate-400">30</div>
                    <div class="h-24 rounded-2xl bg-slate-50 border border-slate-200 p-2 text-slate-400">31</div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">1</div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">2</div>
                        <div class="mt-2 text-[10px] px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 w-fit">
                            1 Booking
                        </div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">3</div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">4</div>
                        <div class="mt-2 text-[10px] px-2 py-1 rounded-full bg-blue-100 text-blue-700 w-fit">
                            2 Aktif
                        </div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">5</div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">6</div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">7</div>
                        <div class="mt-2 text-[10px] px-2 py-1 rounded-full bg-red-100 text-red-700 w-fit">
                            Return
                        </div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">8</div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">9</div>
                    </div>

                    <div class="h-24 rounded-2xl bg-blue-50 border border-blue-200 p-2 shadow-sm">
                        <div class="text-sm font-semibold text-blue-700">10</div>
                        <div class="mt-2 text-[10px] px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 w-fit">
                            2 Booking
                        </div>
                        <div class="mt-1 text-[10px] px-2 py-1 rounded-full bg-blue-100 text-blue-700 w-fit">
                            1 Aktif
                        </div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">11</div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">12</div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">13</div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2">
                        <div class="text-sm font-semibold text-slate-700">14</div>
                        <div class="mt-2 text-[10px] px-2 py-1 rounded-full bg-green-100 text-green-700 w-fit">
                            Selesai
                        </div>
                    </div>

                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">15</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">16</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">17</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">18</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">19</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">20</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">21</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">22</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">23</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">24</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">25</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">26</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">27</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">28</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">29</div></div>
                    <div class="h-24 rounded-2xl bg-white border border-slate-200 p-2"><div class="text-sm font-semibold text-slate-700">30</div></div>
                    <div class="h-24 rounded-2xl bg-slate-50 border border-slate-200 p-2 text-slate-400">1</div>
                    <div class="h-24 rounded-2xl bg-slate-50 border border-slate-200 p-2 text-slate-400">2</div>
                    <div class="h-24 rounded-2xl bg-slate-50 border border-slate-200 p-2 text-slate-400">3</div>
                </div>
            </div>
        </div>

        <!-- SIDEPANEL -->
        <div class="space-y-5">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Legenda</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                        <span class="text-sm text-slate-600">Booking</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                        <span class="text-sm text-slate-600">Sedang Disewa</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                        <span class="text-sm text-slate-600">Sudah Dikembalikan</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="text-sm text-slate-600">Jatuh Tempo Return</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Agenda Hari Ini</h3>

                <div class="space-y-4">
                    <div class="rounded-xl border border-slate-200 p-4 bg-slate-50">
                        <p class="font-semibold text-slate-800">Canon EOS 80D</p>
                        <p class="text-sm text-slate-500 mt-1">Booking oleh Ahmad Nasrulloh</p>
                        <span class="inline-flex mt-3 px-2.5 py-1 rounded-full text-[11px] font-medium bg-yellow-100 text-yellow-700">
                            Booking
                        </span>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-4 bg-slate-50">
                        <p class="font-semibold text-slate-800">Tenda 4 Orang</p>
                        <p class="text-sm text-slate-500 mt-1">Masih dalam masa sewa</p>
                        <span class="inline-flex mt-3 px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-100 text-blue-700">
                            Sedang Disewa
                        </span>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-4 bg-slate-50">
                        <p class="font-semibold text-slate-800">Tripod Kamera</p>
                        <p class="text-sm text-slate-500 mt-1">Jadwal pengembalian hari ini</p>
                        <span class="inline-flex mt-3 px-2.5 py-1 rounded-full text-[11px] font-medium bg-red-100 text-red-700">
                            Return
                        </span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection