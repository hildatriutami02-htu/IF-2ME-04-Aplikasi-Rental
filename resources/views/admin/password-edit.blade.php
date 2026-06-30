@extends('admin.dashboard-admin')

@section('title', 'Ganti Password - LensCamp')
@section('page_title', 'Ganti Password')
@section('page_desc', 'Perbarui password akun administrator')

@section('content')

<div class="max-w-2xl mx-auto">

    @if(session('success'))
        <div class="mb-4 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-[#dfe7df]">

        <div class="px-5 py-4 border-b border-[#dfe7df]">
            <h3 class="font-semibold text-[#2F5249]">
                Ubah Password Admin
            </h3>
        </div>

        <form action="{{ route('admin.password.update') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div>
                <label class="block mb-2 text-sm font-medium">
                    Password Lama
                </label>

                <input
                    type="password"
                    name="password_lama"
                    maxlength="6"
                    required
                    class="w-full rounded-xl border border-[#dfe7df] p-3 focus:border-[#2F5249] focus:ring-[#2F5249]">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium">
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password_baru"
                    maxlength="6"
                    required
                    class="w-full rounded-xl border border-[#dfe7df] p-3 focus:border-[#2F5249] focus:ring-[#2F5249]">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium">
                    Konfirmasi Password Baru
                </label>

                <input
                    type="password"
                    name="password_baru_confirmation"
                    maxlength="6"
                    required
                    class="w-full rounded-xl border border-[#dfe7df] p-3 focus:border-[#2F5249] focus:ring-[#2F5249]">
            </div>

            <button
                type="submit"
                class="px-6 py-3 rounded-xl bg-[#2F5249] hover:bg-[#437057] text-white font-semibold transition">
                Simpan Password
            </button>

        </form>

    </div>

</div>

@endsection