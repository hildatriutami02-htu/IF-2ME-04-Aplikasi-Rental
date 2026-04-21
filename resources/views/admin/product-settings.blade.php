@extends('admin.dashboard-admin')

@section('title', 'Katalog Sub Barang - LensCamp')
@section('page_title', 'Katalog Sub Barang')
@section('page_desc', 'Kelola setting jenis barang, estimasi, dan status')

@section('content')
<div class="max-w-7xl mx-auto animate-fade-up">

    @if(session('success'))
        <div class="mb-4 rounded-2xl border border-green-200 bg-green-50 text-green-800 px-4 py-3 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm shadow-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="px-5 py-4 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">Update Sub Barang</h3>
        </div>

        <div class="p-5 grid grid-cols-1 xl:grid-cols-3 gap-6">

            <!-- JENIS BARANG -->
            <div class="space-y-4">
                <form action="{{ route('admin.product.settings.store', 'jenis_barang') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Barang</label>
                        <input type="text" name="nama" placeholder="Tambah Jenis Barang"
                               class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
                    </div>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        Simpan
                    </button>
                </form>

                <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-xs border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Jenis Barang</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productSettings['jenis_barang'] as $index => $item)
                                <tr class="border-t border-slate-200 hover:bg-slate-50 transition-colors duration-200">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">{{ $item['nama'] }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-center gap-2">
                                            <button type="button" data-modal-target="editJenis{{ $item['id'] }}" data-modal-toggle="editJenis{{ $item['id'] }}"
                                                class="px-3 py-1.5 rounded-md bg-cyan-500 text-white text-xs hover:bg-cyan-600 transition-all duration-200 hover:-translate-y-0.5">
                                                Update
                                            </button>
                                            <form action="{{ route('admin.product.settings.destroy', ['type' => 'jenis_barang', 'id' => $item['id']]) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 rounded-md bg-red-500 text-white text-xs hover:bg-red-600 transition-all duration-200 hover:-translate-y-0.5">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <div id="editJenis{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
                                    class="hidden fixed inset-0 z-50 justify-center items-center bg-slate-900/50 backdrop-blur-sm p-4">
                                    <div class="w-full max-w-md">
                                        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl">
                                            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
                                                <h3 class="text-lg font-bold text-slate-800">Update Jenis Barang</h3>
                                                <button type="button" data-modal-hide="editJenis{{ $item['id'] }}" class="text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg w-8 h-8 transition">✕</button>
                                            </div>
                                            <form action="{{ route('admin.product.settings.update', ['type' => 'jenis_barang', 'id' => $item['id']]) }}" method="POST" class="p-5 space-y-4">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="nama" value="{{ $item['nama'] }}"
                                                       class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
                                                <div class="flex justify-end gap-3">
                                                    <button type="button" data-modal-hide="editJenis{{ $item['id'] }}" class="px-4 py-2 rounded-xl bg-slate-200 text-slate-700 text-sm hover:bg-slate-300 transition-all duration-300">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm hover:bg-blue-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                                                        Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-slate-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ESTIMASI -->
            <div class="space-y-4">
                <form action="{{ route('admin.product.settings.store', 'estimasi') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Estimasi</label>
                        <input type="text" name="nama" placeholder="Tambah Estimasi"
                               class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
                    </div>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        Simpan
                    </button>
                </form>

                <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-xs border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Estimasi</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productSettings['estimasi'] as $index => $item)
                                <tr class="border-t border-slate-200 hover:bg-slate-50 transition-colors duration-200">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">{{ $item['nama'] }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-center gap-2">
                                            <button type="button" data-modal-target="editEstimasi{{ $item['id'] }}" data-modal-toggle="editEstimasi{{ $item['id'] }}"
                                                class="px-3 py-1.5 rounded-md bg-cyan-500 text-white text-xs hover:bg-cyan-600 transition-all duration-200 hover:-translate-y-0.5">
                                                Update
                                            </button>
                                            <form action="{{ route('admin.product.settings.destroy', ['type' => 'estimasi', 'id' => $item['id']]) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 rounded-md bg-red-500 text-white text-xs hover:bg-red-600 transition-all duration-200 hover:-translate-y-0.5">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <div id="editEstimasi{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
                                    class="hidden fixed inset-0 z-50 justify-center items-center bg-slate-900/50 backdrop-blur-sm p-4">
                                    <div class="w-full max-w-md">
                                        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl">
                                            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
                                                <h3 class="text-lg font-bold text-slate-800">Update Estimasi</h3>
                                                <button type="button" data-modal-hide="editEstimasi{{ $item['id'] }}" class="text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg w-8 h-8 transition">✕</button>
                                            </div>
                                            <form action="{{ route('admin.product.settings.update', ['type' => 'estimasi', 'id' => $item['id']]) }}" method="POST" class="p-5 space-y-4">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="nama" value="{{ $item['nama'] }}"
                                                       class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
                                                <div class="flex justify-end gap-3">
                                                    <button type="button" data-modal-hide="editEstimasi{{ $item['id'] }}" class="px-4 py-2 rounded-xl bg-slate-200 text-slate-700 text-sm hover:bg-slate-300 transition-all duration-300">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm hover:bg-blue-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                                                        Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-slate-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- STATUS -->
            <div class="space-y-4">
                <form action="{{ route('admin.product.settings.store', 'status') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                        <input type="text" name="nama" placeholder="Tambah Status"
                               class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
                    </div>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        Simpan
                    </button>
                </form>

                <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-xs border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productSettings['status'] as $index => $item)
                                <tr class="border-t border-slate-200 hover:bg-slate-50 transition-colors duration-200">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">{{ $item['nama'] }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-center gap-2">
                                            <button type="button" data-modal-target="editStatus{{ $item['id'] }}" data-modal-toggle="editStatus{{ $item['id'] }}"
                                                class="px-3 py-1.5 rounded-md bg-cyan-500 text-white text-xs hover:bg-cyan-600 transition-all duration-200 hover:-translate-y-0.5">
                                                Update
                                            </button>
                                            <form action="{{ route('admin.product.settings.destroy', ['type' => 'status', 'id' => $item['id']]) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 rounded-md bg-red-500 text-white text-xs hover:bg-red-600 transition-all duration-200 hover:-translate-y-0.5">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <div id="editStatus{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
                                    class="hidden fixed inset-0 z-50 justify-center items-center bg-slate-900/50 backdrop-blur-sm p-4">
                                    <div class="w-full max-w-md">
                                        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl">
                                            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
                                                <h3 class="text-lg font-bold text-slate-800">Update Status</h3>
                                                <button type="button" data-modal-hide="editStatus{{ $item['id'] }}" class="text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg w-8 h-8 transition">✕</button>
                                            </div>
                                            <form action="{{ route('admin.product.settings.update', ['type' => 'status', 'id' => $item['id']]) }}" method="POST" class="p-5 space-y-4">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="nama" value="{{ $item['nama'] }}"
                                                       class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
                                                <div class="flex justify-end gap-3">
                                                    <button type="button" data-modal-hide="editStatus{{ $item['id'] }}" class="px-4 py-2 rounded-xl bg-slate-200 text-slate-700 text-sm hover:bg-slate-300 transition-all duration-300">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm hover:bg-blue-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                                                        Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-slate-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection