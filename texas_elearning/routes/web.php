<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HandlerController;
use App\Http\Controllers\JadwalQuizController;
use App\Http\Controllers\KategoriQuizController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TentorController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('backend/user.login');
});
Route::group(['middleware' => ['auth','web']], function () {
    /*Akses Admin */
    Route::group(['middleware' => ['cek_login:1']], function () {
        Route::get('/dashboardadmin', [DashboardController::class, 'index'])->name('dashboardadmin');
        /* Data Siswa */
        Route::get('/datasiswa', [SiswaController::class, 'index'])->name('datasiswa');
        Route::get('/datasiswa/data', [SiswaController::class, 'getData'])->name('datasiswa.data');
        Route::post('/datasiswa/tambah', [SiswaController::class, 'store'])->name('datasiswa.tambah');
        Route::get('/datasiswa/edit/{id}', [SiswaController::class, 'edit'])->name('datasiswa.edit');
        Route::post('/datasiswa/update/{id}', [SiswaController::class, 'update'])->name('datasiswa.update');
        Route::delete('/datasiswa/delete/{id}', [SiswaController::class, 'destroy']);
        /* End Data Siswa */

        /* Data Tentor */
        Route::get('/datatentor', [TentorController::class, 'index'])->name('datatentor');
        Route::get('/datatentor/data', [TentorController::class, 'getData'])->name('datatentor.data');
        Route::post('/datatentor/tambah', [TentorController::class, 'store'])->name('datatentor.tambah');
        Route::get('/datatentor/edit/{id}', [TentorController::class, 'edit'])->name('datatentor.edit');
        Route::post('/datatentor/update/{id}', [TentorController::class, 'update'])->name('datatentor.update');
        Route::delete('/datatentor/delete/{id}', [TentorController::class, 'destroy']);
        /* End Data Tentor */

        /* Data Kategori */
        Route::get('/datakategoriquiz', [KategoriQuizController::class, 'index'])->name('datakategoriquiz');
        Route::get('/datakategoriquiz/data', [KategoriQuizController::class, 'getData'])->name('datakategoriquiz.data');
        Route::post('/datakategoriquiz/tambah', [KategoriQuizController::class, 'store'])->name('datakategoriquiz.tambah');
        Route::get('/datakategoriquiz/edit/{id}', [KategoriQuizController::class, 'edit'])->name('datakategoriquiz.edit');
        Route::post('/datakategoriquiz/update/{id}', [KategoriQuizController::class, 'update'])->name('datakategoriquiz.update');
        Route::delete('/datakategoriquiz/delete/{id}', [KategoriQuizController::class, 'destroy']);
        /* End Data Kategori */

        /* Data Quiz */
        Route::get('/dataquiz', [QuizController::class, 'index'])->name('dataquiz');
        Route::get('/dataquiz/data', [QuizController::class, 'getData'])->name('dataquiz.data');
        Route::post('/dataquiz/tambah', [QuizController::class, 'store'])->name('dataquiz.tambah');
        Route::get('/dataquiz/edit/{id}', [QuizController::class, 'edit'])->name('dataquiz.edit');
        Route::post('/dataquiz/update/{id}', [QuizController::class, 'update'])->name('dataquiz.update');
        Route::delete('/dataquiz/delete/{id}', [QuizController::class, 'destroy']);
        /* End Data Quiz */

        /* Data Pertanyaan */
        Route::get('/datapertanyaan/data/{id}', [PertanyaanController::class, 'getData'])->name('datapertanyaan.data');
        Route::get('/dataquiz/pertanyaan/{id}', [QuizController::class, 'show'])->name('dataquiz.pertanyaan');
        Route::post('/datapertanyaan/tambah', [PertanyaanController::class, 'store'])->name('datapertanyaan.tambah');
        Route::get('/datapertanyaan/edit/{id}', [PertanyaanController::class, 'edit'])->name('datapertanyaan.edit');
        Route::post('/datapertanyaan/update/{id}', [PertanyaanController::class, 'update'])->name('datapertanyaan.update');
        Route::delete('/datajawaban/delete/{id}', [PertanyaanController::class, 'jawabandelete'])->name('datajawaban.delete');
        Route::delete('/datapertanyaan/delete/{id}', [PertanyaanController::class, 'destroy'])->name('datapertanyaan.delete');
        /* End Data Pertanyaan */

        /* Data User */
        Route::get('/datauser', [UserController::class, 'index'])->name('datauser');
        Route::get('/datauser/data', [UserController::class, 'getData'])->name('datauser.data');
        Route::post('/datauser/tambah', [UserController::class, 'store'])->name('datauser.tambah');
        Route::get('/datauser/edit/{id}', [UserController::class, 'edit'])->name('datauser.edit');
        Route::post('/datauser/update/{id}', [UserController::class, 'update'])->name('datauser.update');
        Route::delete('/datauser/delete/{id}', [UserController::class, 'destroy']);
        Route::get('/datauser/panggil', [SiswaController::class, 'panggilUser'])->name('datauser.panggil');
        /* End Data User */

        /* Data Jadwal Quiz */
        Route::get('/datajadwalquiz', [JadwalQuizController::class, 'index'])->name('datajadwalquiz');
        Route::get('/datajadwalquiz/data', [JadwalQuizController::class, 'getData'])->name('datajadwalquiz.data');
        Route::post('/datajadwalquiz/tambah', [JadwalQuizController::class, 'store'])->name('datajadwalquiz.tambah');
        Route::get('/datajadwalquiz/edit/{id}', [JadwalQuizController::class, 'edit'])->name('datajadwalquiz.edit');
        Route::post('/datajadwalquiz/update/{id}', [JadwalQuizController::class, 'update'])->name('datajadwalquiz.update');
        Route::delete('/datajadwalquiz/delete/{id}', [JadwalQuizController::class, 'destroy']);
        /* End Data Jadwal Quiz */


    });
    /* Akses Pegawai */
    Route::group(['middleware' => ['cek_login:2']], function () {
        Route::get('/dashboardtentor', [DashboardController::class, 'index'])->name('dashboardtentor');
    });
    Route::group(['middleware' => ['cek_login:3']], function () {
        Route::get('/dashboardsiswa', [DashboardController::class, 'index'])->name('dashboardsiswa');
        /* Quiz */
        Route::get('/quizsiswa', [QuizController::class, 'quizSiswa'])->name('quizsiswa');
        Route::get('/quizsiswa/detail/{id}/{jadwal}', [QuizController::class, 'quizDetail'])->name('quizsiswadetail');
        Route::post('/hasilpilihanquiz', [QuizController::class, 'HasilPilihanQuiz'])->name('hasilpilihanquiz');
        Route::post('/hasiltextquiz', [QuizController::class, 'HasilTextQuiz'])->name('hasiltextquiz');
        Route::get('/totalnilai/{id}/{tgl}', [QuizController::class, 'totalnilai'])->name('totalnilai');
        // Route::get('/quizsiswa/detail/fetch_data/{id}/{jadwal}', [QuizController::class, 'fetch_data']);
        /* End Quiz */
    });
});
/* Authenticate */
Route::get('/masukLogin', [LoginController::class, 'index'])->name('masuklogin');
Route::post('/authenticate', [LoginController::class, 'masukLogin'])->name('masukLogin');
Route::post('/keluarlogout', [LoginController::class, 'logout'])->name('keluarlogout');
/* Authenticate */

/* Handler */
Route::get('/hakakses', [HandlerController::class, 'HakAkses'])->name('hakakses');
/* Handler */

