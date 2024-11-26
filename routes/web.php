<?php
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PenilaianMinatController;
use App\Http\Controllers\AHPController;
use App\Http\Controllers\PilihanController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\PertanyaanMinatController;
use App\Http\Controllers\PenelusuranJenjangController;
use App\Http\Controllers\PenelusuranMinatController;
use App\Http\Controllers\TopsisJenjangController;
use App\Http\Controllers\TopsisController;
use App\Http\Controllers\TopsisMinatController;
use App\Http\Controllers\SubAlternatifController;
use App\Http\Controllers\KriteriaMinatController;
use App\Http\Controllers\KoordinatorController;
use App\Http\Controllers\SiswahController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenggunaAuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', function(){
//     return view('index');
// })->name('dashboard')->middleware('auth');
// Route::get('/', [HomeController::class, 'index']);



Route::get('/', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');
//Route::get('/', [AHPController::class, 'index'])->name('form');


Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
Route::delete('pengguna/{pengguna}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');


Route::get('/register', [PenggunaAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [PenggunaAuthController::class, 'register']);
Route::get('/login', [PenggunaAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [PenggunaAuthController::class, 'login']);
Route::post('/logout', [PenggunaAuthController::class, 'logout'])->name('logout');

// Routes untuk Kriteria
Route::get('kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
Route::get('kriteria/create', [KriteriaController::class, 'create'])->name('kriteria.create');
Route::post('kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
Route::get('kriteria/{kriteria}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
Route::put('kriteria/{kriteria}', [KriteriaController::class, 'update'])->name('kriteria.update');
Route::delete('kriteria/{kriteria}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');

// Route untuk Pilihan
Route::get('/pilihan', [PilihanController::class, 'index'])->name('pilihan.index');
Route::get('/pilihan/create/{type}/{id}', [PilihanController::class, 'create'])->name('pilihan.create');
Route::post('/pilihan', [PilihanController::class, 'store'])->name('pilihan.store');
Route::get('pilihan/{type}/{id}/edit', [PilihanController::class, 'edit'])->name('pilihan.edit');
Route::put('pilihan/update/{id}', [PilihanController::class, 'update'])->name('pilihan.update'); // Rute untuk update
Route::delete('pilihan/{id}', [PilihanController::class, 'destroy'])->name('pilihan.destroy');


// Routes untuk Alternatif
Route::get('alternatif', [AlternatifController::class, 'index'])->name('alternatif.index');
Route::get('alternatif/create', [AlternatifController::class, 'create'])->name('alternatif.create');
Route::post('alternatif', [AlternatifController::class, 'store'])->name('alternatif.store');
Route::get('alternatif/{alternatif}/edit', [AlternatifController::class, 'edit'])->name('alternatif.edit');
Route::put('alternatif/{alternatif}', [AlternatifController::class, 'update'])->name('alternatif.update');
Route::delete('alternatif/{alternatif}', [AlternatifController::class, 'destroy'])->name('alternatif.destroy');

// Route untuk menampilkan form input
Route::get('/ahp', [AHPController::class, 'index'])->name('ahp.index');
Route::post('/ahp/store', [AHPController::class, 'store'])->name('ahp.store');
Route::get('/ahp/show', [AHPController::class, 'show'])->name('ahp.show');
Route::post('/ahp/save', [AHPController::class, 'save'])->name('ahp.save');

// Route untuk Penilaian (rating kecocokan alternatif dan kriteria)
Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
Route::get('/penilaian/create/{alternatif}', [PenilaianController::class, 'create'])->name('penilaian.create');
Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');

// Route untuk Penilaian (rating kecocokan alternatif dan kriteria)
Route::get('/penilaianminat', [PenilaianMinatController::class, 'index'])->name('penilaianminat.index');
Route::get('/penilaianminat/create/{subAlternatifId}', [PenilaianMinatController::class, 'create'])->name('penilaianminat.create');
Route::post('/penilaianminat', [PenilaianMinatController::class, 'store'])->name('penilaianminat.store');

//topsis jenjang
Route::get('/topsis/calculate', [TOPSISController::class, 'calculate'])->name('topsis.calculate');
Route::get('/best-alternatives', [TopsisController::class, 'showBestAlternatives'])->name('best.alternatives');


// Route untuk menghitung TOPSIS minat
// Route::get('/topsisminat/calculate', [TopsisMinatController::class, 'calculate'])->name('topsisminat.calculate');
// // Route untuk menampilkan alternatif terbaik dan sub-alternatif terbaik
// Route::get('/best-alternatives', [TopsisMinatController::class, 'showBestSubAlternatives'])->name('best.alternatives');
// Route::get('/topsisminat/result', [TopsisMinatController::class, 'result'])->name('topsisminat.result');


//sub alternatif
Route::get('/sub_alternatif', [SubAlternatifController::class, 'index'])->name('sub_alternatif.index');
Route::get('/sub_alternatif/create/{alternatif}', [SubAlternatifController::class, 'create'])->name('sub_alternatif.create');
Route::post('/sub_alternatif', [SubAlternatifController::class, 'store'])->name('sub_alternatif.store');
Route::get('/sub_alternatif/edit{id}/', [SubAlternatifController::class, 'edit'])->name('sub_alternatif.edit');
Route::put('/sub_alternatif/{id}', [SubAlternatifController::class, 'update'])->name('sub_alternatif.update');
Route::delete('/sub_alternatif/{id}', [SubAlternatifController::class, 'destroy'])->name('sub_alternatif.destroy');

//kriteria minat
Route::get('kriteriaminat', [KriteriaMinatController::class, 'index'])->name('kriteriaminat.index');
Route::get('kriteriaminat/create', [KriteriaMinatController::class, 'create'])->name('kriteriaminat.create');
Route::post('kriteriaminat', [KriteriaMinatController::class, 'store'])->name('kriteriaminat.store');
Route::get('kriteriaminat/{kriteriaminat}/edit', [KriteriaMinatController::class, 'edit'])->name('kriteriaminat.edit');
Route::put('kriteriaminat/{kriteriaminat}', [KriteriaMinatController::class, 'update'])->name('kriteriaminat.update');
Route::delete('kriteriaminat/{kriteriaminat}', [KriteriaMinatController::class, 'destroy'])->name('kriteriaminat.destroy');

//koordinator
Route::get('/koordinator', [KoordinatorController::class, 'index'])->name('koordinator.index');
Route::get('/koordinator/create', [KoordinatorController::class, 'create'])->name('koordinator.create');
Route::post('/koordinator', [KoordinatorController::class, 'store'])->name('koordinator.store');
Route::get('/koordinator/{id}/edit', [KoordinatorController::class, 'edit'])->name('koordinator.edit');
Route::put('/koordinator/{id}', [KoordinatorController::class, 'update'])->name('koordinator.update');
Route::delete('/koordinator/{id}', [KoordinatorController::class, 'destroy'])->name('koordinator.destroy');

//siswa
Route::post('/siswah/upload', [SiswahController::class, 'upload'])->name('siswah.upload');
Route::get('/siswah', [SiswahController::class, 'index'])->name('siswah.index');
Route::get('/siswah/create', [SiswahController::class, 'create'])->name('siswah.create');
Route::post('/siswah', [SiswahController::class, 'store'])->name('siswah.store');
Route::get('/siswah/{id}/edit', [SiswahController::class, 'edit'])->name('siswah.edit');
Route::put('/siswah/{id}', [SiswahController::class, 'update'])->name('siswah.update');
Route::delete('/siswah/{id}', [SiswahController::class, 'destroy'])->name('siswah.destroy');
Route::get('/siswah/cetak-pdf', [SiswahController::class, 'cetakPdf'])->name('siswah.cetakPdf');


Route::get('tahun', [TahunController::class, 'index'])->name('tahun.index');
Route::get('tahun/create', [TahunController::class, 'create'])->name('tahun.create');
Route::post('tahun', [TahunController::class, 'store'])->name('tahun.store');
Route::get('tahun/{tahun}/edit', [TahunController::class, 'edit'])->name('tahun.edit');
Route::put('tahun/{tahun}', [TahunController::class, 'update'])->name('tahun.update');
Route::delete('tahun/{tahun}', [TahunController::class, 'destroy'])->name('tahun.destroy');

Route::get('pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan.index');
Route::get('pertanyaan/create', [PertanyaanController::class, 'create'])->name('pertanyaan.create');
Route::post('pertanyaan', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
Route::get('pertanyaan/{id}/edit', [PertanyaanController::class, 'edit'])->name('pertanyaan.edit');
Route::put('pertanyaan/{id}', [PertanyaanController::class, 'update'])->name('pertanyaan.update');
Route::delete('pertanyaan/{id}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');

Route::get('pertanyaanminat', [PertanyaanMinatController::class, 'index'])->name('pertanyaanminat.index');
Route::get('pertanyaanminat/create', [PertanyaanMinatController::class, 'create'])->name('pertanyaanminat.create');
Route::post('pertanyaanminat', [PertanyaanMinatController::class, 'store'])->name('pertanyaanminat.store');
Route::get('pertanyaanminat/{id}/edit', [PertanyaanMinatController::class, 'edit'])->name('pertanyaanminat.edit');
Route::put('pertanyaanminat/{id}', [PertanyaanMinatController::class, 'update'])->name('pertanyaanminat.update');
Route::delete('pertanyaanminat/{id}', [PertanyaanMinatController::class, 'destroy'])->name('pertanyaanminat.destroy');

Route::get('penelusuran-jenjang', [PenelusuranJenjangController::class, 'index'])->name('penelusuran-jenjang.index');
Route::post('penelusuran-jenjang', [PenelusuranJenjangController::class, 'store'])->name('penelusuran-jenjang.store');
Route::get('/penelusuran-jenjang/hasil', [TopsisJenjangController::class, 'hasil'])->name('penelusuran-jenjang.hasil');

Route::get('penelusuran-minat', [PenelusuranMinatController::class, 'index'])->name('penelusuran-minat.index');
Route::post('penelusuran-minat', [PenelusuranMinatController::class, 'store'])->name('penelusuran-minat.store');
Route::get('/penelusuran-minat/hasil', [TopsisMinatController::class, 'hasil'])->name('penelusuran-minat.hasil');


Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
Route::get('/rekomendasi/cetak-pdf', [RekomendasiController::class, 'cetakPdf'])->name('rekomendasi.cetakPdf');
