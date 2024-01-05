<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Models\Absen;
use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Support\Facades\Route;







Route::get('/login',[LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'aksilogin'])->name('login');
Route::get('logout', [LoginController::class, 'logout']);


Route::middleware(['auth'])->group(function () {


Route::get('/', function () {
    return view('home',['siswa' => Siswa::all(), 'jurusan' => Jurusan::all(),]);
})->name('home');


Route::get('/scan', [AbsenController::class, 'scan'])->name('scan');

Route::get('/absensi', [AbsenController::class, 'index'])->name('absen.index');
Route::post('/store', [AbsenController::class, 'store'])->name('scan.masuk');

Route::get('/daily-report', [AbsenController::class, 'dailyReport'])->name('dailyReport');
Route::get('/print-pdf-daily-report', [AbsenController::class, 'printPdfDailyReport'])->name('printPdfDailyReport');

Route::get('/monthly-report',[AbsenController::class, 'monthlyReport'])->name('monthlyReport');
Route::get('/print-pdf-monthly-report', [AbsenController::class, 'printPdfMonthlyReport'])->name('printPdfMonthlyReport');

Route::get('/period-report', [AbsenController::class, 'periodReport'])->name('periodReport');
Route::get('/print-pdf-periode-report', [AbsenController::class, 'printPdfPeriodReport'])->name('printPdfPeriodeReport');

Route::get('siswa',[SiswaController::class,'index']);
Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
Route::patch('edit-siswa/{id}',[SiswaController::class,'update'])->name('siswa.update');
Route::put('/siswa/{id}', [SiswaController::class, 'update1'])->name('siswa.update1');
Route::delete('hapus-siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
Route::get('/siswa/print-pdf/{id}', [SiswaController::class, 'printQrPdf'])->name('siswa.print.pdf');

Route::post('/import-siswa', [SiswaController::class, 'import'])->name('siswa.import');


Route::get('jurusan',[JurusanController::class,'index']);
Route::post('simpan-jurusan',[JurusanController::class,'store']);
Route::patch('edit-jurusan/{id}',[JurusanController::class,'update'])->name('edit-jurusan.update');
Route::delete('hapus-jurusan/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

Route::get('user',[UserController::class,'index']);
Route::post('simpan-user',[UserController::class,'store']);
Route::patch('edit-user/{id}',[UserController::class,'update'])->name('edit-user.update');
Route::delete('hapus-user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

});

