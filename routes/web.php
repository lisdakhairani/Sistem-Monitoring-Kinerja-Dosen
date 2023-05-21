<?php

use App\Models\Category;
use Illuminate\Pagination\Paginator;

// User
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProdukController as UserProdukController;
use App\Http\Controllers\UserPemakaianController as UserPemakaianController;
use App\Http\Controllers\DatadiriUserController as UserDatadiriUserController;
use App\Http\Controllers\UserSejarahpmimController as UserSejarahpmimController;
use App\Http\Controllers\UserpageController as UserpageController;

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
use App\Models\Galeriakademik as UserGaleriakademik;
use App\Models\Downloadakademik as UserDownloadakademik;
use App\Models\Semesterempat as UserSemesterempat;
use App\Models\Administrasi as UserAdministrasi;
use App\Models\Penjaminanmutu as adminPenjaminanmutu;
use App\Models\Akreditasi as UserAkreditasi;
use App\Models\Prestasisiswa as UserPrestasisiswa;
use App\Models\Tracerstudy as UserTracerstudy;
use App\Models\Publikasi as UserPublikasi;

// Admin
use App\Http\Controllers\SofdeletedController;
use App\Http\Controllers\PostController as UserHomeController;
use App\Http\Controllers\UserController as adminUserController;
use App\Http\Controllers\adminCategoryController as adminCategoryController;
use App\Http\Controllers\AdministrasiController as adminAdministrasiController;
use App\Http\Controllers\AkreditasController as adminAkreditasController;
use App\Http\Controllers\AkreditasiController as AdminAkreditasiController;
use App\Http\Controllers\CategoryProdukController as adminCategoryProdukController;
use App\Http\Controllers\DaftardosenController as adminDaftardosenController;
use App\Http\Controllers\DashboardPostController as adminDashboardPostController;
use App\Http\Controllers\DownloadakademikController as adminDownloadakademikController;
use App\Http\Controllers\GaleriakademikController as adminGaleriakademikController;
use App\Http\Controllers\KelenderController as adminKelenderController;
use App\Http\Controllers\KerjasamaController as adminKerjasamaController;
use App\Http\Controllers\OrganisController as adminOrganisController;
use App\Http\Controllers\PanduanakademikController as adminPanduanakademikController;
use App\Http\Controllers\PemakaianController as adminPemakaianController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PenjaminanmutuController as adminPenjaminanmutuController;
use App\Http\Controllers\PrestasisiswaController;
use App\Http\Controllers\ProducController as adminProducController;
use App\Http\Controllers\ProdukSofdeletedController as adminProdukSofdeletedController;
use App\Http\Controllers\ProfillulusController as adminProfillulusController;
use App\Http\Controllers\PublikasiController as adminPublikasiController;
use App\Http\Controllers\RencanastrategiController as adminRencanastrategiController;
use App\Http\Controllers\SejarahpmimController as adminSejarahpmimController;
use App\Http\Controllers\SemesterduaController as adminSemesterduaController;
use App\Http\Controllers\SemesterempatController as adminSemesterempatController;
use App\Http\Controllers\SemestersatuController as adminSemestersatuController;
use App\Http\Controllers\SemestertigaController as adminSemestertigaController;
use App\Http\Controllers\StafController as adminStafController;
use App\Http\Controllers\TracerstudyController as adminTracerstudyController;
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

// Menu Profil
Route::controller(UserpageController::class)->group(function () {
    Route::get('/sejarah-pmim', 'sejarah')->name('sejarah-pmim');
    Route::get('/akreditas-ppimfe', 'akreditasppimfe')->name('akreditas-ppimfe');
    Route::get('/visi-misi-tujuan', 'visimisi')->name('visi-misi-tujuan');
    Route::get('/profil-lulusan', 'Profillulus')->name('profil-lulusan');
    Route::get('/kerja-sama-aliansi', 'kerjasama')->name('kerja-sama-aliansi');
    Route::get('/rencana-strategi', 'rencana')->name('rencana-strategi');
    Route::get('/truktur-organisasi', 'organnis')->name('truktur-organisasi');
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
    $semester4 = UserSemesterempat::all();
    return view('home.akademik.kurikulum.semesterempat', compact('semester4'));
});
Route::get('/kelender-akademik', function () {
    $kelenderakademik = UserKelender::orderBy('created_at', 'desc')->get();
    return view('home.akademik.kelender', compact('kelenderakademik'));
});
Route::get('/panduan-akademik', function () {
    $panduanakademik = UserPanduanakademik::orderBy('created_at', 'desc')->get();
    return view('home.akademik.panduanakademik', compact('panduanakademik'));
});
Route::get('/galeri-akademik', function () {
    $galeriaka = UserGaleriakademik::orderBy('created_at', 'desc')->get();
    return view('home.akademik.galeri', compact('galeriaka'));
});
Route::get('/download-akademik', function () {
    $downloadakademik = UserDownloadakademik::orderBy('created_at', 'desc')->get();
    return view('home.akademik.download', compact('downloadakademik'));
});
// Menu Download
Route::get('/download-adminis', function () {
    $downadministrasi = UserAdministrasi::orderBy('created_at', 'desc')->get();
    return view('home.download.downloadadmis', compact('downadministrasi'));
});
Route::get('/download-penjaminan-mutu', function () {
    $downpenjaminanmutu = adminPenjaminanmutu::orderBy('created_at', 'desc')->get();
    return view('home.download.penjaminanmutu', compact('downpenjaminanmutu'));
});

Route::get('/akreditasi-akademik', function () {
    $UserAkreditasi = UserAkreditasi::orderBy('created_at', 'asc')->paginate(5);
    $UserAkreditasi->appends(request()->query());
    Paginator::useBootstrap();
    return view('home.download.akreditasi', compact('UserAkreditasi'));
});

// Kemahasiswaan
Route::get('/prestasi-mahasiswa', function () {
    $prestasimhs = UserPrestasisiswa::orderBy('created_at', 'desc')->get();
    return view('home.kemahasiswaan.prestasimas', compact('prestasimhs'));
});
Route::get('/tracer-study', function () {
    $traceruser = UserTracerstudy::orderBy('created_at', 'desc')->paginate(5);
    $traceruser->appends(request()->query());
    Paginator::useBootstrap();
    return view('home.kemahasiswaan.tracer', compact('traceruser'));
});
Route::get('/publikasiuser', function () {
    $publikasiuser = UserPublikasi::orderBy('created_at', 'desc')->paginate(5);
    $publikasiuser->appends(request()->query());
    Paginator::useBootstrap();
    return view('home.kemahasiswaan.publikasi', compact('publikasiuser'));
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
    Route::resource('produk', adminProducController::class);
    Route::resource('categoryproduk', adminCategoryProdukController::class);
    Route::resource('posts', adminDashboardPostController::class);
    Route::resource('category', adminCategoryController::class);
    Route::resource('pemakaian', adminPemakaianController::class);
});

Route::get('/produkDelete', [adminProdukSofdeletedController::class, 'postsdel'])->middleware('auth', 'admin');
Route::get('/produk/{id}/restore', [adminProdukSofdeletedController::class, 'restore'])->middleware('auth', 'admin');

Route::get('/dataDelete', [SofdeletedController::class, 'postsdel'])->middleware('auth', 'admin');
Route::get('/data/{id}/restore', [SofdeletedController::class, 'restore'])->middleware('auth', 'admin');

Route::get('/pakaiDelete', [adminPemakaianController::class, 'postsdel'])->middleware('auth', 'admin');
Route::get('/pakai/{id}/restore', [adminPemakaianController::class, 'restore'])->middleware('auth', 'admin');

// Bagian Menu Profil
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('sejarahpmim', adminSejarahpmimController::class);
    Route::resource('akreditas', adminAkreditasController::class);
    Route::resource('visimisi', adminVisimisiController::class);
    Route::resource('profillulus', adminProfillulusController::class);
    Route::resource('kerjasama', adminKerjasamaController::class);
    Route::resource('rencanastrategi', adminRencanastrategiController::class);
    Route::resource('organis', adminOrganisController::class);
    Route::resource('staf', adminStafController::class);
    Route::resource('daftardosen', adminDaftardosenController::class);
});

// Bagian Menu Akademik
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('semestersatu', adminSemestersatuController::class);
    Route::resource('semesterdua', adminSemesterduaController::class);
    Route::resource('semestertiga', adminSemestertigaController::class);
    Route::resource('semesterempat', adminSemesterempatController::class);
    Route::resource('kelender', adminKelenderController::class);
    Route::resource('panduanakademik', adminPanduanakademikController::class);
    Route::resource('galeriakademik', adminGaleriakademikController::class);
    Route::resource('downloadakademik', adminDownloadakademikController::class);
});

// Download
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('administrasi', adminAdministrasiController::class);
    Route::resource('penjaminanmutu', adminPenjaminanmutuController::class);
    Route::resource('akreditasi', AdminAkreditasiController::class);
});

// Kemahasiswaan
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('tracerstudy', adminTracerstudyController::class);
    Route::resource('publikasi', adminPublikasiController::class);
    Route::resource('prestasisiswa', PrestasisiswaController::class);
});

// PengunjungController
Route::post('/record-visitor', [PengunjungController::class, 'recordVisitor']);




// not found
Route::fallback(function () {
    return response()->view('home.notfound');
});
require __DIR__ . '/auth.php';