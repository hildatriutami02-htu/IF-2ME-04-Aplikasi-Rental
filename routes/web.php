<?php

use App\Http\Controllers\UserController;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

if (!function_exists('syncRentalStock')) {
    function syncRentalStock(array $products, ?array $oldRental, ?array $newRental): array
    {
        $oldWasBooked = $oldRental && (($oldRental['status_transaksi'] ?? '') === 'Booking');
        $newIsBooked = $newRental && (($newRental['status_transaksi'] ?? '') === 'Booking');

        if ($oldWasBooked) {
            foreach ($products as &$product) {
                if (($product['id'] ?? 0) == ($oldRental['product_id'] ?? 0)) {
                    $product['unit'] = (int) ($product['unit'] ?? 0) + (int) ($oldRental['qty'] ?? 0);
                    $product['status'] = ((int) $product['unit'] > 0) ? 'Ready' : 'Disewa';
                }
            }
            unset($product);
        }

        if ($newIsBooked) {
            foreach ($products as &$product) {
                if (($product['id'] ?? 0) == ($newRental['product_id'] ?? 0)) {
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
}

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
    return redirect()->route('login');
})->name('root');

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/home', function () {
    $products = Product::latest()->get();

    $isLoggedIn = session()->has('role');
    $isPelanggan = session('role') === 'pelanggan';

    $customerRentals = collect();
    $paymentHistory = collect();
    $pickupReminder = null;

    if ($isPelanggan) {
        $customerName = session('user') ?? 'Pelanggan';
        $rentals = collect(session('admin_rentals', []));

        $customerRentals = $rentals->filter(function ($item) use ($customerName) {
            return ($item['nama_pelanggan'] ?? '') === $customerName
                || ($item['email'] ?? '') === $customerName;
        })->values();

        $paymentHistory = $customerRentals->map(function ($item) {
            return [
                'invoice' => $item['kode_transaksi'] ?? '-',
                'produk' => $item['nama_barang'] ?? '-',
                'tanggal' => $item['tanggal_pinjam'] ?? '-',
                'nominal' => $item['total_harga'] ?? 0,
                'status' => $item['status_pembayaran'] ?? 'Belum Bayar',
            ];
        });

        $pickupReminder = $customerRentals->first();
    }

    return view('home', compact(
        'products',
        'isLoggedIn',
        'isPelanggan',
        'customerRentals',
        'paymentHistory',
        'pickupReminder'
    ));
})->name('home');

Route::get('/about', fn () => view('about'))->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');
Route::get('/products', fn () => view('products'))->name('products');
Route::get('/products/detail', fn () => view('products.detail'))->name('products.detail');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login-pilih');
})->name('login');

Route::get('/login/admin', function () {
    return view('auth.login-admin');
})->name('login.admin');

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

Route::get('/login/pelanggan', function () {
    return view('auth.login-pelanggan');
})->name('login.pelanggan');

Route::post('/login/pelanggan', function (Request $request) {
    $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);

    session([
        'user' => $request->email,
        'role' => 'pelanggan',
    ]);

    return redirect()->route('home');
})->name('login.pelanggan.proses');

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

    return redirect()->route('home');
})->name('daftar.proses');

Route::get('/logout', function () {
    session()->flush();
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
    $products = Product::all()->toArray();
    $rentals = session('admin_rentals', []);

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

    $products = Product::latest()->get();

    return view('admin.products', compact('products'));
})->name('admin.products');

Route::post('/admin/products/store', function (Request $request) {
    ensureAdmin();

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

    Product::create([
        'kode_barang' => $request->kode_barang,
        'nama_barang' => $request->nama_barang,
        'jenis_barang' => $request->jenis_barang,
        'deskripsi' => $request->deskripsi,
        'status' => $request->status ?? 'Ready',
        'estimasi' => $request->estimasi,
        'harga' => $request->harga,
        'unit' => $request->unit,
        'gambar' => $request->gambar,
    ]);

    return redirect()->route('admin.products')->with('success', 'Barang berhasil ditambahkan.');
})->name('admin.products.store');

Route::put('/admin/products/{id}', function (Request $request, $id) {
    ensureAdmin();

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

    $product = Product::findOrFail($id);

    $product->update([
        'kode_barang' => $request->kode_barang,
        'nama_barang' => $request->nama_barang,
        'jenis_barang' => $request->jenis_barang,
        'deskripsi' => $request->deskripsi,
        'status' => $request->status ?? $product->status,
        'estimasi' => $request->estimasi,
        'harga' => $request->harga,
        'unit' => $request->unit,
        'gambar' => $request->gambar,
    ]);

    return redirect()->route('admin.products')->with('success', 'Barang berhasil diupdate.');
})->name('admin.products.update');

Route::delete('/admin/products/{id}', function ($id) {
    ensureAdmin();

    Product::findOrFail($id)->delete();

    return redirect()->route('admin.products')->with('success', 'Barang berhasil dihapus.');
})->name('admin.products.destroy');

/*
|--------------------------------------------------------------------------
| Admin Product Settings
|--------------------------------------------------------------------------
*/

Route::get('/admin/product-settings', function () {
    ensureAdmin();

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

    $nextId = count($settings[$type]) > 0 ? max(array_column($settings[$type], 'id')) + 1 : 1;

    $settings[$type][] = [
        'id' => $nextId,
        'nama' => $request->nama,
    ];

    session(['product_settings' => $settings]);

    return redirect()->route('admin.product.settings')->with('success', 'Data berhasil ditambahkan.');
})->name('admin.product.settings.store');

Route::put('/admin/product-settings/{type}/{id}', function (Request $request, $type, $id) {
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

    $users = session('admin_users', []);

    if (!session()->has('admin_rentals')) {
        session([
            'admin_rentals' => [
                [
                    'id' => 1,
                    'kode_transaksi' => 'TRX001',
                    'user_id' => 2,
                    'product_id' => 1,
                    'nama_pelanggan' => 'putri@example.com',
                    'email' => 'putri@example.com',
                    'nama_barang' => 'Tas Slempang',
                    'qty' => 1,
                    'tanggal_pinjam' => '11-04-2026',
                    'tanggal_kembali' => '13-04-2026',
                    'tanggal_pinjam_raw' => '2026-04-11',
                    'tanggal_kembali_raw' => '2026-04-13',
                    'tanggal_kembali_real' => null,
                    'harga_per_hari' => 12000,
                    'total_harga' => 24000,
                    'denda_per_hari' => 10000,
                    'total_denda' => 0,
                    'status_pembayaran' => 'Lunas',
                    'status_transaksi' => 'Booking',
                    'catatan' => '',
                ],
                [
                    'id' => 2,
                    'kode_transaksi' => 'TRX002',
                    'user_id' => 3,
                    'product_id' => 2,
                    'nama_pelanggan' => 'budi@example.com',
                    'email' => 'budi@example.com',
                    'nama_barang' => 'Tenda 4 Orang',
                    'qty' => 1,
                    'tanggal_pinjam' => '10-04-2026',
                    'tanggal_kembali' => '12-04-2026',
                    'tanggal_pinjam_raw' => '2026-04-10',
                    'tanggal_kembali_raw' => '2026-04-12',
                    'tanggal_kembali_real' => null,
                    'harga_per_hari' => 100000,
                    'total_harga' => 200000,
                    'denda_per_hari' => 10000,
                    'total_denda' => 0,
                    'status_pembayaran' => 'DP',
                    'status_transaksi' => 'Booking',
                    'catatan' => '',
                ],
                [
                    'id' => 3,
                    'kode_transaksi' => 'TRX003',
                    'user_id' => 1,
                    'product_id' => 3,
                    'nama_pelanggan' => 'ahmad@example.com',
                    'email' => 'ahmad@example.com',
                    'nama_barang' => 'Tripod Kamera',
                    'qty' => 1,
                    'tanggal_pinjam' => '08-04-2026',
                    'tanggal_kembali' => '09-04-2026',
                    'tanggal_pinjam_raw' => '2026-04-08',
                    'tanggal_kembali_raw' => '2026-04-09',
                    'tanggal_kembali_real' => '09-04-2026',
                    'harga_per_hari' => 55000,
                    'total_harga' => 55000,
                    'denda_per_hari' => 10000,
                    'total_denda' => 0,
                    'status_pembayaran' => 'Lunas',
                    'status_transaksi' => 'Dikembalikan',
                    'catatan' => '',
                ],
            ]
        ]);
    }

    $products = Product::all()->toArray();
    $rentals = session('admin_rentals', []);

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

    $rentals = session('admin_rentals', []);
    $rental = collect($rentals)->firstWhere('id', (int) $id);

    if (!$rental) {
        abort(404);
    }

    return view('admin.rental-detail', compact('rental'));
})->name('admin.rentals.show');

Route::get('/admin/rentals/{id}/edit', function ($id) {
    ensureAdmin();

    $rentals = session('admin_rentals', []);
    $users = session('admin_users', []);
    $products = Product::all()->toArray();

    $rental = collect($rentals)->firstWhere('id', (int) $id);

    if (!$rental) {
        abort(404);
    }

    return view('admin.rental-edit', compact('rental', 'users', 'products'));
})->name('admin.rentals.edit');

Route::get('/admin/rentals/{id}/extend', function ($id) {
    ensureAdmin();

    $rentals = session('admin_rentals', []);
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

    $rentals = session('admin_rentals', []);

    foreach ($rentals as &$rental) {
        if ($rental['id'] == $id) {
            $start = Carbon::parse($rental['tanggal_pinjam_raw']);
            $end = Carbon::parse($request->tanggal_kembali);

            if ($end->lt($start)) {
                return redirect()->back()->withErrors([
                    'Tanggal kembali baru tidak boleh lebih kecil dari tanggal pinjam.'
                ]);
            }

            $days = max($start->diffInDays($end), 1);
            $total = $days * (int) ($rental['harga_per_hari'] ?? 0) * (int) ($rental['qty'] ?? 1);

            $rental['tanggal_kembali_raw'] = $request->tanggal_kembali;
            $rental['tanggal_kembali'] = $end->format('d-m-Y');
            $rental['total_harga'] = $total;

            break;
        }
    }
    unset($rental);

    session(['admin_rentals' => $rentals]);

    return redirect()->route('admin.rentals')
        ->with('success', 'Sewa berhasil diperpanjang.');
})->name('admin.rentals.extend.proses');

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
    $products = Product::all()->toArray();
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
        $updatedProducts = syncRentalStock($products, null, $newRental);

        foreach ($updatedProducts as $updatedProduct) {
            Product::where('id', $updatedProduct['id'])->update([
                'unit' => $updatedProduct['unit'],
                'status' => $updatedProduct['status'],
            ]);
        }
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

    session(['admin_rentals' => $rentals]);
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
        'status_transaksi' => 'required|in:Booking,Dikembalikan',
    ]);

    $rentals = session('admin_rentals', []);
    $products = Product::all()->toArray();
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
                $updatedProducts = syncRentalStock($products, $oldRental, $newRental);

                foreach ($updatedProducts as $updatedProduct) {
                    Product::where('id', $updatedProduct['id'])->update([
                        'unit' => $updatedProduct['unit'],
                        'status' => $updatedProduct['status'],
                    ]);
                }
            } catch (\Exception $e) {
                return redirect()->route('admin.rentals')->withErrors([$e->getMessage()]);
            }

            $rentals[$index] = $newRental;

            foreach ($users as &$u) {
                if ($u['id'] == $newRental['user_id']) {
                    $u['rentals'] = array_values(array_filter(
                        $u['rentals'] ?? [],
                        fn ($item) => !(($item['produk'] ?? '') === ($oldRental['nama_barang'] ?? '') && ($item['tanggal_sewa'] ?? '') === ($oldRental['tanggal_pinjam'] ?? ''))
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

    session(['admin_rentals' => array_values($rentals)]);
    session(['admin_users' => $users]);

    return redirect()->route('admin.rentals')->with('success', 'Transaksi berhasil diupdate.');
})->name('admin.rentals.update');

Route::post('/admin/rentals/{id}/return', function ($id) {
    ensureAdmin();

    $rentals = session('admin_rentals', []);
    $products = Product::all()->toArray();
    $totalDenda = 0;

    foreach ($rentals as &$rental) {
        if ($rental['id'] == $id) {
            $today = Carbon::now();
            $due = Carbon::parse($rental['tanggal_kembali_raw']);

            $lateDays = $today->gt($due) ? $due->diffInDays($today) : 0;
            $dendaPerHari = (int) ($rental['denda_per_hari'] ?? 10000);
            $totalDenda = $lateDays * $dendaPerHari;

            $rental['tanggal_kembali_real'] = $today->format('d-m-Y');
            $rental['total_denda'] = $totalDenda;
            $rental['status_transaksi'] = 'Dikembalikan';

            try {
                $updatedProducts = syncRentalStock($products, $rental, null);

                foreach ($updatedProducts as $updatedProduct) {
                    Product::where('id', $updatedProduct['id'])->update([
                        'unit' => $updatedProduct['unit'],
                        'status' => $updatedProduct['status'],
                    ]);
                }
            } catch (\Exception $e) {
                return redirect()->route('admin.rentals')->withErrors([$e->getMessage()]);
            }

            break;
        }
    }
    unset($rental);

    session(['admin_rentals' => $rentals]);

    return redirect()->route('admin.rentals')->with(
        'success',
        'Barang berhasil dikembalikan. Denda: Rp ' . number_format($totalDenda, 0, ',', '.')
    );
})->name('admin.rentals.return');

Route::delete('/admin/rentals/{id}', function ($id) {
    ensureAdmin();

    $rentals = session('admin_rentals', []);
    $products = Product::all()->toArray();
    $users = session('admin_users', []);

    foreach ($rentals as $key => $rental) {
        if ($rental['id'] == $id) {
            try {
                $updatedProducts = syncRentalStock($products, $rental, null);

                foreach ($updatedProducts as $updatedProduct) {
                    Product::where('id', $updatedProduct['id'])->update([
                        'unit' => $updatedProduct['unit'],
                        'status' => $updatedProduct['status'],
                    ]);
                }
            } catch (\Exception $e) {
                return redirect()->route('admin.rentals')->withErrors([$e->getMessage()]);
            }

            foreach ($users as &$u) {
                if ($u['id'] == $rental['user_id']) {
                    $u['rentals'] = array_values(array_filter(
                        $u['rentals'] ?? [],
                        fn ($item) => !(($item['produk'] ?? '') === ($rental['nama_barang'] ?? '') && ($item['tanggal_sewa'] ?? '') === ($rental['tanggal_pinjam'] ?? ''))
                    ));
                }
            }
            unset($u);

            unset($rentals[$key]);
            break;
        }
    }

    $rentals = array_values($rentals);

    session(['admin_rentals' => $rentals]);
    session(['admin_users' => $users]);

    return redirect()->route('admin.rentals')->with('success', 'Transaksi berhasil dihapus.');
})->name('admin.rentals.destroy');

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

    $rentals = session('admin_rentals', []);
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
    return view('pelanggan.dashboard');
})->name('pelanggan.dashboard');

Route::get('/pelanggan/produk', function () {
    ensurePelanggan();

    $products = Product::latest()->get()->map(function ($item) {
        return [
            'id' => $item->id,
            'nama' => $item->nama_barang ?? '-',
            'kategori' => $item->jenis_barang ?? '-',
            'harga' => $item->harga ?? 0,
            'stok' => $item->unit ?? 0,
            'deskripsi' => $item->deskripsi ?? '-',
            'status' => $item->status ?? 'Ready',
            'gambar' => $item->gambar ?? null,
        ];
    })->all();

    return view('pelanggan.produk', compact('products'));
})->name('pelanggan.produk');

Route::get('/pelanggan/sewa', function () {
    ensurePelanggan();

    $customerName = session('user') ?? 'Pelanggan';
    $allRentals = collect(session('admin_rentals', []));

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
                default => 'soft',
            },
        ];
    })->all();

    return view('pelanggan.sewa', compact('rentals'));
})->name('pelanggan.sewa');

Route::get('/pelanggan/sewa/{id}/extend', function ($id) {
    ensurePelanggan();

    $rentals = collect(session('admin_rentals', []));
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

    return view('pelanggan.sewa-extend', compact('rental'));
})->name('pelanggan.sewa.extend');

Route::post('/pelanggan/sewa/{id}/extend', function (Request $request, $id) {
    ensurePelanggan();

    $request->validate([
        'tanggal_kembali' => 'required|date',
    ]);

    $rentals = session('admin_rentals', []);
    $customer = session('user');

    foreach ($rentals as &$rental) {
        if (
            ($rental['id'] ?? 0) == $id &&
            (
                (($rental['email'] ?? '') === $customer) ||
                (($rental['nama_pelanggan'] ?? '') === $customer)
            )
        ) {
            if (($rental['status_transaksi'] ?? '') !== 'Booking') {
                return redirect()->back()->withErrors([
                    'Hanya transaksi booking yang bisa diperpanjang.'
                ]);
            }

            $start = Carbon::parse($rental['tanggal_pinjam_raw']);
            $oldEnd = Carbon::parse($rental['tanggal_kembali_raw']);
            $newEnd = Carbon::parse($request->tanggal_kembali);

            if ($newEnd->lte($oldEnd)) {
                return redirect()->back()->withErrors([
                    'Tanggal baru harus lebih besar dari tanggal kembali lama.'
                ]);
            }

            $days = max($start->diffInDays($newEnd), 1);
            $total = $days * (int) ($rental['harga_per_hari'] ?? 0) * (int) ($rental['qty'] ?? 1);

            $rental['tanggal_kembali_raw'] = $request->tanggal_kembali;
            $rental['tanggal_kembali'] = $newEnd->format('d-m-Y');
            $rental['total_harga'] = $total;

            break;
        }
    }
    unset($rental);

    session(['admin_rentals' => $rentals]);

    return redirect()->route('pelanggan.sewa')->with('success', 'Perpanjangan sewa berhasil disimpan.');
})->name('pelanggan.sewa.extend.proses');

Route::get('/pelanggan/produk/{id}/sewa', function ($id) {
    ensurePelanggan();

    $product = Product::findOrFail((int) $id);

    return view('pelanggan.sewa-form', compact('product'));
})->name('pelanggan.sewa.form');

Route::post('/pelanggan/produk/{id}/sewa', function (Request $request, $id) {
    ensurePelanggan();

    $request->validate([
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        'qty' => 'required|numeric|min:1',
        'catatan' => 'nullable|string',
    ], [
        'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh lebih kecil dari tanggal pinjam.',
    ]);

    $products = Product::all()->toArray();
    $rentals = session('admin_rentals', []);
    $users = session('admin_users', []);

    $product = collect($products)->firstWhere('id', (int) $id);

    if (!$product) {
        return redirect()->back()->withInput()->withErrors(['Produk tidak ditemukan.']);
    }

    $qty = (int) $request->qty;
    $stok = (int) ($product['unit'] ?? 0);

    if ($stok < $qty) {
        return redirect()->back()->withInput()->withErrors(['Stok produk tidak mencukupi.']);
    }

    $start = Carbon::parse($request->tanggal_pinjam);
    $end = Carbon::parse($request->tanggal_kembali);
    $lama = max($start->diffInDays($end), 1);

    $nextId = count($rentals) > 0 ? max(array_column($rentals, 'id')) + 1 : 1;
    $kode = 'TRX' . str_pad((string) $nextId, 3, '0', STR_PAD_LEFT);

    $hargaPerHari = (int) ($product['harga'] ?? 0);
    $total = $hargaPerHari * $qty * $lama;

    $userSession = session('user') ?? 'pelanggan@email.com';

    $matchingUser = collect($users)->first(function ($item) use ($userSession) {
        return ($item['nama_lengkap'] ?? '') === $userSession
            || ($item['email'] ?? '') === $userSession;
    });

    $newRental = [
        'id' => $nextId,
        'kode_transaksi' => $kode,
        'user_id' => $matchingUser['id'] ?? 0,
        'product_id' => (int) $id,
        'nama_pelanggan' => $userSession,
        'email' => $userSession,
        'nama_barang' => $product['nama_barang'] ?? '-',
        'qty' => $qty,
        'tanggal_pinjam' => $start->format('d M Y'),
        'tanggal_kembali' => $end->format('d M Y'),
        'tanggal_pinjam_raw' => $request->tanggal_pinjam,
        'tanggal_kembali_raw' => $request->tanggal_kembali,
        'tanggal_kembali_real' => null,
        'harga_per_hari' => $hargaPerHari,
        'total_harga' => $total,
        'denda_per_hari' => 10000,
        'total_denda' => 0,
        'status_pembayaran' => 'Belum Bayar',
        'status_transaksi' => 'Booking',
        'catatan' => $request->catatan,
    ];

    try {
        $updatedProducts = syncRentalStock($products, null, $newRental);

        foreach ($updatedProducts as $updatedProduct) {
            Product::where('id', $updatedProduct['id'])->update([
                'unit' => $updatedProduct['unit'],
                'status' => $updatedProduct['status'],
            ]);
        }
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
    }

    $rentals[] = $newRental;

    session(['admin_rentals' => $rentals]);
    session(['admin_users' => $users]);

    return redirect()->route('pelanggan.sewa')->with('success', 'Pesanan sewa berhasil dibuat.');
})->name('pelanggan.sewa.store');

Route::get('/pelanggan/pembayaran', function () {
    ensurePelanggan();

    $customerName = session('user') ?? 'Pelanggan';
    $rentals = collect(session('admin_rentals', []));

    $payments = $rentals->filter(function ($item) use ($customerName) {
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
    $rentals = collect(session('admin_rentals', []));

    $histories = $rentals->filter(function ($item) use ($customerName) {
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