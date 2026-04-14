<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        <!-- CARD -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            <!-- HEADER DALAM CARD (INI YANG BIRU) -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 py-5 text-center">
                <h1 class="text-2xl font-bold text-white tracking-wide">
                    LOGIN
                </h1>
            </div>

            <!-- ISI FORM -->
            <div class="p-6">

                <h2 class="text-center text-lg font-semibold text-slate-800 mb-6">
                    Login ke akun Anda
                </h2>

                <form action="{{ route('login.proses') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Pilih User -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Pilih User
                        </label>
                        <select
                            name="user_type"
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                            required
                        >
                            <option value="">Pilih jenis user</option>
                            <option value="admin">Admin</option>
                            <option value="pelanggan">Pelanggan</option>
                        </select>
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Nama Pengguna / Email
                        </label>
                        <input
                            type="text"
                            name="email"
                            placeholder="masukkan username / email"
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                            required
                        >
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                            required
                        >
                    </div>

                    <!-- Lupa password -->
                    <div>
                        <a href="#" class="text-blue-600 text-sm hover:underline">
                            Lupa sandi?
                        </a>
                    </div>

                    <!-- Button -->
                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-xl shadow-md transition"
                    >
                        Verifikasi
                    </button>

                    <!-- Register -->
                    <p class="text-center text-xs text-slate-500">
                        Belum punya akun?
                        <a href="{{ route('daftar') }}" class="text-blue-600 font-semibold hover:underline">
                            Daftar di sin
                        </a>
                    </p>

                </form>
            </div>

        </div>

    </div>

</body>
</html>