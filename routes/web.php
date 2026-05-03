<?php

use App\Http\Controllers\UserController;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Rental;
use App\Models\DataUser;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

if (!function_exists('ensureAdmin')) {
    function ensureAdmin()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('login')->send();
            exit;
        }
    }
}

if (!function_exists('ensurePelanggan')) {
    function ensurePelanggan()
    {
        if (!session()->has('role') || session('role') !== 'pelanggan') {
            return redirect()->route('login')->send();
            exit;
        }
    }
}


/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('home');
})->name('root');


// TAMBAH DI SINI BOS
Route::get('/home', function () {
    $products = Product::latest()->get();

    $isPelanggan = false;
    $isAdmin = false;

    return view('home', compact(
        'products',
        'isPelanggan',
        'isAdmin'
    ));
})->name('home');

Route::get('/products/{id}', function ($id) {
    $product = Product::findOrFail((int) $id);

    return view('detail', compact('product'));
})->name('products.detail');

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::post('/login', function (Request $request) {

    $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);

    $email = $request->email;
    $password = $request->password;

    // admin (hardcode)
 

    // AMBIL DATA USER
    $users = session('admin_users', []);

    $user = collect($users)->firstWhere('email', $email);

     // belum daftar
    if (!$user) {
        return redirect()->route('daftar')
            ->withErrors(['Email belum terdaftar, silakan daftar dulu']);
    }

    // password salah
    if ($user['password'] !== $password) {
        return back()->withErrors(['Password salah']);
    }

// login berhasil
    session([
        'user' => $request->email,
        'role' => 'admin',
    ]);

    return redirect()->route('dashboard.admin');
})->name('login.proses');

Route::post('/login/pelanggan', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $users = session('admin_users', []);

    $user = collect($users)->first(function ($item) use ($request) {
        return ($item['email'] ?? '') === $request->email
            && ($item['password'] ?? '') === $request->password;
    });

    if (!$user) {
        return redirect()->back()->withInput()->withErrors([
            'Email atau password salah, atau akun belum terdaftar.'
        ]);
    }

    session([
        'user' => $user['email'],
        'role' => 'pelanggan',
    ]);

    return redirect()->route('pelanggan.dashboard');

})->name('login.pelanggan.proses');
Route::get('/login', function () {
    return view('auth.login-pilih');
})->name('login');

Route::get('/login/admin', function () {
    return view('auth.login-admin');
})->name('login.admin');

Route::get('/login/pelanggan', function () {
    return view('auth.login-pelanggan');
})->name('login.pelanggan');


// TAMBAH INI DI SINI
Route::post('/login/admin', function (Request $request) {
    $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);

    session([
        'user' => $request->email,
        'role' => 'admin',
    ]);

    return redirect()->route('dashboard.admin');
})->name('login.admin.proses');

//Route::get('/login', function () {
//    return view('auth.login-pilih');
//})->name('login');

//Route::get('/login/admin', function () {
//    return view('auth.login-admin');
//})->name('login.admin');

//Route::post('/login/admin', function (Request $request) {
//    $request->validate([
//        'email' => 'required',
//        'password' => 'required',
//    ]);

//    session([
//        'user' => $request->email,
//        'role' => 'admin',
//    ]);

//    return redirect()->route('dashboard.admin');
//})->name('login.admin.proses');

//Route::get('/login/pelanggan', function () {
//    return view('auth.login-pelanggan');
//})->name('login.pelanggan');

//Route::post('/login/pelanggan', function (Request $request) {
//    $request->validate([
//        'email' => 'required',
//        'password' => 'required',
//    ]);

//    session([
//        'user' => $request->email,
//        'role' => 'pelanggan',
//    ]);

//    return redirect()->route('home');
//})->name('login.pelanggan.proses');

Route::get('/daftar', function () {
    return view('daftar');
})->name('daftar');

Route::post('/daftar', function (Request $request) {
    $request->validate([
        'nama_lengkap' => 'required|string|max:100',
        'email' => 'required|email',
        'password' => 'required|string|min:3',
        'no_ktp' => 'required|string|max:30',
        'no_telp' => 'required|string|max:20',
        'no_wa' => 'required|string|max:20',
        'jenis_kelamin' => 'required|string',
        'alamat' => 'required|string',
    ]);

    if (DataUser::where('no_ktp', $request->no_ktp)->exists()) {
        return redirect()->back()->withInput()->withErrors([
            'No KTP sudah terdaftar.'
        ]);
    }

    $nextDataUserId = (DataUser::max('id') ?? 0) + 1;

    DataUser::create([
        'kode_user' => 'USR' . str_pad($nextDataUserId, 3, '0', STR_PAD_LEFT),
        'nama_lengkap' => $request->nama_lengkap,
        'no_ktp' => $request->no_ktp,
        'no_telp' => $request->no_telp,
        'no_wa' => $request->no_wa,
        'jenis_kelamin' => $request->jenis_kelamin,
        'alamat' => $request->alamat,
    ]);

    $users = session('admin_users', []);

    foreach ($users as $user) {
        if (($user['email'] ?? '') === $request->email) {
            return redirect()->back()->withInput()->withErrors([
                'Email sudah terdaftar, silakan login.'
            ]);
        }
    }

    $nextId = count($users) > 0 ? max(array_column($users, 'id')) + 1 : 1;

    $users[] = [
        'id' => $nextId,
        'kode_user' => 'USR' . str_pad($nextId, 3, '0', STR_PAD_LEFT),
        'nama_lengkap' => $request->nama_lengkap,
        'email' => $request->email,
        'password' => $request->password,
        'no_ktp' => $request->no_ktp,
        'no_telp' => $request->no_telp,
        'no_wa' => $request->no_wa,
        'jenis_kelamin' => $request->jenis_kelamin,
        'alamat' => $request->alamat,
        'status' => 'Aktif',
        'rentals' => [],
    ];

    session(['admin_users' => $users]);

    session([
        'user' => $request->email,
        'role' => 'pelanggan',
    ]);

    return redirect()->route('pelanggan.dashboard')
        ->with('success', 'Pendaftaran berhasil.');
})->name('daftar.proses');
Route::get('/logout', function () {
    session()->forget(['user', 'role']);
    return redirect()->route('login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard-admin', function () {
    ensureAdmin();

    $users = session('admin_users', []);
  //  $products = Product::all()->toArray();
   $products = Product::all()->toArray();
    $rentals = Rental::latest()->get()->toArray();

    $totalPendapatan = collect($rentals)
        ->whereIn('status_pembayaran', ['Lunas', 'DP'])
        ->sum('total_harga');

    $totalRental = count($rentals);
    $totalUser = count($users);
    $totalProduk = count($products);
    $totalBooking = collect($rentals)->where('status_transaksi', 'Booking')->count();
    $totalSedangDisewa = collect($rentals)->where('status_transaksi', 'Booking')->count();
    $totalDikembalikan = collect($rentals)->where('status_transaksi', 'Dikembalikan')->count();
    $totalUserAktif = collect($rentals)->pluck('user_id')->unique()->count();
    $totalPelangganAktif = $totalUserAktif;
    $totalProdukDisewa = collect($rentals)->sum('qty');

    $reportRows = collect($rentals)
        ->groupBy(function ($item) {
            return isset($item['tanggal_pinjam_raw'])
                ? Carbon::parse($item['tanggal_pinjam_raw'])->translatedFormat('F')
                : 'Tanpa Bulan';
        })
        ->map(function ($items, $bulan) {
            return [
                'bulan' => $bulan,
                'pendapatan' => collect($items)->sum('total_harga'),
                'transaksi' => count($items),
                'produk' => collect($items)->sum('qty'),
            ];
        })
        ->values()
        ->all();

    $latestUsers = collect($users)
        ->take(3)
        ->map(function ($user, $index) {
            return [
                'kode' => $user['kode_user'] ?? 'USR00' . ($index + 1),
                'nama' => $user['nama_lengkap'] ?? '-',
                'status' => $index === 2 ? 'Baru' : 'Aktif',
                'waktu' => $index === 0 ? 'Terdaftar hari ini' : ($index === 1 ? 'Terdaftar kemarin' : 'Terdaftar 2 hari lalu'),
            ];
        })
        ->all();

    $latestRentals = collect($rentals)
        ->take(3)
        ->map(function ($rental) {
            return [
                'produk' => $rental['nama_barang'] ?? '-',
                'pelanggan' => $rental['nama_pelanggan'] ?? '-',
                'tanggal' => ($rental['tanggal_pinjam'] ?? '-') . ' - ' . ($rental['tanggal_kembali'] ?? '-'),
                'bayar' => $rental['status_pembayaran'] ?? '-',
                'status' => $rental['status_transaksi'] ?? '-',
                'warna' => ($rental['status_transaksi'] ?? '') === 'Booking' ? 'yellow' : 'green',
            ];
        })
        ->all();

    return view('admin.dashboard', compact(
        'totalPendapatan',
        'totalRental',
        'totalUser',
        'totalProduk',
        'totalBooking',
        'totalSedangDisewa',
        'totalDikembalikan',
        'totalUserAktif',
        'totalPelangganAktif',
        'totalProdukDisewa',
        'reportRows',
        'latestUsers',
        'latestRentals'
    ));
})->name('dashboard.admin');

/*
|--------------------------------------------------------------------------
| Admin Users
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'edit']);
});

/*
|--------------------------------------------------------------------------
| Admin Products (DATABASE VERSION)
|--------------------------------------------------------------------------
*/

Route::get('/admin/products', function () {
    ensureAdmin();

//    $products = Product::latest()->get();
    $products = Product::latest()->get();

    return view('admin.products', compact('products'));
})->name('admin.products');

// DETAIL PRODUK
Route::get('/admin/products/{id}/detail', function ($id) {
    ensureAdmin();

    $product = Product::findOrFail((int) $id);

    return view('admin.products-detail', compact('product'));
})->name('admin.products.show');

// EDIT PRODUK
Route::get('/admin/products/{id}/edit', function ($id) {
    ensureAdmin();

    $product = Product::findOrFail((int) $id);

    return view('admin.products-edit', compact('product'));
})->name('admin.products.edit');

Route::get('/admin/products/store', function () {
    return redirect()->route('admin.products');
});

Route::match(['get', 'post'], '/admin/products/store', function (Request $request) {
    ensureAdmin();

    if ($request->isMethod('get')) {
        return redirect()->route('admin.products');
    }

    $request->validate([
        'kode_barang' => 'nullable|string|max:50',
        'nama_barang' => 'required|string|max:100',
        'jenis_barang' => 'nullable|string|max:100',
        'deskripsi' => 'required|string',
        'status' => 'nullable|string|max:50',
        'estimasi' => 'nullable|string|max:50',
        'harga' => 'required|numeric|min:0',
        'unit' => 'required|integer|min:0',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $gambarPath = null;

if ($request->hasFile('gambar')) {
    $gambarPath = $request->file('gambar')->store('products', 'public');
}
    Product::create([
        'kode_barang' => $request->kode_barang,
        'nama_barang' => $request->nama_barang,
        'jenis_barang' => $request->jenis_barang,
        'deskripsi' => $request->deskripsi,
        'status' => $request->status ?? 'Ready',
        'estimasi' => $request->estimasi,
        'harga' => $request->harga,
        'unit' => $request->unit,
        'gambar' => $gambarPath,
    ]);

    return redirect()->route('admin.products')
        ->with('success', 'Barang berhasil ditambahkan.');
})->name('admin.products.store');

Route::match(['post', 'put'], '/admin/products/{id}', function (Request $request, $id) {
    ensureAdmin();

    $request->validate([
        'kode_barang' => 'nullable|string|max:50',
        'nama_barang' => 'required|string|max:100',
        'jenis_barang' => 'nullable|string|max:100',
        'deskripsi' => 'required|string',
        'status' => 'nullable|string|max:50',
        'estimasi' => 'nullable|string|max:50',
        'harga' => 'required|numeric|min:0',
        'unit' => 'required|integer|min:0',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $product = Product::findOrFail((int) $id);
    $gambarPath = $product->gambar;

if ($request->hasFile('gambar')) {
    if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
        Storage::disk('public')->delete($product->gambar);
    }

    $gambarPath = $request->file('gambar')->store('products', 'public');
}

    $product->update([
        'kode_barang' => $request->kode_barang,
        'nama_barang' => $request->nama_barang,
        'jenis_barang' => $request->jenis_barang,
        'deskripsi' => $request->deskripsi,
        'status' => $request->status ?? 'Ready',
        'estimasi' => $request->estimasi,
        'harga' => $request->harga,
        'unit' => $request->unit,
        'gambar' => $gambarPath,
    ]);

    return redirect()->route('admin.products')
        ->with('success', 'Barang berhasil diupdate.');
})->name('admin.products.update');

Route::delete('/admin/products/{id}', function ($id) {
    ensureAdmin();

    Product::findOrFail((int) $id)->delete();

    return redirect()->route('admin.products')
        ->with('success', 'Barang berhasil dihapus.');
})->name('admin.products.destroy');

Route::get('/admin/product-settings', function () {
    ensureAdmin();

    $productSettings = session('product_settings', [
        'jenis_barang' => [],
        'estimasi' => [],
        'status' => [],
    ]);

    return view('admin.products-settings', compact('productSettings'));
})->name('admin.product.settings');

Route::get('/admin/product-settings/{type}/{id}/edit', function ($type, $id) {
    ensureAdmin();

    $allowed = ['jenis_barang', 'estimasi', 'status'];
    if (!in_array($type, $allowed)) {
        abort(404);
    }

    $settings = session('product_settings', [
        'jenis_barang' => [],
        'estimasi' => [],
        'status' => [],
    ]);

    $item = collect($settings[$type])->firstWhere('id', (int) $id);

    if (!$item) {
        abort(404);
    }

    return view('admin.products-settings-edit', compact('type', 'id', 'item'));
})->name('admin.product.settings.edit');

/*
|--------------------------------------------------------------------------
| Admin Product Settings
|--------------------------------------------------------------------------
*/

Route::post('/admin/product-settings/{type}', function (Request $request, $type) {
    ensureAdmin();

    $allowed = ['jenis_barang', 'estimasi', 'status'];
    if (!in_array($type, $allowed)) {
        abort(404);
    }

    $request->validate([
        'nama' => 'required|string|max:100',
    ]);

    $settings = session('product_settings', [
        'jenis_barang' => [],
        'estimasi' => [],
        'status' => [],
    ]);

    $nextId = count($settings[$type]) > 0
        ? max(array_column($settings[$type], 'id')) + 1
        : 1;

    $settings[$type][] = [
        'id' => $nextId,
        'nama' => $request->nama,
    ];

    session(['product_settings' => $settings]);

    return redirect()->route('admin.product.settings')
        ->with('success', 'Data berhasil ditambahkan.');
})->name('admin.product.settings.store');

Route::match(['post', 'put'], '/admin/product-settings/{type}/{id}', function (Request $request, $type, $id) {
    ensureAdmin();

    $allowed = ['jenis_barang', 'estimasi', 'status'];
    if (!in_array($type, $allowed)) {
        abort(404);
    }

    $request->validate([
        'nama' => 'required|string|max:100',
    ]);

    $settings = session('product_settings', [
        'jenis_barang' => [],
        'estimasi' => [],
        'status' => [],
    ]);

    foreach ($settings[$type] as &$item) {
        if ($item['id'] == $id) {
            $item['nama'] = $request->nama;
        }
    }
    unset($item);

    session(['product_settings' => $settings]);

    return redirect()->route('admin.product.settings')->with('success', 'Data berhasil diupdate.');
})->name('admin.product.settings.update');

Route::delete('/admin/product-settings/{type}/{id}', function ($type, $id) {
    ensureAdmin();

    $allowed = ['jenis_barang', 'estimasi', 'status'];
    if (!in_array($type, $allowed)) {
        abort(404);
    }

    $settings = session('product_settings', [
        'jenis_barang' => [],
        'estimasi' => [],
        'status' => [],
    ]);

    $settings[$type] = array_values(array_filter(
        $settings[$type],
        fn ($item) => $item['id'] != $id
    ));

    session(['product_settings' => $settings]);

    return redirect()->route('admin.product.settings')->with('success', 'Data berhasil dihapus.');
})->name('admin.product.settings.destroy');

/*
|--------------------------------------------------------------------------
| Admin Rentals
|--------------------------------------------------------------------------
*/

Route::get('/admin/rentals', function (Request $request) {
    ensureAdmin();

$users = \App\Models\DataUser::all()->toArray();
$rentals = Rental::latest()->get()->toArray();

//    $products = Product::all()->toArray();
    $products = Product::all()->toArray();
    $rentals = Rental::latest()->get()->toArray();

    $status = $request->query('status', 'semua');
    if ($status !== 'semua') {
        $rentals = array_values(array_filter(
            $rentals,
            fn ($item) => ($item['status_transaksi'] ?? '') === $status
        ));
    }

    return view('admin.rentals', compact('rentals', 'users', 'products'));
})->name('admin.rentals');

Route::get('/admin/rentals/{id}/detail', function ($id) {
    ensureAdmin();

    $rentals = Rental::latest()->get()->toArray();
    $rental = collect($rentals)->firstWhere('id', (int) $id);

    if (!$rental) {
        abort(404);
    }

    return view('admin.rental-detail', compact('rental'));
})->name('admin.rentals.show');

Route::get('/admin/rentals/{id}/edit', function ($id) {
    ensureAdmin();

    $rentals = Rental::latest()->get()->toArray();
    $users = session('admin_users', []);
//    $products = Product::all()->toArray();
    $products = Product::all()->toArray();

    $rental = collect($rentals)->firstWhere('id', (int) $id);

    if (!$rental) {
        abort(404);
    }

    return view('admin.rental-edit', compact('rental', 'users', 'products'));
})->name('admin.rentals.edit');

Route::get('/admin/rentals/{id}/extend', function ($id) {
    ensureAdmin();

    $rentals = Rental::latest()->get()->toArray();
    $rental = collect($rentals)->firstWhere('id', (int) $id);

    if (!$rental) {
        abort(404);
    }

    return view('admin.rental-extend', compact('rental'));
})->name('admin.rentals.extend');

Route::post('/admin/rentals/{id}/extend', function (Request $request, $id) {
    ensureAdmin();

    $request->validate([
        'tanggal_kembali' => 'required|date',
    ]);

    $rental = Rental::findOrFail((int) $id);

    $start = Carbon::parse($rental->tanggal_pinjam_raw ?? $rental->tanggal_pinjam);
    $end = Carbon::parse($request->tanggal_kembali);

    if ($end->lt($start)) {
        return redirect()->back()->withErrors([
            'Tanggal kembali baru tidak boleh lebih kecil dari tanggal pinjam.'
        ]);
    }

    $days = max($start->diffInDays($end), 1);

    $rental->tanggal_kembali_raw = $request->tanggal_kembali;
    $rental->tanggal_kembali = $request->tanggal_kembali;
    $rental->total_harga = $days * (int) $rental->harga_per_hari * (int) $rental->qty;
    $rental->save();

    return redirect()->route('admin.rentals')
        ->with('success', 'Perpanjangan sewa berhasil disimpan.');
})->name('admin.rentals.extend.proses');

    
Route::post('/pelanggan/produk/{id}/sewa', function (Request $request, $id) {
    ensurePelanggan();

    $request->validate([
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        'qty' => 'required|integer|min:1',
        'catatan' => 'nullable|string',
    ]);

    $product = Product::findOrFail((int) $id);
    $qty = (int) $request->qty;

    if ((int) $product->unit < $qty) {
        return redirect()->back()->withInput()->withErrors([
            'Stok produk tidak mencukupi.'
        ]);
    }

    $users = session('admin_users', []);
    $currentUser = collect($users)->firstWhere('email', session('user'));

    $start = Carbon::parse($request->tanggal_pinjam);
    $end = Carbon::parse($request->tanggal_kembali);
    $lama = max($start->diffInDays($end), 1);

    $nextId = (Rental::max('id') ?? 0) + 1;
    $kode = 'TRX' . str_pad((string) $nextId, 3, '0', STR_PAD_LEFT);

    Rental::create([
        'kode_transaksi' => $kode,
        'user_id' => $currentUser['id'] ?? null,
        'product_id' => $product->id,

        'nama_pelanggan' => $currentUser['nama_lengkap'] ?? session('user'),
        'email' => session('user'),

        'nama_barang' => $product->nama_barang,
        'qty' => $qty,

        'tanggal_pinjam' => $request->tanggal_pinjam,
        'tanggal_kembali' => $request->tanggal_kembali,
        'tanggal_pinjam_raw' => $request->tanggal_pinjam,
        'tanggal_kembali_raw' => $request->tanggal_kembali,
        'tanggal_kembali_real' => null,

        'harga_per_hari' => (int) $product->harga,
        'total_harga' => (int) $product->harga * $qty * $lama,
        'denda_per_hari' => 10000,
        'total_denda' => 0,

        'status_pembayaran' => 'Belum Bayar',
        'status_transaksi' => 'Menunggu Verifikasi',
        'catatan' => $request->catatan,
    ]);

    $product->unit = (int) $product->unit - $qty;
    $product->status = $product->unit > 0 ? 'Ready' : 'Disewa';
    $product->save();

    return redirect()->route('pelanggan.sewa')
        ->with('success', 'Pesanan sewa berhasil dibuat. Menunggu verifikasi admin.');
})->name('pelanggan.sewa.store');

Route::post('/admin/rentals/store', function (Request $request) {
    ensureAdmin();

    $request->validate([
        'user_id' => 'required',
        'product_id' => 'required',
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        'qty' => 'required|numeric|min:1',
        'status_pembayaran' => 'required',
        'status_transaksi' => 'required|in:Booking,Dikembalikan',
        'catatan' => 'nullable',
    ]);

    $users = session('admin_users', []);
//    $products = Product::all()->toArray();
    $products = Product::all()->toArray();
    $rentals = Rental::latest()->get()->toArray();

    $user = collect($users)->firstWhere('id', (int) $request->user_id);
    $product = collect($products)->firstWhere('id', (int) $request->product_id);

    if (!$user || !$product) {
        return redirect()->route('admin.rentals')->withErrors(['Data user atau barang tidak ditemukan.']);
    }

    $nextId = count($rentals) > 0 ? max(array_column($rentals, 'id')) + 1 : 1;
    $kode = 'TRX' . str_pad((string) $nextId, 3, '0', STR_PAD_LEFT);

    $hargaPerHari = (int) ($product['harga'] ?? 0);
    $qty = (int) $request->qty;

    $start = Carbon::parse($request->tanggal_pinjam);
    $end = Carbon::parse($request->tanggal_kembali);
    $lama = max($start->diffInDays($end), 1);

    $total = $hargaPerHari * $qty * $lama;

    $newRental = [
        'id' => $nextId,
        'kode_transaksi' => $kode,
        'user_id' => (int) $request->user_id,
        'product_id' => (int) $request->product_id,
        'nama_pelanggan' => $user['email'] ?? ($user['nama_lengkap'] ?? '-'),
        'email' => $user['email'] ?? '',
        'nama_barang' => $product['nama_barang'] ?? '-',
        'qty' => $qty,
        'tanggal_pinjam' => $start->format('d-m-Y'),
        'tanggal_kembali' => $end->format('d-m-Y'),
        'tanggal_pinjam_raw' => $request->tanggal_pinjam,
        'tanggal_kembali_raw' => $request->tanggal_kembali,
        'tanggal_kembali_real' => null,
        'harga_per_hari' => $hargaPerHari,
        'total_harga' => $total,
        'denda_per_hari' => 10000,
        'total_denda' => 0,
        'status_pembayaran' => $request->status_pembayaran,
        'status_transaksi' => $request->status_transaksi,
        'catatan' => $request->catatan,
    ];

    try {
//        $updatedProducts = syncRentalStock($products, null, $newRental);

//        foreach ($updatedProducts as $updatedProduct) {
//            Product::where('id', $updatedProduct['id'])->update([
//                'unit' => $updatedProduct['unit'],
//                'status' => $updatedProduct['status'],
//            ]);
//        }
    } catch (\Exception $e) {
        return redirect()->route('admin.rentals')->withErrors([$e->getMessage()]);
    }

    Rental::create($newRental);

    foreach ($users as &$u) {
        if ($u['id'] == $newRental['user_id']) {
            $u['rentals'][] = [
                'produk' => $newRental['nama_barang'],
                'tanggal_sewa' => $newRental['tanggal_pinjam'],
                'tanggal_kembali' => $newRental['tanggal_kembali'],
                'status_pembayaran' => $newRental['status_pembayaran'],
                'status_transaksi' => $newRental['status_transaksi'],
            ];
        }
    }
    unset($u);

    session(['admin_users' => $users]);

    return redirect()->route('admin.rentals')->with('success', 'Transaksi berhasil ditambahkan.');
})->name('admin.rentals.store');

Route::put('/admin/rentals/{id}', function (Request $request, $id) {
    ensureAdmin();

    $request->validate([
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        'qty' => 'required|numeric|min:1',
        'status_pembayaran' => 'required',
        'status_transaksi' => 'required',
    ]);

    $rental = Rental::findOrFail((int) $id);

    $start = Carbon::parse($request->tanggal_pinjam);
    $end = Carbon::parse($request->tanggal_kembali);
    $lama = max($start->diffInDays($end), 1);

    $rental->tanggal_pinjam = $request->tanggal_pinjam;
    $rental->tanggal_kembali = $request->tanggal_kembali;
    $rental->tanggal_pinjam_raw = $request->tanggal_pinjam;
    $rental->tanggal_kembali_raw = $request->tanggal_kembali;
    $rental->qty = (int) $request->qty;
    $rental->status_pembayaran = $request->status_pembayaran;
    $rental->status_transaksi = $request->status_transaksi;
    $rental->total_harga = (int) $rental->harga_per_hari * (int) $request->qty * $lama;
    $rental->save();

    return redirect()->route('admin.rentals')
        ->with('success', 'Transaksi berhasil diupdate.');
})->name('admin.rentals.update');

Route::post('/admin/rentals/{id}/return', function ($id) {
    ensureAdmin();

    $rental = Rental::findOrFail((int) $id);

    $today = Carbon::now();
    $due = Carbon::parse($rental->tanggal_kembali_raw ?? $rental->tanggal_kembali);

    $lateDays = $today->gt($due) ? $due->diffInDays($today) : 0;
    $totalDenda = $lateDays * (int) ($rental->denda_per_hari ?? 10000);

    $rental->tanggal_kembali_real = $today->format('Y-m-d');
    $rental->total_denda = $totalDenda;
    $rental->status_transaksi = 'Dikembalikan';
    $rental->save();

    return redirect()->route('admin.rentals')->with(
        'success',
        'Barang berhasil dikembalikan. Denda: Rp ' . number_format($totalDenda, 0, ',', '.')
    );
})->name('admin.rentals.return');

Route::delete('/admin/rentals/{id}', function ($id) {
    ensureAdmin();

    $rental = Rental::findOrFail((int) $id);

    if ($rental->status_transaksi !== 'Dikembalikan') {
        $product = Product::find($rental->product_id);

        if ($product) {
            $product->unit = (int) $product->unit + (int) $rental->qty;
            $product->status = 'Ready';
            $product->save();
        }
    }

    $rental->delete();

    return redirect()->route('admin.rentals')
        ->with('success', 'Transaksi berhasil dihapus.');
})->name('admin.rentals.destroy');

Route::post('/admin/rentals/{id}/verify', function ($id) {
    ensureAdmin();

    $rental = Rental::findOrFail((int) $id);
    $rental->status_transaksi = 'Booking';
    $rental->save();

    return redirect()->route('admin.rentals')
        ->with('success', 'Pesanan berhasil diverifikasi.');
})->name('admin.rentals.verify');

Route::post('/admin/rentals/{id}/pickup', function ($id) {
    ensureAdmin();

    $rental = Rental::findOrFail((int) $id);
    $rental->status_transaksi = 'Diambil';
    $rental->tanggal_diambil = Carbon::now()->format('Y-m-d');
    $rental->save();

    return redirect()->route('admin.rentals')
        ->with('success', 'Barang berhasil ditandai sudah diambil pelanggan.');
})->name('admin.rentals.pickup');

/*
|--------------------------------------------------------------------------
| Admin Other Pages
|--------------------------------------------------------------------------
*/

Route::get('/admin/calendar', function () {
    ensureAdmin();
    return view('admin.calendar');
})->name('admin.calendar');

Route::get('/admin/reports', function () {
    ensureAdmin();

    $rentals = Rental::latest()->get()->toArray();
    $totalPendapatan = collect($rentals)->whereIn('status_pembayaran', ['Lunas', 'DP'])->sum('total_harga');
    $totalTransaksi = count($rentals);
    $pelangganAktif = collect($rentals)->pluck('user_id')->unique()->count();
    $produkDisewa = collect($rentals)->sum('qty');

    $reportRows = collect($rentals)
        ->groupBy(function ($item) {
            return isset($item['tanggal_pinjam_raw'])
                ? Carbon::parse($item['tanggal_pinjam_raw'])->translatedFormat('F')
                : 'Tanpa Bulan';
        })
        ->map(function ($items, $bulan) {
            return [
                'bulan' => $bulan,
                'pendapatan' => collect($items)->sum('total_harga'),
                'transaksi' => count($items),
                'produk' => collect($items)->sum('qty'),
            ];
        })
        ->values()
        ->all();

    return view('admin.reports', compact(
        'totalPendapatan',
        'totalTransaksi',
        'pelangganAktif',
        'produkDisewa',
        'reportRows'
    ));
})->name('admin.reports');

Route::get('/admin/settings', function () {
    ensureAdmin();
    return view('admin.settings');
})->name('admin.settings');

/*
|--------------------------------------------------------------------------
| Pelanggan
|--------------------------------------------------------------------------
*/

Route::get('/pelanggan/dashboard', function () {

    ensurePelanggan();

    $products = \App\Models\Product::latest()->take(6)->get();

    return view('pelanggan.dashboard', compact('products'));

})->name('pelanggan.dashboard');

Route::get('/pelanggan/produk', function () {
    ensurePelanggan();

    $query = \App\Models\Product::query();

    if (request('search')) {
        $query->where('nama_barang', 'like', '%' . request('search') . '%');
    }

    if (request('kategori')) {
        $query->where('jenis_barang', request('kategori'));
    }

    if (request('sort') == 'murah') {
        $query->orderBy('harga', 'asc');
    } elseif (request('sort') == 'mahal') {
        $query->orderBy('harga', 'desc');
    } elseif (request('sort') == 'stok') {
        $query->orderBy('unit', 'desc');
    } else {
        $query->latest();
    }

    $products = $query->get();

    return view('pelanggan.produk', compact('products'));
})->name('pelanggan.produk');

/*
|--------------------------------------------------------------------------
| Keranjang Pelanggan
|--------------------------------------------------------------------------
*/

Route::get('/pelanggan/keranjang', function () {
    ensurePelanggan();

    $cart = session('cart', []);

    return view('pelanggan.keranjang', compact('cart'));
})->name('pelanggan.keranjang');

Route::post('/pelanggan/keranjang/tambah', function (Request $request) {
    ensurePelanggan();

    $request->validate([
        'product_id' => 'required|numeric',
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        'qty' => 'required|numeric|min:1',
        'catatan' => 'nullable|string',
    ], [
        'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh lebih kecil dari tanggal pinjam.',
    ]);

    $product = Product::findOrFail((int) $request->product_id);

    if ((int) $product->unit < (int) $request->qty) {
    return redirect()->back()->withInput()->withErrors([
        'Stok produk tidak mencukupi.'
    ]);
}

    $cart = session('cart', []);

    $cart[] = [
        'product_id' => $product->id,
        'nama_barang' => $product->nama_barang,
        'harga_per_hari' => (int) $product->harga,
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'tanggal_kembali' => $request->tanggal_kembali,
        'qty' => (int) $request->qty,
        'catatan' => $request->catatan,
    ];

    session(['cart' => $cart]);

    return redirect()->route('pelanggan.keranjang')
        ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
})->name('pelanggan.keranjang.tambah');

Route::delete('/pelanggan/keranjang/{index}', function ($index) {
    ensurePelanggan();

    $cart = session('cart', []);

    if (isset($cart[$index])) {
        unset($cart[$index]);
        $cart = array_values($cart);
        session(['cart' => $cart]);
    }

    return redirect()->route('pelanggan.keranjang')
        ->with('success', 'Produk berhasil dihapus dari keranjang.');
})->name('pelanggan.keranjang.hapus');

Route::post('/pelanggan/keranjang/checkout', function (Request $request) {
    ensurePelanggan();

    $request->validate([
        'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $ktpPath = $request->file('foto_ktp')->store('ktp', 'public');

    $cart = session('cart', []);

    if (count($cart) === 0) {
        return redirect()->route('pelanggan.keranjang')
            ->withErrors(['Keranjang masih kosong.']);
    }

    $products = Product::all()->toArray();
    $rentals = Rental::latest()->get()->toArray();
    $users = session('admin_users', []);
    $userSession = session('user') ?? 'pelanggan@email.com';
    $users = session('admin_users', []);

$userExists = collect($users)->contains(function ($user) use ($userSession) {
    return ($user['email'] ?? '') === $userSession;
});

if (!$userExists) {
    $nextUserId = count($users) > 0 ? max(array_column($users, 'id')) + 1 : 1;

    $users[] = [
        'id' => $nextUserId,
        'kode_user' => 'USR' . str_pad($nextUserId, 3, '0', STR_PAD_LEFT),
        'nama_lengkap' => $matchingUser['nama_lengkap'] ?? $userSession,
        'email' => $userSession,
        'no_ktp' => '-',
        'no_telp' => '-',
        'no_wa' => '-',
        'jenis_kelamin' => '-',
        'alamat' => '-',
        'status' => 'Aktif',
    ];

    session(['admin_users' => $users]);
}

    foreach ($cart as $item) {
        $product = collect($products)->firstWhere('id', (int) $item['product_id']);

        if (!$product) {
            return redirect()->route('pelanggan.keranjang')
                ->withErrors(['Ada produk yang tidak ditemukan.']);
        }

        $qty = (int) $item['qty'];
        $stok = (int) ($product['unit'] ?? 0);

        if ($stok < $qty) {
            return redirect()->route('pelanggan.keranjang')
                ->withErrors(['Stok produk ' . $product['nama_barang'] . ' tidak mencukupi.']);
        }

        $start = Carbon::parse($item['tanggal_pinjam']);
        $end = Carbon::parse($item['tanggal_kembali']);
        $lama = max($start->diffInDays($end), 1);

        $nextId = count($rentals) > 0 ? max(array_column($rentals, 'id')) + 1 : 1;
        $kode = 'TRX' . str_pad((string) $nextId, 3, '0', STR_PAD_LEFT);

        $hargaPerHari = (int) ($product['harga'] ?? 0);
        $total = $hargaPerHari * $qty * $lama;

        $matchingUser = collect($users)->first(function ($user) use ($userSession) {
            return
             ($user['nama_lengkap'] ?? '') === $userSession
                || ($user['email'] ?? '') === $userSession;
        });

       $newRental = [
    'id' => $nextId,
    'kode_transaksi' => $kode,

    'user_id' => $matchingUser ? $matchingUser['id'] : null,
    'product_id' => (int) $product['id'],

    'nama_pelanggan' => $matchingUser['nama_lengkap'] ?? $userSession,
    'email' => $userSession,

    'nama_barang' => $product['nama_barang'] ?? '-',
    'qty' => $qty,

    'tanggal_pinjam' => $item['tanggal_pinjam'],
    'tanggal_kembali' => $item['tanggal_kembali'],
    'tanggal_pinjam_raw' => $item['tanggal_pinjam'],
    'tanggal_kembali_raw' => $item['tanggal_kembali'],
    'tanggal_kembali_real' => null,

    'harga_per_hari' => $hargaPerHari,
    'total_harga' => $total,

    'denda_per_hari' => 10000,
    'total_denda' => 0,

    'status_pembayaran' => 'Belum Bayar',
    'status_transaksi' => 'Menunggu Verifikasi',

    'catatan' => $item['catatan'] ?? null,
    'foto_ktp' => $ktpPath,
];
try {
    $productModel = Product::findOrFail((int) $product['id']);

    $productModel->unit = (int) $productModel->unit - $qty;
    $productModel->status = $productModel->unit > 0 ? 'Ready' : 'Disewa';
    $productModel->save();

} catch (\Exception $e) {
    return redirect()->route('pelanggan.keranjang')
        ->withErrors([$e->getMessage()]);
}

    Rental::create($newRental);
    }

    session(['admin_users' => $users]);
    session()->forget('cart');

    return redirect()->route('pelanggan.sewa')
        ->with('success', 'Checkout berhasil. Pesanan menunggu verifikasi admin.');
})->name('pelanggan.keranjang.checkout');

Route::get('/pelanggan/sewa', function () {
    ensurePelanggan();

    $customerName = session('user') ?? 'Pelanggan';
    $allRentals = collect(Rental::where('email', session('user'))->get()->toArray());

    $customerRentals = $allRentals->filter(function ($item) use ($customerName) {
        return ($item['nama_pelanggan'] ?? '') === $customerName
            || ($item['email'] ?? '') === $customerName;
    })->values();

    $rentals = $customerRentals->map(function ($item) {
        return [
            'id' => $item['id'] ?? 0,
            'invoice' => $item['kode_transaksi'] ?? '-',
            'produk' => $item['nama_barang'] ?? '-',
            'tanggal_pinjam' => $item['tanggal_pinjam'] ?? '-',
            'tanggal_kembali' => $item['tanggal_kembali'] ?? '-',
            'tanggal_pinjam_raw' => $item['tanggal_pinjam_raw'] ?? null,
            'tanggal_kembali_raw' => $item['tanggal_kembali_raw'] ?? null,
            'tanggal_kembali_real' => $item['tanggal_kembali_real'] ?? null,
            'qty' => $item['qty'] ?? 1,
            'harga_per_hari' => $item['harga_per_hari'] ?? 0,
            'harga' => $item['total_harga'] ?? 0,
            'denda' => $item['total_denda'] ?? 0,
            'status_pembayaran' => $item['status_pembayaran'] ?? 'Belum Bayar',
            'status' => $item['status_transaksi'] ?? 'Booking',
            'warna' => match ($item['status_transaksi'] ?? '') {
                'Booking' => 'blue',
                'Dikembalikan' => 'slate',
                'Menunggu Verifikasi' => 'yellow',
                default => 'soft',
            },
        ];
    })->all();

    return view('pelanggan.sewa', compact('rentals'));
})->name('pelanggan.sewa');

Route::get('/pelanggan/sewa/{id}/extend', function ($id) {
    ensurePelanggan();

    $rentals = collect(Rental::where('email', session('user'))->get()->toArray());
    $customer = session('user');

    $rental = $rentals->first(function ($item) use ($id, $customer) {
        return ($item['id'] ?? 0) == $id
            && (
                (($item['email'] ?? '') === $customer) ||
                (($item['nama_pelanggan'] ?? '') === $customer)
            );
    });

    if (!$rental) {
        abort(404);
    }

    if (($rental['status_transaksi'] ?? '') !== 'Booking') {
        return redirect()->route('pelanggan.sewa')->withErrors([
            'Hanya transaksi booking yang bisa diperpanjang.'
        ]);
    }
    $product = Product::find($rental['product_id'] ?? null);
    return view('pelanggan.sewa-extend', compact('rental', 'product'));
})->name('pelanggan.sewa.extend');

Route::post('/pelanggan/sewa/{id}/extend', function (Request $request, $id) {
    ensurePelanggan();

    $request->validate([
        'tanggal_kembali' => 'required|date',
    ]);

    $customer = session('user');

    $rental = Rental::where('id', (int) $id)
        ->where(function ($query) use ($customer) {
            $query->where('email', $customer)
                ->orWhere('nama_pelanggan', $customer);
        })
        ->firstOrFail();

    if ($rental->status_transaksi !== 'Booking') {
        return redirect()->back()->withErrors([
            'Hanya transaksi booking yang bisa diperpanjang.'
        ]);
    }

    $start = Carbon::parse($rental->tanggal_pinjam_raw ?? $rental->tanggal_pinjam);
    $oldEnd = Carbon::parse($rental->tanggal_kembali_raw ?? $rental->tanggal_kembali);
    $newEnd = Carbon::parse($request->tanggal_kembali);

    if ($newEnd->lte($oldEnd)) {
        return redirect()->back()->withErrors([
            'Tanggal baru harus lebih besar dari tanggal kembali lama.'
        ]);
    }

    $days = max($start->diffInDays($newEnd), 1);

    $rental->tanggal_kembali = $request->tanggal_kembali;
    $rental->total_harga = $days * (int) $rental->harga_per_hari * (int) $rental->qty;
    $rental->save();

    return redirect()->route('pelanggan.sewa')
        ->with('success', 'Perpanjangan sewa berhasil disimpan.');
})->name('pelanggan.sewa.extend.proses');

Route::get('/pelanggan/produk/{id}/sewa', function ($id) {
    ensurePelanggan();

    $product = Product::findOrFail((int) $id);

    return view('pelanggan.sewa-form', compact('product'));
})->name('pelanggan.sewa.form');

Route::get('/pelanggan/pembayaran', function () {
    ensurePelanggan();

    $customerName = session('user') ?? 'Pelanggan';
    $allRentals = collect(Rental::where('email', session('user'))->get()->toArray());

    $payments = $allRentals->filter(function ($item) use ($customerName) {
        return ($item['nama_pelanggan'] ?? '') === $customerName
            || ($item['email'] ?? '') === $customerName;
    })->map(function ($item) {
        return [
            'invoice' => $item['kode_transaksi'] ?? '-',
            'produk' => $item['nama_barang'] ?? '-',
            'tanggal' => $item['tanggal_pinjam'] ?? '-',
            'nominal' => $item['total_harga'] ?? 0,
            'status' => $item['status_pembayaran'] ?? 'Belum Bayar',
            'warna' => ($item['status_pembayaran'] ?? '') === 'Lunas' ? 'blue' : 'soft',
        ];
    })->values()->all();

    return view('pelanggan.pembayaran', compact('payments'));
})->name('pelanggan.pembayaran');

Route::get('/pelanggan/riwayat', function () {
    ensurePelanggan();

    $customerName = session('user') ?? 'Pelanggan';
    $allRentals = collect(Rental::where('email', session('user'))->get()->toArray());

    $histories = $allRentals->filter(function ($item) use ($customerName) {
        return ($item['nama_pelanggan'] ?? '') === $customerName
            || ($item['email'] ?? '') === $customerName;
    })->map(function ($item) {
        return [
            'produk' => $item['nama_barang'] ?? '-',
            'tanggal' => ($item['tanggal_pinjam'] ?? '-') . ' - ' . ($item['tanggal_kembali'] ?? '-'),
            'harga' => $item['total_harga'] ?? 0,
            'status' => $item['status_transaksi'] ?? '-',
        ];
    })->values()->all();

    return view('pelanggan.riwayat', compact('histories'));
})->name('pelanggan.riwayat');

Route::get('/pelanggan/profil', function () {
    ensurePelanggan();

    $profil = [
        'nama' => session('user') ?? 'Pelanggan LensCamp',
        'email' => session('user') ?? 'pelanggan@email.com',
        'no_wa' => '081234567890',
        'alamat' => 'Batam, Indonesia',
        'member_sejak' => 'Februari 2026',
        'status' => 'Terverifikasi',
    ];

    return view('pelanggan.profil', compact('profil'));
})->name('pelanggan.profil');

Route::post('/pelanggan/profil', function (Request $request) {
    ensurePelanggan();

    $request->validate([
        'nama' => 'required|string|max:100',
        'email' => 'required|email',
        'no_wa' => 'nullable|string|max:20',
        'alamat' => 'nullable|string',
    ]);

    session([
        'user' => $request->email,
    ]);

    return redirect()->route('pelanggan.profil')->with('success', 'Profil berhasil diperbarui.');
})->name('pelanggan.profil.update');

Route::get('/pelanggan/home', function () {
    return redirect()->route('home');
})->name('pelanggan.home');

Route::get('/pelanggan/hubungi-admin', function () {
    ensurePelanggan();

    return view('pelanggan.hubungi-admin');
})->name('pelanggan.hubungi-admin');

Route::post('/pelanggan/hubungi-admin', function (Request $request) {
    ensurePelanggan();

    $request->validate([
        'nama' => 'required',
        'email' => 'required|email',
        'subjek' => 'required',
        'pesan' => 'required',
    ]);

    session()->flash('success', 'Pesan berhasil dikirim ke admin!');

    return redirect()->route('pelanggan.hubungi-admin');
})->name('pelanggan.hubungi-admin.kirim');

Route::get('/gambar1deh', function () {
    return view('gambar1deh');
});

// update terbaru
