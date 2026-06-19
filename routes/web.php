<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;

use App\Http\Controllers\Pelanggan\HomeController;
use App\Http\Controllers\Pelanggan\ProductController;
use App\Http\Controllers\Pelanggan\CartController;
use App\Http\Controllers\Pelanggan\RentalController;
use App\Http\Controllers\Pelanggan\PaymentController;
use App\Http\Controllers\Pelanggan\ProfileController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'public'])->name('root');
Route::get('/home', [HomeController::class, 'public'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProses'])->name('login.proses');

Route::get('/daftar', [AuthController::class, 'daftar'])->name('daftar');
Route::post('/daftar', [AuthController::class, 'daftarProses'])->name('daftar.proses');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.detail');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::get('/dashboard-admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [AdminNotificationController::class, 'read'])->name('notifications.read');
    Route::delete('/notifications/{id}', [AdminNotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/calendar', [AdminDashboardController::class, 'calendar'])->name('calendar');
    Route::get('/payments', [AdminPaymentController::class, 'index']) ->name('payments');

    Route::get('/products', [AdminProductController::class, 'index'])->name('products');
    Route::post('/products/store', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/detail', [AdminProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::post('/products/{id}', [AdminProductController::class, 'update'])->name('products.update.post');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/rentals', [AdminRentalController::class, 'index'])->name('rentals');
    Route::post('/rentals/store', [AdminRentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/{id}/detail', [AdminRentalController::class, 'show'])->name('rentals.show');
    Route::get('/rentals/{id}/edit', [AdminRentalController::class, 'edit'])->name('rentals.edit');
    Route::put('/rentals/{id}', [AdminRentalController::class, 'update'])->name('rentals.update');
    Route::post('/rentals/{id}', [AdminRentalController::class, 'update'])->name('rentals.update.post');
    Route::get('/rentals/{id}/extend', [AdminRentalController::class, 'extend'])->name('rentals.extend');
    Route::post('/rentals/{id}/extend', [AdminRentalController::class, 'extendProses'])->name('rentals.extend.proses');
    Route::post('/rentals/{id}/return', [AdminRentalController::class, 'returnItem'])->name('rentals.return');
    Route::post('/rentals/{id}/verify', [AdminRentalController::class, 'verify'])->name('rentals.verify');

    Route::post('/rentals/{id}/verify-denda', [AdminRentalController::class, 'verifyDenda'])->name('rentals.verify-denda');

    Route::delete('/rentals/{id}', [AdminRentalController::class, 'destroy'])->name('rentals.destroy');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::post('/users/{id}', [AdminUserController::class, 'update'])->name('users.update.post');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports');
    Route::get('/reports/pdf', [AdminReportController::class, 'pdf'])->name('reports.pdf');

    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

/*
|--------------------------------------------------------------------------
| Pelanggan
|--------------------------------------------------------------------------
*/

Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/home', fn () => redirect()->route('home'))->name('home');

    Route::get('/produk', [ProductController::class, 'index'])->name('produk');

    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');

    Route::post('/keranjang/tambah', [CartController::class, 'tambah'])->name('keranjang.tambah');

    Route::post('/keranjang/{index}/update', [CartController::class, 'update'])
        ->name('keranjang.update');

    Route::delete('/keranjang/{index}', [CartController::class, 'hapus'])
        ->name('keranjang.hapus');

    Route::post('/keranjang/checkout', [CartController::class, 'checkout'])
        ->name('keranjang.checkout');

    Route::get('/sewa', [RentalController::class, 'index'])->name('sewa');
    Route::get('/sewa/{id}/extend', [RentalController::class, 'extend'])->name('sewa.extend');
    Route::post('/sewa/{id}/extend', [RentalController::class, 'extendProses'])->name('sewa.extend.proses');

    Route::get('/pembayaran', [PaymentController::class, 'index'])->name('pembayaran');
    Route::post('/pembayaran/{id}/upload', [PaymentController::class, 'uploadBukti'])->name('pembayaran.upload');

    Route::get('/riwayat', [RentalController::class, 'riwayat'])->name('riwayat');

    Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
    Route::post('/profil', [ProfileController::class, 'update'])->name('profil.update');

    Route::get('/hubungi-admin', function () {
        return redirect()->route('pelanggan.profil');
    })->name('hubungi-admin');
});
Route::get('/pelanggan/hubungi-admin', function () {
    return redirect()->route('pelanggan.profil');
})->name('pelanggan.hubungi-admin');
