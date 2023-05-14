<?php

use App\Models\Category;

// User
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProdukController as UserProdukController;
use App\Http\Controllers\UserPemakaianController as UserPemakaianController;
use App\Http\Controllers\DatadiriUserController as UserDatadiriUserController;
use App\Http\Controllers\UserSejarahpmimController as UserSejarahpmimController;

// Models dikirimkan untuk user
use App\Models\Akreditas as UserAkreditas;
use App\Models\Profillulusan as UserProfillulus;
use App\Models\VisiMisi as UserVisiMisi;
use App\Models\Kerjasama as UserKerjasama;
use App\Models\Rencanastrategi as UserRencanastrategi;
use App\Models\Organis as UserOrganis;
use App\Models\Staf as UserStaf;
use App\Models\Daftardosen as UserDaftardosen;
use App\Models\Semestersatu as UserSemestersatu;
use App\Models\Semesterdua as UserSemesterdua;
use App\Models\Semestertiga as UserSemestertiga;
use App\Models\Kelender as UserKelender;
use App\Models\Panduanakademik as UserPanduanakademik;

// Admin
use App\Http\Controllers\SofdeletedController;
use App\Http\Controllers\PostController as UserHomeController;
use App\Http\Controllers\UserController as adminUserController;
use App\Http\Controllers\adminCategoryController as adminCategoryController;
use App\Http\Controllers\AkreditasController as adminAkreditasController;
use App\Http\Controllers\CategoryProdukController as adminCategoryProdukController;
use App\Http\Controllers\DaftardosenController as adminDaftardosenController;
use App\Http\Controllers\DashboardPostController as adminDashboardPostController;
use App\Http\Controllers\KelenderController as adminKelenderController;
use App\Http\Controllers\KerjasamaController as adminKerjasamaController;
use App\Http\Controllers\OrganisController as adminOrganisController;
use App\Http\Controllers\PanduanakademikController as adminPanduanakademikController;
use App\Http\Controllers\PemakaianController as adminPemakaianController;
use App\Http\Controllers\ProducController as adminProducController;
use App\Http\Controllers\ProdukSofdeletedController as adminProdukSofdeletedController;
use App\Http\Controllers\ProfillulusController as adminProfillulusController;
use App\Http\Controllers\RencanastrategiController as adminRencanastrategiController;
use App\Http\Controllers\SejarahpmimController as adminSejarahpmimController;
use App\Http\Controllers\SemesterduaController as adminSemesterduaController;
use App\Http\Controllers\SemestersatuController as adminSemestersatuController;
use App\Http\Controllers\SemestertigaController as adminSemestertigaController;
use App\Http\Controllers\StafController as adminStafController;
use App\Http\Controllers\VisimisiController as adminVisimisiController;


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


// route data kirim ke halaman utama ke user
// route blog
Route::get('/', [UserHomeController::class, 'index']);
Route::get('post-detail/{id}/show', [UserHomeController::class, 'show'])->name('post.show');
Route::get('/blog-posts', [UserHomeController::class, 'blogpost'])->name('blog');
// route produk
Route::get('/produks', [UserProdukController::class, 'index']);
Route::get('produks-detail/{id}/show', [UserProdukController::class, 'show'])->name('produks.show');
// route cara pemakaian
Route::get('/cara-pemakaian', [UserPemakaianController::class, 'index']);
// contact
Route::get('/contact', function () {
    return view('home.contact');
});
// Sejarah
Route::get('/sejarah-pmim', [UserSejarahpmimController::class, 'index']);
// Akreditasi
Route::get('/akreditas-ppimfe', function () {
    $akreditas = UserAkreditas::orderBy('created_at', 'desc')->get();
    return View('home.profil.akreditasi', compact('akreditas'));
});
// visi, misi, tujuan
Route::get('/visi-misi-tujuan', function () {
    $visimisi = UserVisiMisi::all();
    return View('home.profil.visi-misi', compact('visimisi'));
});

// profil lusan
Route::get('/profil-lulusan', function () {
    $profillulus = UserProfillulus::all();
    return view('home.profil.profillulusan', compact('profillulus'));
});
Route::get('/kerja-sama-aliansi', function () {
    $kerjasama = UserKerjasama::orderBy('created_at', 'desc')->get();
    return view('home.profil.kerjasama', compact('kerjasama'));
});
Route::get('/rencana-strategi', function () {
    $rencana = UserRencanastrategi::orderBy('created_at', 'desc')->get();
    return view('home.profil.rencanastrategi', compact('rencana'));
});
Route::get('/truktur-organisasi', function () {
    $organnis = UserOrganis::orderBy('created_at', 'desc')->get();
    return view('home.profil.trukturorgan', compact('organnis'));
});
Route::get('/page-staf', function () {
    $datastaf = UserStaf::all();
    return view('home.profil.staf', compact('datastaf'));
});
Route::get('/daftar-dosen', function () {
    $dosen = UserDaftardosen::all();
    return view('home.profil.daftardosen', compact('dosen'));
});

// Truktur Kurikulum
Route::get('/truktur-kurikulum', function () {
    return view('home.akademik.kurikulum');
});
Route::get('/kurikulum-semesterI', function () {
    $semester1 = UserSemestersatu::all();
    return view('home.akademik.kurikulum.semestersatu', compact('semester1'));
});
Route::get('/kurikulum-semesterII', function () {
    $semester2 = UserSemesterdua::all();
    return view('home.akademik.kurikulum.semesterdua', compact('semester2'));
});
Route::get('/kurikulum-semesterIII', function () {
    $semester3 = UserSemestertiga::all();
    return view('home.akademik.kurikulum.semestertiga', compact('semester3'));
});
Route::get('/kurikulum-semesterIV', function () {
    return view('home.akademik.kurikulum.semesterempat');
});
Route::get('/kelender-akademik', function () {
    $kelenderakademik = UserKelender::orderBy('created_at', 'desc')->get();
    return view('home.akademik.kelender', compact('kelenderakademik'));
});
Route::get('/panduan-akademik', function () {
    $panduanakademik = UserPanduanakademik::orderBy('created_at', 'desc')->get();
    return view('home.akademik.panduanakademik', compact('panduanakademik'));
});


// perbaikan dari Nas untuk user & admin
// dashboard
Route::get('/dashboard', function () {
    $menuDashbord = 'active';
    return view('dashboard', compact('menuDashbord'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('data-user', UserDatadiriUserController::class);
});



// perbaikan dari Nas untuk admin
// dashboard
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', adminUserController::class);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('produk', adminProducController::class);
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('categoryproduk', adminCategoryProdukController::class);
});
Route::get('/produkDelete', [adminProdukSofdeletedController::class, 'postsdel'])->middleware('auth', 'admin');
Route::get('/produk/{id}/restore', [adminProdukSofdeletedController::class, 'restore'])->middleware('auth', 'admin');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('posts', adminDashboardPostController::class);
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('category', adminCategoryController::class);
});
Route::get('/dataDelete', [SofdeletedController::class, 'postsdel'])->middleware('auth', 'admin');
Route::get('/data/{id}/restore', [SofdeletedController::class, 'restore'])->middleware('auth', 'admin');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('pemakaian', adminPemakaianController::class);
});
Route::get('/pakaiDelete', [adminPemakaianController::class, 'postsdel'])->middleware('auth', 'admin');
Route::get('/pakai/{id}/restore', [adminPemakaianController::class, 'restore'])->middleware('auth', 'admin');

// Bagian Menu Profil
Route::middleware(['auth'])->group(function () {
    Route::resource('sejarahpmim', adminSejarahpmimController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('akreditas', adminAkreditasController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('visimisi', adminVisimisiController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('profillulus', adminProfillulusController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('kerjasama', adminKerjasamaController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('rencanastrategi', adminRencanastrategiController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('organis', adminOrganisController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('staf', adminStafController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('daftardosen', adminDaftardosenController::class);
});

// Bagian Menu Akademik
Route::middleware(['auth'])->group(function () {
    Route::resource('semestersatu', adminSemestersatuController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('semesterdua', adminSemesterduaController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('semestertiga', adminSemestertigaController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('kelender', adminKelenderController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('panduanakademik', adminPanduanakademikController::class);
});


// not found
Route::fallback(function () {
    return response()->view('home.notfound');
});
require __DIR__ . '/auth.php';
