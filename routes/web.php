<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Helper
|--------------------------------------------------------------------------
*/
function syncRentalStock(array $products, ?array $oldRental, ?array $newRental): array
{
    $oldWasBooked = $oldRental && (($oldRental['status_transaksi'] ?? '') === 'Booking');
    $newIsBooked = $newRental && (($newRental['status_transaksi'] ?? '') === 'Booking');

    if ($oldWasBooked) {
        foreach ($products as &$product) {
            if ($product['id'] == ($oldRental['product_id'] ?? 0)) {
                $product['unit'] = (int) ($product['unit'] ?? 0) + (int) ($oldRental['qty'] ?? 0);
                $product['status'] = ((int) $product['unit'] > 0) ? 'Ready' : 'Disewa';
            }
        }
        unset($product);
    }

    if ($newIsBooked) {
        foreach ($products as &$product) {
            if ($product['id'] == ($newRental['product_id'] ?? 0)) {
                $stokSekarang = (int) ($product['unit'] ?? 0);
                $qtyBaru = (int) ($newRental['qty'] ?? 0);

                if ($stokSekarang < $qtyBaru) {
                    throw new \Exception('Stok barang tidak cukup untuk booking.');
                }

                $product['unit'] = $stokSekarang - $qtyBaru;
                $product['status'] = ((int) $product['unit'] > 0) ? 'Ready' : 'Disewa';
            }
        }
        unset($product);
    }

    return $products;
}

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================
// HALAMAN AWAL
// =========================
Route::get('/', function () {
    return redirect()->route('login');
})->name('root');


// =========================
// HALAMAN UMUM
// =========================
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/products', function () {
    return view('products');
})->name('products');

Route::get('/products/detail', function () {
    return view('products.detail');
})->name('products.detail');

// =========================
// LOGIN
// =========================
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'user_type' => 'required|in:admin,pelanggan',
        'email' => 'required',
        'password' => 'required',
    ]);

    session([
        'user' => $request->email,
        'role' => $request->user_type,
    ]);

    if ($request->user_type === 'admin') {
        return redirect()->route('dashboard.admin');
    }

    return redirect()->route('dashboard.pelanggan');
})->name('login.proses');


// =========================
// DAFTAR
// =========================
Route::get('/daftar', function () {
    return view('daftar');
})->name('daftar');

Route::post('/daftar', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
    ]);

    session([
        'user' => $request->email,
        'role' => 'pelanggan',
    ]);

    return redirect()->route('dashboard.pelanggan');
})->name('daftar.proses');


// =========================
// DASHBOARD ADMIN
// =========================
Route::get('/dashboard-admin', function () {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    return view('dashboard-admin');
})->name('dashboard.admin');


// =========================
// ADMIN USERS CRUD
// =========================
Route::get('/admin/users', function () {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $users = session('admin_users', [
        [
            'id' => 1,
            'kode_user' => 'USR001',
            'nama_lengkap' => 'Ahmad Nasrulloh',
            'no_ktp' => '3174010101010001',
            'no_telp' => '081234567890',
            'no_wa' => '081234567890',
            'tempat_lahir' => 'Medan',
            'tanggal_lahir' => '2000-01-10',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Mawar No. 1, Medan',
            'foto_ktp' => null,
            'rentals' => [],
        ],
        [
            'id' => 2,
            'kode_user' => 'USR002',
            'nama_lengkap' => 'Putri Audry',
            'no_ktp' => '3174010101010002',
            'no_telp' => '082222222222',
            'no_wa' => '082222222222',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2001-05-15',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Melati No. 2, Bandung',
            'foto_ktp' => null,
            'rentals' => [],
        ],
        [
            'id' => 3,
            'kode_user' => 'USR003',
            'nama_lengkap' => 'Budi Santoso',
            'no_ktp' => '3174010101010003',
            'no_telp' => '083333333333',
            'no_wa' => '083333333333',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1999-09-21',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Kenanga No. 3, Jakarta',
            'foto_ktp' => null,
            'rentals' => [],
        ],
    ]);

    session(['admin_users' => $users]);

    return view('admin.users', compact('users'));
})->name('admin.users');

Route::post('/admin/users/store', function (Request $request) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $request->validate([
        'kode_user' => 'required',
        'nama_lengkap' => 'required',
        'no_ktp' => 'required',
        'no_telp' => 'nullable',
        'no_wa' => 'nullable',
        'tempat_lahir' => 'nullable',
        'tanggal_lahir' => 'nullable',
        'jenis_kelamin' => 'nullable',
        'alamat' => 'nullable',
    ]);

    $users = session('admin_users', []);
    $nextId = count($users) > 0 ? max(array_column($users, 'id')) + 1 : 1;

    $users[] = [
        'id' => $nextId,
        'kode_user' => $request->kode_user,
        'nama_lengkap' => $request->nama_lengkap,
        'no_ktp' => $request->no_ktp,
        'no_telp' => $request->no_telp,
        'no_wa' => $request->no_wa,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
        'alamat' => $request->alamat,
        'foto_ktp' => null,
        'rentals' => [],
    ];

    session(['admin_users' => $users]);

    return redirect()->route('admin.users')->with('success', 'Data user berhasil ditambahkan.');
})->name('admin.users.store');

Route::get('/admin/users/{id}', function ($id) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $users = session('admin_users', []);
    $user = collect($users)->firstWhere('id', (int) $id);

    if (!$user) {
        abort(404);
    }

    return view('admin.user-detail', compact('user'));
})->name('admin.users.show');

Route::put('/admin/users/{id}', function (Request $request, $id) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $request->validate([
        'nama_lengkap' => 'required',
        'no_ktp' => 'required',
        'no_telp' => 'nullable',
        'no_wa' => 'nullable',
        'tempat_lahir' => 'nullable',
        'tanggal_lahir' => 'nullable',
        'jenis_kelamin' => 'nullable',
        'alamat' => 'nullable',
    ]);

    $users = session('admin_users', []);

    foreach ($users as &$user) {
        if ($user['id'] == $id) {
            $user['nama_lengkap'] = $request->nama_lengkap;
            $user['no_ktp'] = $request->no_ktp;
            $user['no_telp'] = $request->no_telp;
            $user['no_wa'] = $request->no_wa;
            $user['tempat_lahir'] = $request->tempat_lahir;
            $user['tanggal_lahir'] = $request->tanggal_lahir;
            $user['jenis_kelamin'] = $request->jenis_kelamin;
            $user['alamat'] = $request->alamat;
        }
    }

    unset($user);

    session(['admin_users' => $users]);

    return redirect()->route('admin.users')->with('success', 'Data user berhasil diupdate.');
})->name('admin.users.update');

Route::delete('/admin/users/{id}', function ($id) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $users = session('admin_users', []);
    $users = array_values(array_filter($users, fn ($user) => $user['id'] != $id));

    session(['admin_users' => $users]);

    return redirect()->route('admin.users')->with('success', 'Data user berhasil dihapus.');
})->name('admin.users.destroy');


// =========================
// ADMIN PRODUCTS CRUD
// =========================
Route::get('/admin/products', function () {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $products = session('admin_products', [
        [
            'id' => 1,
            'kode_barang' => '0002',
            'nama_barang' => 'Tas Slempang',
            'jenis_barang' => 'Tas',
            'deskripsi' => 'Tas untuk perlengkapan outdoor',
            'status' => 'Ready',
            'estimasi' => '1 /Hari',
            'harga' => 12000,
            'unit' => 10,
            'gambar' => '',
        ],
        [
            'id' => 2,
            'kode_barang' => '0003',
            'nama_barang' => 'Tenda 4 Orang',
            'jenis_barang' => 'Tenda',
            'deskripsi' => 'Tenda camping untuk kebutuhan outdoor',
            'status' => 'Ready',
            'estimasi' => '1 /Hari',
            'harga' => 100000,
            'unit' => 8,
            'gambar' => '',
        ],
        [
            'id' => 3,
            'kode_barang' => '0004',
            'nama_barang' => 'Tripod Kamera',
            'jenis_barang' => 'Aksesoris',
            'deskripsi' => 'Tripod stabil untuk hasil foto dan video',
            'status' => 'Ready',
            'estimasi' => '1 /Hari',
            'harga' => 55000,
            'unit' => 15,
            'gambar' => '',
        ],
    ]);

    session(['admin_products' => $products]);

    return view('admin.products', compact('products'));
})->name('admin.products');

Route::post('/admin/products/store', function (Request $request) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $request->validate([
        'kode_barang' => 'nullable',
        'nama_barang' => 'required',
        'jenis_barang' => 'nullable',
        'deskripsi' => 'required',
        'status' => 'nullable',
        'estimasi' => 'nullable',
        'harga' => 'required|numeric|min:0',
        'unit' => 'required|numeric|min:0',
        'gambar' => 'nullable',
    ]);

    $products = session('admin_products', []);
    $nextId = count($products) > 0 ? max(array_column($products, 'id')) + 1 : 1;

    $products[] = [
        'id' => $nextId,
        'kode_barang' => $request->kode_barang ?: str_pad((string) $nextId, 4, '0', STR_PAD_LEFT),
        'nama_barang' => $request->nama_barang,
        'jenis_barang' => $request->jenis_barang,
        'deskripsi' => $request->deskripsi,
        'status' => $request->status ?: 'Ready',
        'estimasi' => $request->estimasi ?: '1 /Hari',
        'harga' => (int) $request->harga,
        'unit' => (int) $request->unit,
        'gambar' => $request->gambar,
    ];

    session(['admin_products' => $products]);

    return redirect()->route('admin.products')->with('success', 'Barang berhasil ditambahkan.');
})->name('admin.products.store');

Route::put('/admin/products/{id}', function (Request $request, $id) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $request->validate([
        'kode_barang' => 'nullable',
        'nama_barang' => 'required',
        'jenis_barang' => 'nullable',
        'deskripsi' => 'required',
        'status' => 'nullable',
        'estimasi' => 'nullable',
        'harga' => 'required|numeric|min:0',
        'unit' => 'required|numeric|min:0',
        'gambar' => 'nullable',
    ]);

    $products = session('admin_products', []);

    foreach ($products as &$product) {
        if ($product['id'] == $id) {
            $product['kode_barang'] = $request->kode_barang;
            $product['nama_barang'] = $request->nama_barang;
            $product['jenis_barang'] = $request->jenis_barang;
            $product['deskripsi'] = $request->deskripsi;
            $product['status'] = $request->status ?: $product['status'];
            $product['estimasi'] = $request->estimasi ?: $product['estimasi'];
            $product['harga'] = (int) $request->harga;
            $product['unit'] = (int) $request->unit;
            $product['gambar'] = $request->gambar;
        }
    }

    unset($product);

    session(['admin_products' => $products]);

    return redirect()->route('admin.products')->with('success', 'Barang berhasil diupdate.');
})->name('admin.products.update');

Route::delete('/admin/products/{id}', function ($id) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $products = session('admin_products', []);
    $products = array_values(array_filter($products, fn ($product) => $product['id'] != $id));

    session(['admin_products' => $products]);

    return redirect()->route('admin.products')->with('success', 'Barang berhasil dihapus.');
})->name('admin.products.destroy');


// =========================
// ADMIN PRODUCT SETTINGS
// =========================
Route::get('/admin/product-settings', function () {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $productSettings = session('product_settings', [
        'jenis_barang' => [
            ['id' => 1, 'nama' => 'Tenda'],
            ['id' => 2, 'nama' => 'Alat masak'],
            ['id' => 3, 'nama' => 'P3K'],
            ['id' => 4, 'nama' => 'Kompas'],
            ['id' => 5, 'nama' => 'Jas hujan'],
            ['id' => 6, 'nama' => 'Tas'],
            ['id' => 7, 'nama' => 'Pakaian'],
        ],
        'estimasi' => [
            ['id' => 1, 'nama' => '1 /Hari'],
            ['id' => 2, 'nama' => '2 /Hari'],
            ['id' => 3, 'nama' => '6 /Hari'],
            ['id' => 4, 'nama' => '12 /Hari'],
            ['id' => 5, 'nama' => '20 /Hari'],
            ['id' => 6, 'nama' => '30 /Hari'],
        ],
        'status' => [
            ['id' => 1, 'nama' => 'Ready'],
            ['id' => 2, 'nama' => 'Pending'],
            ['id' => 3, 'nama' => 'Disewa'],
        ],
    ]);

    session(['product_settings' => $productSettings]);

    return view('admin.product-settings', compact('productSettings'));
})->name('admin.product.settings');

Route::post('/admin/product-settings/{type}/store', function (Request $request, $type) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

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

    $nextId = count($settings[$type]) > 0 ? max(array_column($settings[$type], 'id')) + 1 : 1;

    $settings[$type][] = [
        'id' => $nextId,
        'nama' => $request->nama,
    ];

    session(['product_settings' => $settings]);

    return redirect()->route('admin.product.settings')->with('success', 'Data berhasil ditambahkan.');
})->name('admin.product.settings.store');

Route::put('/admin/product-settings/{type}/{id}', function (Request $request, $type, $id) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

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
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $allowed = ['jenis_barang', 'estimasi', 'status'];
    if (!in_array($type, $allowed)) {
        abort(404);
    }

    $settings = session('product_settings', [
        'jenis_barang' => [],
        'estimasi' => [],
        'status' => [],
    ]);

    $settings[$type] = array_values(array_filter($settings[$type], fn ($item) => $item['id'] != $id));

    session(['product_settings' => $settings]);

    return redirect()->route('admin.product.settings')->with('success', 'Data berhasil dihapus.');
})->name('admin.product.settings.destroy');


// =========================
// ADMIN RENTALS CRUD
// =========================
Route::get('/admin/rentals', function (Request $request) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $users = session('admin_users', []);
    $products = session('admin_products', []);

    $rentals = session('admin_rentals', [
        [
            'id' => 1,
            'kode_transaksi' => 'TRX001',
            'user_id' => 2,
            'product_id' => 1,
            'nama_pelanggan' => 'Putri Audry',
            'nama_barang' => 'Tas Slempang',
            'qty' => 1,
            'tanggal_pinjam' => '11-04-2026',
            'tanggal_kembali' => '13-04-2026',
            'tanggal_pinjam_raw' => '2026-04-11',
            'tanggal_kembali_raw' => '2026-04-13',
            'harga_per_hari' => 12000,
            'total_harga' => 24000,
            'status_pembayaran' => 'Lunas',
            'status_transaksi' => 'Booking',
            'catatan' => '',
        ],
        [
            'id' => 2,
            'kode_transaksi' => 'TRX002',
            'user_id' => 3,
            'product_id' => 2,
            'nama_pelanggan' => 'Budi Santoso',
            'nama_barang' => 'Tenda 4 Orang',
            'qty' => 1,
            'tanggal_pinjam' => '10-04-2026',
            'tanggal_kembali' => '12-04-2026',
            'tanggal_pinjam_raw' => '2026-04-10',
            'tanggal_kembali_raw' => '2026-04-12',
            'harga_per_hari' => 100000,
            'total_harga' => 200000,
            'status_pembayaran' => 'DP',
            'status_transaksi' => 'Booking',
            'catatan' => '',
        ],
        [
            'id' => 3,
            'kode_transaksi' => 'TRX003',
            'user_id' => 1,
            'product_id' => 3,
            'nama_pelanggan' => 'Ahmad Nasrulloh',
            'nama_barang' => 'Tripod Kamera',
            'qty' => 1,
            'tanggal_pinjam' => '08-04-2026',
            'tanggal_kembali' => '09-04-2026',
            'tanggal_pinjam_raw' => '2026-04-08',
            'tanggal_kembali_raw' => '2026-04-09',
            'harga_per_hari' => 55000,
            'total_harga' => 55000,
            'status_pembayaran' => 'Lunas',
            'status_transaksi' => 'Dikembalikan',
            'catatan' => '',
        ],
    ]);

    session(['admin_rentals' => $rentals]);

    $status = $request->query('status', 'semua');
    if ($status !== 'semua') {
        $rentals = array_values(array_filter($rentals, fn ($item) => ($item['status_transaksi'] ?? '') === $status));
    }

    return view('admin.rentals', compact('rentals', 'users', 'products'));
})->name('admin.rentals');

Route::post('/admin/rentals/store', function (Request $request) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

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
    $products = session('admin_products', []);
    $rentals = session('admin_rentals', []);

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
        'nama_pelanggan' => $user['nama_lengkap'] ?? $user['nama'] ?? '-',
        'nama_barang' => $product['nama_barang'] ?? '-',
        'qty' => $qty,
        'tanggal_pinjam' => $start->format('d-m-Y'),
        'tanggal_kembali' => $end->format('d-m-Y'),
        'tanggal_pinjam_raw' => $request->tanggal_pinjam,
        'tanggal_kembali_raw' => $request->tanggal_kembali,
        'harga_per_hari' => $hargaPerHari,
        'total_harga' => $total,
        'status_pembayaran' => $request->status_pembayaran,
        'status_transaksi' => $request->status_transaksi,
        'catatan' => $request->catatan,
    ];

    try {
        $products = syncRentalStock($products, null, $newRental);
    } catch (\Exception $e) {
        return redirect()->route('admin.rentals')->withErrors([$e->getMessage()]);
    }

    $rentals[] = $newRental;

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

    session(['admin_products' => $products]);
    session(['admin_rentals' => $rentals]);
    session(['admin_users' => $users]);

    return redirect()->route('admin.rentals')->with('success', 'Transaksi berhasil ditambahkan.');
})->name('admin.rentals.store');

Route::put('/admin/rentals/{id}', function (Request $request, $id) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $request->validate([
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        'qty' => 'required|numeric|min:1',
        'status_pembayaran' => 'required',
        'status_transaksi' => 'required|in:Booking,Dikembalikan',
    ]);

    $rentals = session('admin_rentals', []);
    $products = session('admin_products', []);
    $users = session('admin_users', []);

    foreach ($rentals as $index => $rental) {
        if ($rental['id'] == $id) {
            $start = Carbon::parse($request->tanggal_pinjam);
            $end = Carbon::parse($request->tanggal_kembali);
            $lama = max($start->diffInDays($end), 1);

            $qty = (int) $request->qty;
            $hargaPerHari = (int) ($rental['harga_per_hari'] ?? 0);
            $total = $hargaPerHari * $qty * $lama;

            $oldRental = $rental;

            $newRental = $rental;
            $newRental['tanggal_pinjam'] = $start->format('d-m-Y');
            $newRental['tanggal_kembali'] = $end->format('d-m-Y');
            $newRental['tanggal_pinjam_raw'] = $request->tanggal_pinjam;
            $newRental['tanggal_kembali_raw'] = $request->tanggal_kembali;
            $newRental['qty'] = $qty;
            $newRental['status_pembayaran'] = $request->status_pembayaran;
            $newRental['status_transaksi'] = $request->status_transaksi;
            $newRental['total_harga'] = $total;

            try {
                $products = syncRentalStock($products, $oldRental, $newRental);
            } catch (\Exception $e) {
                return redirect()->route('admin.rentals')->withErrors([$e->getMessage()]);
            }

            $rentals[$index] = $newRental;

            foreach ($users as &$u) {
                if ($u['id'] == $newRental['user_id']) {
                    $u['rentals'] = array_values(array_filter(
                        $u['rentals'] ?? [],
                        fn ($item) => !(
                            ($item['produk'] ?? '') === ($oldRental['nama_barang'] ?? '') &&
                            ($item['tanggal_sewa'] ?? '') === ($oldRental['tanggal_pinjam'] ?? '')
                        )
                    ));

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

            break;
        }
    }

    session(['admin_products' => $products]);
    session(['admin_rentals' => $rentals]);
    session(['admin_users' => $users]);

    return redirect()->route('admin.rentals')->with('success', 'Transaksi berhasil diupdate.');
})->name('admin.rentals.update');

Route::delete('/admin/rentals/{id}', function ($id) {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    $rentals = session('admin_rentals', []);
    $products = session('admin_products', []);
    $users = session('admin_users', []);

    foreach ($rentals as $key => $rental) {
        if ($rental['id'] == $id) {
            try {
                $products = syncRentalStock($products, $rental, null);
            } catch (\Exception $e) {
                return redirect()->route('admin.rentals')->withErrors([$e->getMessage()]);
            }

            foreach ($users as &$u) {
                if ($u['id'] == $rental['user_id']) {
                    $u['rentals'] = array_values(array_filter(
                        $u['rentals'] ?? [],
                        fn ($item) => !(
                            ($item['produk'] ?? '') === ($rental['nama_barang'] ?? '') &&
                            ($item['tanggal_sewa'] ?? '') === ($rental['tanggal_pinjam'] ?? '')
                        )
                    ));
                }
            }
            unset($u);

            unset($rentals[$key]);
            break;
        }
    }

    $rentals = array_values($rentals);

    session(['admin_products' => $products]);
    session(['admin_rentals' => $rentals]);
    session(['admin_users' => $users]);

    return redirect()->route('admin.rentals')->with('success', 'Transaksi berhasil dihapus.');
})->name('admin.rentals.destroy');


// =========================
// ADMIN HALAMAN LAIN
// =========================
Route::get('/admin/reports', function () {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    return view('admin.reports');
})->name('admin.reports');

Route::get('/admin/settings', function () {
    if (!session()->has('role') || session('role') !== 'admin') {
        return redirect()->route('login');
    }

    return view('admin.settings');
})->name('admin.settings');


// =========================
// DASHBOARD PELANGGAN
// =========================
Route::get('/dashboard-pelanggan', function () {
    if (!session()->has('role') || session('role') !== 'pelanggan') {
        return redirect()->route('login');
    }

    return view('dashboard-pelanggan');
})->name('dashboard.pelanggan');


// =========================
// LOGOUT
// =========================
Route::get('/logout', function () {
    session()->flush();
    return redirect()->route('login');
})->name('logout');