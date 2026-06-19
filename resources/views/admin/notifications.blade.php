@extends('admin.dashboard-admin')

@section('title', 'Notifikasi - LensCamp')
@section('page_title', 'Notifikasi')
@section('page_desc', 'Daftar notifikasi aktivitas rental')

@section('content')
<div class="max-w-6xl mx-auto animate-fade-up">

    @if(session('success'))
        <div class="mb-4 p-3 rounded-xl bg-[#eef3ee] text-[#2F5249] text-sm border border-[#dfe7df]">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-[#dfe7df] shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-[#dfe7df] flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-[#2F5249]">Daftar Notifikasi</h3>
                <p class="text-sm text-slate-500">
                    Total: {{ $notifications->count() }} notifikasi
                </p>
            </div>

            <div class="px-3 py-1 rounded-full bg-[#eef3ee] text-[#2F5249] text-sm font-semibold">
                Belum Dibaca:
                {{ $notifications->where('status', 'Belum Dibaca')->count() }}
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#F8FAF7] text-slate-700">
                    <tr>
                        <th class="px-5 py-3">No</th>
                        <th class="px-5 py-3">Judul</th>
                        <th class="px-5 py-3">Pesan</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#dfe7df]">
                    @forelse($notifications as $notification)
                        <tr class="hover:bg-[#F8FAF7] transition">
                            <td class="px-5 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-5 py-4 font-semibold text-slate-800">
                                {{ $notification->judul }}
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $notification->pesan }}
                            </td>

                            <td class="px-5 py-4">
                                @if($notification->status === 'Belum Dibaca')
                                    <span class="px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-semibold border border-red-200">
                                        Belum Dibaca
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold border border-green-200">
                                        Sudah Dibaca
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-slate-500">
                                {{ $notification->created_at ? $notification->created_at->format('d/m/Y H:i') : '-' }}
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    @if($notification->status === 'Belum Dibaca')
                                        <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="px-3 py-2 rounded-lg bg-[#2F5249] text-white text-xs font-semibold hover:bg-[#437057] transition"
                                            >
                                                Tandai Dibaca
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            onclick="return confirm('Hapus notifikasi ini?')"
                                            class="px-3 py-2 rounded-lg bg-red-600 text-white text-xs font-semibold hover:bg-red-700 transition"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-slate-500">
                                Belum ada notifikasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection