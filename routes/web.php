<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () { return view('home'); })->middleware('guest');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// URL for Peminjam Peralatan
// Route::get('login-peminjam', function () { return view('auth.userLogin'); })->name('login-peminjam')->middleware('guest');
Route::get('login-peminjaman', function(){
    return view('auth.loginUser');
})->name('login-peminjam')->middleware('guest');

Route::post('/login-peminjam', [\App\Http\Controllers\UserController::class, 'login']);
Route::post('/logout-peminjam', [\App\Http\Controllers\UserController::class, 'logout']);
Route::get('/dashboard-user', [\App\Http\Controllers\PageUserController::class, 'index'])->middleware('auth');
Route::get('detail-barang/{id}', [\App\Http\Controllers\PinjamController::class, 'index'])->middleware('auth');
Route::post('pinjam-barang/{id}', [\App\Http\Controllers\PinjamController::class, 'pinjam']);
Route::get('cart-peminjaman', [\App\Http\Controllers\PinjamController::class, 'cart'])->middleware('auth');
Route::delete('cart-peminjaman/{id}', [\App\Http\Controllers\PinjamController::class, 'delete']);
Route::get('konfirmasi-pinjaman', [\App\Http\Controllers\PinjamController::class, 'konfirmasi'])->middleware('auth');


// URL for Search Barang
Route::get('/search', [\App\Http\Controllers\PageUserController::class, 'search'])->name('search')->middleware('auth');

// URL for Petugas Peralatan and give middleware to group
Route::prefix('petugas_peralatan')->group(function () {
    // URL for Login & Logout
    Route::get('/login-petugas', [App\Http\Controllers\Auth\PetugasPeralatanLoginController::class, 'showLoginForm'])->name('petugas_peralatan.login');
    Route::post('/login-petugas', [App\Http\Controllers\Auth\PetugasPeralatanLoginController::class, 'login'])->name('petugas_peralatan.login.submit');
    Route::get('/logout-petugas', [App\Http\Controllers\Auth\PetugasPeralatanLoginController::class, 'logout'])->name('petugas_peralatan.logout');
    
    // URL for Dashboard
    Route::get('/', [App\Http\Controllers\PetugasPeralatanController::class, 'index']);
    Route::get('/dashboard', [App\Http\Controllers\PetugasPeralatanController::class, 'index'])->name('petugas_peralatan.dashboard');

    // URL for Mahasiswa & Dosen
    Route::get('/mahasiswa', [App\Http\Controllers\PageUserController::class, 'getUser'])->name('petugas_peralatan.mahasiswa')->middleware('auth:petugas_peralatan');
    Route::get('/dosen', [App\Http\Controllers\PageUserController::class, 'getDosen'])->name('petugas_peralatan.dosen')->middleware('auth:petugas_peralatan');

    // URL for Barang
    Route::get('/barang', [App\Http\Controllers\BarangController::class, 'index'])->name('barang.index')->middleware('auth:petugas_peralatan');
    Route::get('/barang/create', [App\Http\Controllers\BarangController::class, 'create'])->name('barang.create')->middleware('auth:petugas_peralatan');
    Route::post('/barang', [App\Http\Controllers\BarangController::class, 'store'])->name('barang.store')->middleware('auth:petugas_peralatan');
    Route::get('/barang/{id}', [App\Http\Controllers\BarangController::class, 'show'])->name('barang.show')->middleware('auth:petugas_peralatan');
    Route::get('/barang/{id}/edit', [App\Http\Controllers\BarangController::class, 'edit'])->name('barang.edit')->middleware('auth:petugas_peralatan');
    Route::put('/barang/{id}', [App\Http\Controllers\BarangController::class, 'update'])->name('barang.update')->middleware('auth:petugas_peralatan');
    Route::delete('/barang/{id}', [App\Http\Controllers\BarangController::class, 'destroy'])->name('barang.destroy')->middleware('auth:petugas_peralatan');

    //pdf
    Route::get('/barang-pdf', [App\Http\Controllers\BarangController::class, 'createPDF'])->name('barang.mpdf')->middleware('auth:petugas_peralatan');
    
    // URL for Peminjaman
    Route::get('peminjam-barang', [App\Http\Controllers\PinjamController::class, 'peminjam'])->name('petugas_peralatan.peminjam')->middleware('auth:petugas_peralatan');

    // URL for Pengembalian
    Route::get('pengembalian-barang', [App\Http\Controllers\PengembalianController::class, 'pengembalian'])->name('petugas_peralatan.pengembalian')->middleware('auth:petugas_peralatan');
    Route::get('pengembalian-detail/{id}', [App\Http\Controllers\PengembalianController::class, 'detailPengembalian'])->name('petugas_peralatan.detailPengembalian')->middleware('auth:petugas_peralatan');
    Route::post('pengembalian-barang/{id}/{id_barang}', [App\Http\Controllers\PengembalianController::class, 'pengembalianBarang'])->name('petugas_peralatan.pengembalianBarang')->middleware('auth:petugas_peralatan');

    // URL for Log
    Route::get('log', [App\Http\Controllers\PetugasPeralatanController::class, 'getLog'])->name('petugas_peralatan.log')->middleware('auth:petugas_peralatan');
    Route::get('log/{id}', [App\Http\Controllers\PetugasPeralatanController::class, 'getLogDetails'])->name('petugas_peralatan.logDetails')->middleware('auth:petugas_peralatan');
});

// jobs & queues for TestQueueEmail
Route::get('queue', [App\Http\Controllers\TestQueueEmails::class, 'sendTestEmails'])->name('queue.index');




