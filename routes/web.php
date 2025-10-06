<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RapatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;


// Route Global 
Route::get('/', fn() => view('landing'))->name('landing');
Route::get('/AboutUs', fn() => view('landing'))->name('landing');
Route::get('/TermService', fn() => view('landing'))->name('landing');

// Route Auth Register
Route::view('/register', 'auth.register')->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Route Verify OTP Code - Register
Route::get('/verify-register', function () {
    return view('auth.verify-otp', [
        'email'  => session('verify_email'),
        'action' => route('register.verify'),
    ]);
})->name('verify.register.form');
Route::post('/register/verify', [AuthController::class, 'verifyRegisterOtp'])->name('register.verify');

// Route Auth Login 
Route::view('/login', 'auth.login')->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Route Auth Login 
Route::get('/verify-login', function () {
    return view('auth.verify-otp', [
        'email'  => session('verify_email'),
        'action' => route('login.verify'),
    ]);
})->name('verify.login.form');

Route::post('/login/verify', [AuthController::class, 'verifyLoginOtp'])->name('login.verify');

// Route Login with Google
Route::get('/loginwithgoogle', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/loginwithgoogle/callback', [AuthController::class, 'handleGoogleCallback'])->name('login.google.callback');


// Route Role User
Route::view('/dashboard', 'dashboard')->name('dashboard')->middleware('auth');
route::view('/profile', 'profile')->name('profile')->middleware('auth');


// Route Global Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


route::view('/daftar', 'auth.daftar')->name('daftar');
route::view('/masuk', 'masuk')->name('masuk');

route::get('/home',  [DashboardController::class, 'index'])->name('home');


Route::post('/rapat', [RapatController::class, 'store'])->name('rapat.store');
Route::get('/rapatrekap', [RapatController::class, 'index'])->name('rapat.index');
Route::get('/rapat/{rapat}/details', [\App\Http\Controllers\RapatController::class, 'showDetails'])->name('rapat.details');

// Route::get('/test-email', function () {
//     try {
//         // Ganti dengan alamat email Anda yang valid untuk menerima tes
//         $testEmail = 'aldyjhonatanhutasoit.1@gmail.com'; 

//         Mail::raw('Ini adalah email tes dari aplikasi MeetLog.', function ($message) use ($testEmail) {
//             $message->to($testEmail)
//                     ->subject('Tes Koneksi Email MeetLog');
//         });

//         return 'Berhasil mengirim email tes! Silakan periksa inbox Anda.';

//     } catch (\Exception $e) {
//         // Akan menampilkan pesan error yang detail jika APP_DEBUG=true
//         return 'Gagal mengirim email.e Error: <pre>' . $e->getMessage() . '</pre>';
//     }
// });

route::view('/testview', 'global.dashboard')->middleware('auth')->name('testview');



Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

Route::get('/user', function () {
    return view('user');
})->middleware(['auth', 'role:user'])->name('user.dashboard');





route::get('/kelompok', function () {
    return view('admin.groupmanagement');
})->middleware(['auth','role:admin'])->name('kelompok');




Route::resource('groups', GroupController::class);



route::view('/viewlive', 'global.dashboard')->name('viewlive');


route::view('/viewlives', 'global.notuleensimanagement')->name('viewlives');