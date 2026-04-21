@extends('admin.dashboard-admin')

@section('title', 'Pengaturan Website - LensCamp')
@section('page_title', 'Pengaturan Website')
@section('page_desc', 'Atur informasi dasar website')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-up">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 hover:shadow-md">
        <div class="px-5 py-4 border-b border-slate-200">
            <h3 class="text-xl font-bold text-slate-800">Form Pengaturan</h3>
            <p class="text-sm text-slate-500">Perbarui informasi dasar website LensCamp</p>
        </div>

        <form class="p-5 space-y-5">
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-800">Nama Website</label>
                <input type="text" value="LensCamp" class="bg-slate-50 border border-slate-300 text-slate-800 text-sm rounded-xl block w-full p-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-slate-800">Email Admin</label>
                <input type="email" value="admin@lenscamp.com" class="bg-slate-50 border border-slate-300 text-slate-800 text-sm rounded-xl block w-full p-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-slate-800">Nomor WhatsApp</label>
                <input type="text" value="081234567890" class="bg-slate-50 border border-slate-300 text-slate-800 text-sm rounded-xl block w-full p-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-slate-800">Alamat</label>
                <textarea rows="4" class="bg-slate-50 border border-slate-300 text-slate-800 text-sm rounded-xl block w-full p-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">Batam, Indonesia</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection