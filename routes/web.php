<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\RapatController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BacklogController;
use App\Http\Controllers\NotulenController;
use App\Http\Controllers\DashboardController;


// Route Global 
Route::get('/', fn() => view('landing'))->name('landing');
// Route::get('/AboutUs', fn() => view('landing'))->name('landing');
// Route::get('/TermService', fn() => view('landing'))->name('landing');

// Route Auth Register
Route::view('/register', 'auth.register')->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');


// Route Auth Login 
Route::view('/login', 'auth.login')->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Forgot / Reset Password (OTP)
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify.form');
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');



// Route Login with Google
Route::get('/loginwithgoogle', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/loginwithgoogle/callback', [AuthController::class, 'handleGoogleCallback'])->name('login.google.callback');


// // Route Role User
// Route::view('/dashboard', 'dashboard')->name('dashboard')->middleware('auth');
// route::view('/profile', 'profile')->name('profile')->middleware('auth');


// Route Global Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


route::view('/daftar', 'auth.daftar')->name('daftar');
route::view('/masuk', 'masuk')->name('masuk');

route::get('/dashboard',  [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');


Route::post('/rapat', [RapatController::class, 'store'])->name('rapat.store');
Route::get('/rapatrekap', [RapatController::class, 'index'])->name('rapat.index');
Route::get('/rapat/{id}/details', [RapatController::class, 'showDetails']);


Route::get('/test-email', function () {
    try {
        // Ganti dengan alamat email Anda yang valid untuk menerima tes
        $testEmail = 'aldyjhonatanhutasoit.1@gmail.com'; 

        Mail::raw('Ini adalah email tes dari aplikasi MeetLog.', function ($message) use ($testEmail) {
            $message->to($testEmail)
                    ->subject('Tes Koneksi Email MeetLog');
        });

        return 'Berhasil mengirim email tes! Silakan periksa inbox Anda.';

    } catch (\Exception $e) {
        // Akan menampilkan pesan error yang detail jika APP_DEBUG=true
        return 'Gagal mengirim email.e Error: <pre>' . $e->getMessage() . '</pre>';
    }
});

route::view('/testview', 'global.profilecustom')->name('testview');



// Route::get('/admin', function () {
//     return view('admin');
// })->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// Route::get('/user', function () {
//     return view('user');
// })->middleware(['auth', 'role:user'])->name('user.dashboard');





// route::get('/kelompok', function () {
//     return view('admin.groupmanagement');
// })->middleware(['auth','role:admin'])->name('kelompok');




Route::resource('groups', GroupController::class) ->middleware(['auth','role:admin'])->name('kelompok', 'kelompok');

Route::get('/groups/{id}/edit', [App\Http\Controllers\GroupController::class, 'editAjax'])->name('groups.edit.ajax');


route::view('/viewlive', 'kanban')->name('viewlive');
// route::get('/kanban', [BacklogController::class, 'index'])->name('backlog.index');
Route::post('/tugas-saya/update-status/{tindakan}', [BacklogController::class, 'updateStatus'])->name('backlog.updateStatus');


route::view('/rekapnotulensi', 'global.notuleensimanagement')->name('rekapnotulensi');

// routee::resource('notuleen', NotuleenController::class)->middleware(['auth','role:admin'])->name('notuleen', 'notuleen');

route::view('/viewnotuleen', 'global.viewnotulen')->name('notulenselection');

// routes/web.php



Route::prefix('notulen')->group(function () {
    Route::get('/select', [NotulenController::class, 'selectRapat'])->name('notulen.select');
    Route::get('/create', [NotulenController::class, 'create'])->name('notulen.create');
    Route::post('/store', [NotulenController::class, 'store'])->name('notulen.store');

    // Store child data
    Route::post('/{notulenId}/pokok', [NotulenController::class, 'storePokokBahasan'])->name('notulen.storePokok');
    Route::post('/pokok/{pokokId}/keputusan', [NotulenController::class, 'storeKeputusan'])->name('notulen.storeKeputusan');
    Route::post('/keputusan/{keputusanId}/tindakan', [NotulenController::class, 'storeTindakan'])->name('notulen.storeTindakan');
    Route::post('/{notulenId}/publish', [NotulenController::class, 'publish'])->name('notulen.publish');

    // Hapus Pokok Bahasan berdasarkan ID-nya
Route::delete('/pokok/{pokok}', [NotulenController::class, 'destroyPokokBahasan'])->name('notulen.destroyPokok');
// Hapus Keputusan berdasarkan ID-nya
Route::delete('/keputusan/{keputusan}', [NotulenController::class, 'destroyKeputusan'])->name('notulen.destroyKeputusan');
// Hapus Tindakan berdasarkan ID-nya
Route::delete('/tindakan/{tindakan}', [NotulenController::class, 'destroyTindakan'])->name('notulen.destroyTindakan');

    // Generate dan tampilkan ringkasan notulen
    Route::post('/{notulenId}/generate-summary', [NotulenController::class, 'generateSummary'])->name('notulen.generateSummary');
    Route::get('/{notulenId}/summary', [NotulenController::class, 'showSummary'])->name('notulen.showSummary');
    Route::get('/{notulenId}/summary-json', [NotulenController::class, 'getSummaryJson'])->name('notulen.getSummaryJson');

    // PENTING: ini harus paling bawah!
    Route::get('/{notulen}', [NotulenController::class, 'show'])->name('notulen.show');
});


// // web.php
// Route::delete('/pokok-bahasan/{id}', [PokokBahasanController::class, 'destroy'])->name('pokokBahasan.destroy');
// Route::delete('/keputusan/{id}', [KeputusanController::class, 'destroy'])->name('keputusan.destroy');
// Route::delete('/tindakan/{id}', [TindakanController::class, 'destroy'])->name('tindakan.destroy');


// BACKLOG
Route::get('/backlogs', [BacklogController::class, 'index'])->name('backlogs.index');
Route::post('/backlogs', [BacklogController::class, 'store'])->name('backlogs.store');
// Route::put('/backlogs/{id}', [BacklogController::class, 'update'])->name('backlogs.update');



Route::get('/rapat/{rapat}/qr-code', [RapatController::class, 'generateQrCode'])->name('rapat.qr');
// Route untuk menampilkan halaman QR (yang menampilkan gambar QR)
Route::get('/rapat/{rapat}/qr', [AttendanceController::class, 'showQrPage'])->name('rapat.qr.page');

// Halaman universal untuk absensi via QR (terima rapat_id sebagai query parameter)
Route::get('/absensi/scan', [AttendanceController::class, 'showForm'])->name('absensi.scan.form');
// Quick/auto scan: langsung mencatat kehadiran saat link dikunjungi (digunakan untuk QR yang langsung absen)
Route::get('/absensi/scan/auto', [AttendanceController::class, 'quickScan'])->name('absensi.scan.auto')->middleware('auth'); // Batasi 10 request per menit untuk mencegah penyalahgunaan
Route::post('/absensi/scan', [AttendanceController::class, 'store'])->name('absensi.scan.store');

// Route untuk menampilkan hasil absensi rapat
Route::get('/rapat/{rapat}/absensi', [AttendanceController::class, 'showAbsensi'])->name('rapat.absensi');


route::view('/logbook', 'global.profilecustom')->name('profilecustom');  

Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [App\Http\Controllers\ProfileController::class, 'uploadPhoto'])->name('profile.upload-photo');
});  



Route::get('/rapat/{id}/notulen', [RapatController::class, 'showNotulenPage'])->name('rapat.notulen');



Route::get('/rapat/rekomendasi-global', [RapatController::class, 'rekomendasiJadwalGlobal'])->name('rapat.rekomendasi.global');