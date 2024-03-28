<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupQuizController;
use App\Http\Controllers\HandlerController;
use App\Http\Controllers\HasilQuizController;
use App\Http\Controllers\HasilQuizSiswaController;
use App\Http\Controllers\HasilQuizTentorController;
use App\Http\Controllers\JadwalQuizController;
use App\Http\Controllers\JadwalQuizTentorController;
use App\Http\Controllers\KategoriQuizController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KursusController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizTentorController;
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
    Route::post('change-password', [UserController::class, 'change'])->name('change.password');
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
        Route::get('/dataskorquiz/edit/{id}', [KategoriQuizController::class, 'editskor'])->name('dataskorquiz.edit');
        Route::post('/datakategoriquiz/update/{id}', [KategoriQuizController::class, 'update'])->name('datakategoriquiz.update');
        Route::delete('/datakategoriquiz/delete/{id}', [KategoriQuizController::class, 'destroy']);
        Route::delete('/dataskor/delete/{id}', [KategoriQuizController::class, 'skordelete'])->name('dataskor.delete');
        Route::post('/dataskor/update/{id}', [KategoriQuizController::class, 'skorupdate'])->name('dataskor.update');
        /* End Data Kategori */

        /* Data Kelas */
        Route::get('/datakelas', [KelasController::class, 'index'])->name('datakelas');
        Route::get('/datakelas/data', [KelasController::class, 'getData'])->name('datakelas.data');
        Route::post('/datakelas/tambah', [KelasController::class, 'store'])->name('datakelas.tambah');
        Route::get('/datakelas/edit/{id}', [KelasController::class, 'edit'])->name('datakelas.edit');
        Route::post('/datakelas/update/{id}', [KelasController::class, 'update'])->name('datakelas.update');
        Route::delete('/datakelas/delete/{id}', [KelasController::class, 'destroy']);
        /* End Data Kelas */

        /* Data Kelas */
        Route::get('/datakursus', [KursusController::class, 'index'])->name('datakursus');
        Route::get('/datakursus/data', [KursusController::class, 'getData'])->name('datakursus.data');
        Route::post('/datakursus/tambah', [KursusController::class, 'store'])->name('datakursus.tambah');
        Route::get('/datakursus/edit/{id}', [KursusController::class, 'edit'])->name('datakursus.edit');
        Route::post('/datakursus/update/{id}', [KursusController::class, 'update'])->name('datakursus.update');
        Route::delete('/datakursus/delete/{id}', [KursusController::class, 'destroy']);
        /* End Data Kelas */

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
        Route::post('/updateOrder', [PertanyaanController::class, 'updateOrder'])->name('updateOrder');
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
        Route::get('/getquiz', [JadwalQuizController::class, 'getquiz'])->name('getquiz');
        Route::get('/datajadwalquiz/data', [JadwalQuizController::class, 'getData'])->name('datajadwalquiz.data');
        Route::post('/datajadwalquiz/tambah', [JadwalQuizController::class, 'store'])->name('datajadwalquiz.tambah');
        Route::get('/datajadwalquiz/edit/{id}', [JadwalQuizController::class, 'edit'])->name('datajadwalquiz.edit');
        Route::post('/datajadwalquiz/update/{id}', [JadwalQuizController::class, 'update'])->name('datajadwalquiz.update');
        Route::get('/getsiswa/{id}', [JadwalQuizController::class, 'getSiswa'])->name('getSiswa');
        Route::delete('/datajadwalquiz/delete/{id}', [JadwalQuizController::class, 'destroy']);
        /* End Data Jadwal Quiz */

        /* Data Group Quiz */
        Route::get('/datagroupquiz', [GroupQuizController::class, 'index'])->name('datagroupquiz');
        // Route::get('/getquiz', [GroupQuizController::class, 'getquiz'])->name('getquiz');
        Route::get('/datagroupquiz/data', [GroupQuizController::class, 'getData'])->name('datagroupquiz.data');
        Route::post('/datagroupquiz/tambah', [GroupQuizController::class, 'store'])->name('datagroupquiz.tambah');
        Route::get('/datagroupquiz/edit/{id}', [GroupQuizController::class, 'edit'])->name('datagroupquiz.edit');
        Route::post('/datagroupquiz/update/{id}', [GroupQuizController::class, 'update'])->name('datagroupquiz.update');
        Route::delete('/datagroupquiz/delete/{id}', [GroupQuizController::class, 'destroy']);
        /* End Data Jadwal Quiz */

        /* Data Hasil Quiz */
        Route::get('/datahasilquiz', [HasilQuizController::class, 'index'])->name('datahasilquiz');
        Route::get('/datahasilquizcover/detail/{id}/{tgl}', [HasilQuizController::class, 'indexCoverDetail'])->name('datahasilquizdetailcover');
        Route::get('/datahasilquizcover/detailcover/{id}', [HasilQuizController::class, 'indexDetail'])->name('datahasilquizdetail');
        Route::get('/datahasilquizcover/data', [HasilQuizController::class, 'getDataCover'])->name('datahasilquizcover.data');
        Route::get('/datahasilquizcover/data/{id}/{tgl}', [HasilQuizController::class, 'getDataDetailCover'])->name('datahasilquizdetailcover.data');
        Route::get('/datahasilquiz/data/{id}', [HasilQuizController::class, 'getData'])->name('datahasilquiz.data');
        Route::get('/detaildatahasilquiz/data/{id}', [HasilQuizController::class, 'getDataDetail'])->name('detaildatahasilquiz.data');
        Route::get('/detaildatahasilquiz/detail/{id}', [HasilQuizController::class, 'showDetail'])->name('detaildatahasilquiz.detail');
        Route::post('/datahasilquiz/tambah', [HasilQuizController::class, 'store'])->name('datahasilquiz.tambah');
        Route::get('/datahasilquiz/detail/{id}', [HasilQuizController::class, 'show'])->name('datahasilquiz.data.detail');
        Route::post('/datahasilquiz/update/{id}', [HasilQuizController::class, 'update'])->name('datahasilquiz.update');
        Route::delete('/datahasilquiz/delete/{id}', [HasilQuizController::class, 'destroy']);
        Route::get('/datahasilquiz/edit/{id}', [HasilQuizController::class, 'edit'])->name('datahasilquiz.edit');
        // Route::get('/quizdetail/detail/{id}/{jadwal}', [HasilQuizController::class, 'Detail'])->name('quizdetail');
        /* End Data Hasil Quiz */


    });
    /* Akses Pegawai */
    Route::group(['middleware' => ['cek_login:2']], function () {
        Route::get('/dashboardtentor', [DashboardController::class, 'index'])->name('dashboardtentor');
        /* Data Quiz */
        Route::get('/dataquiztentor', [QuizTentorController::class, 'index'])->name('dataquiztentor');
        Route::get('/dataquiztentor/data', [QuizTentorController::class, 'getData'])->name('dataquiztentor.data');
        Route::post('/dataquiztentor/tambah', [QuizTentorController::class, 'store'])->name('dataquiztentor.tambah');
        Route::get('/dataquiztentor/edit/{id}', [QuizTentorController::class, 'edit'])->name('dataquiztentor.edit');
        Route::post('/dataquiztentor/update/{id}', [QuizTentorController::class, 'update'])->name('dataquiztentor.update');
        Route::delete('/dataquiztentor/delete/{id}', [QuizTentorController::class, 'destroy']);
        /* End Data Quiz */

        /* Data Pertanyaan */
        Route::get('/datapertanyaantentor/data/{id}', [PertanyaanController::class, 'getData'])->name('datapertanyaantentor.data');
        Route::get('/dataquiztentor/pertanyaan/{id}', [QuizTentorController::class, 'show'])->name('dataquiztentor.pertanyaan');
        Route::post('/datapertanyaantentor/tambah', [PertanyaanController::class, 'store'])->name('datapertanyaantentor.tambah');
        Route::get('/datapertanyaantentor/edit/{id}', [PertanyaanController::class, 'edit'])->name('datapertanyaantentor.edit');
        Route::post('/datapertanyaantentor/update/{id}', [PertanyaanController::class, 'update'])->name('datapertanyaantentor.update');
        Route::delete('/datajawabantentor/delete/{id}', [PertanyaanController::class, 'jawabandelete'])->name('datajawaban.delete');
        Route::delete('/datapertanyaantentor/delete/{id}', [PertanyaanController::class, 'destroy'])->name('datapertanyaantentor.delete');
        Route::post('/updateOrderTentor', [PertanyaanController::class, 'updateOrder'])->name('updateOrderTentor');
        /* End Data Pertanyaan */

        /* Data Jadwal Quiz */
        Route::get('/datajadwalquiztentor', [JadwalQuizTentorController::class, 'index'])->name('datajadwalquiztentor');
        Route::get('/getquiztentor', [JadwalQuizTentorController::class, 'getquiz'])->name('getquiztentor');
        Route::get('/datajadwalquiztentor/data', [JadwalQuizTentorController::class, 'getData'])->name('datajadwalquiztentor.data');
        Route::post('/datajadwalquiztentor/tambah', [JadwalQuizTentorController::class, 'store'])->name('datajadwalquiztentor.tambah');
        Route::get('/datajadwalquiztentor/edit/{id}', [JadwalQuizTentorController::class, 'edit'])->name('datajadwalquiztentor.edit');
        Route::post('/datajadwalquiztentor/update/{id}', [JadwalQuizTentorController::class, 'update'])->name('datajadwalquiztentor.update');
        Route::delete('/datajadwalquiztentor/delete/{id}', [JadwalQuizTentorController::class, 'destroy']);
        Route::get('/getsiswatentor/{id}', [JadwalQuizTentorController::class, 'getSiswa'])->name('getSiswaTentor');
        /* End Data Jadwal Quiz */

        /* Data Hasil Quiz */
        Route::get('/datahasilquiztentor', [HasilQuizTentorController::class, 'index'])->name('datahasilquiztentor');
        Route::get('/datahasilquizcovertentor/detail/{id}/{tgl}', [HasilQuizTentorController::class, 'indexCoverDetail'])->name('datahasilquizdetailcovertentor');
        Route::get('/datahasilquizcovertentor/detailcover/{id}', [HasilQuizTentorController::class, 'indexDetail'])->name('datahasilquizdetailtentor');
        Route::get('/datahasilquizcovertentor/data', [HasilQuizTentorController::class, 'getDataCover'])->name('datahasilquizcovertentor.data');
        Route::get('/datahasilquizcovertentor/data/{id}/{tgl}', [HasilQuizTentorController::class, 'getDataDetailCover'])->name('datahasilquizdetailcovertentor.data');
        Route::get('/datahasilquiztentor/data/{id}', [HasilQuizTentorController::class, 'getData'])->name('datahasilquiztentor.data');
        Route::get('/detaildatahasilquiztentor/data/{id}', [HasilQuizTentorController::class, 'getDataDetail'])->name('detaildatahasilquiztentor.data');
        Route::get('/detaildatahasilquiztentor/detail/{id}', [HasilQuizTentorController::class, 'showDetail'])->name('detaildatahasilquiztentor.detail');
        Route::post('/datahasilquiztentor/tambah', [HasilQuizTentorController::class, 'store'])->name('datahasilquiztentor.tambah');
        Route::get('/datahasilquiztentor/detail/{id}', [HasilQuizTentorController::class, 'show'])->name('datahasilquiztentor.data.detail');
        Route::post('/datahasilquiztentor/update/{id}', [HasilQuizTentorController::class, 'update'])->name('datahasilquiztentor.update');
        Route::delete('/datahasilquiztentor/delete/{id}', [HasilQuizTentorController::class, 'destroy']);
        Route::get('/datahasilquiztentor/edit/{id}', [HasilQuizTentorController::class, 'edit'])->name('datahasilquiztentor.edit');
        Route::get('/detaildatahasilquiztentor/detail/{id}', [HasilQuizTentorController::class, 'showDetail'])->name('detaildatahasilquiztentor.detail');
        /* End Data Hasil Quiz */
    });
    Route::group(['middleware' => ['cek_login:3']], function () {
        Route::get('/dashboardsiswa', [DashboardController::class, 'index'])->name('dashboardsiswa');
        /* Quiz */
        Route::get('/quizsiswa', [QuizController::class, 'quizSiswa'])->name('quizsiswa');
        Route::get('/quizsiswa/detail/{id}/{jadwal}', [QuizController::class, 'quizDetail'])->name('quizsiswadetail');
        Route::get('/quizsiswa/cover/{id}/{tanggal}', [QuizController::class, 'quizSiswaCover'])->name('quizsiswacover');
        Route::post('/hasilpilihanquiz', [QuizController::class, 'HasilPilihanQuiz'])->name('hasilpilihanquiz');
        Route::post('/hasiltextquiz', [QuizController::class, 'HasilTextQuiz'])->name('hasiltextquiz');
        Route::post('/hasilblankquiz', [QuizController::class, 'HasilBlankQuiz'])->name('hasilblakquiz');
        Route::post('/totalnilai', [QuizController::class, 'totalnilai'])->name('totalnilai');
        Route::get('/cekhasil/{id}/{tgl}', [QuizController::class, 'cekhasil'])->name('cekhasil');
        Route::get('/quizsiswahasil', [HasilQuizSiswaController::class, 'index'])->name('quizsiswahasil');
        Route::get('/datahasilquizsiswa/data', [HasilQuizSiswaController::class, 'getData'])->name('datahasilquizsiswa.data');
        Route::get('/detaildatahasilquizsiswa/data/{group}/{tgl}', [HasilQuizSiswaController::class, 'getDataDetail'])->name('detaildatahasilquizsiswa.data');
        Route::get('/datahasilquizsiswa/detail/{group}/{tgl}', [HasilQuizSiswaController::class, 'show'])->name('datahasilquizsiswa.detail');
        Route::get('/cetaktoefl/{id}/{tgl}', [HasilQuizSiswaController::class, 'cetakToefl'])->name('cetaktoefl');

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

