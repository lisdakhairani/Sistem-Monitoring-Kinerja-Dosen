<?php



// User
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\JabatanAkademikController;
use App\Http\Controllers\PangkatController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\KinerjaController;
use App\Http\Controllers\DataKinerjaController;
use App\Http\Controllers\KinerjaPenelitianController;
use App\Http\Controllers\KinerjaPengabdianController;
use App\Http\Controllers\KinerjaPenunjangController;
use App\Http\Controllers\KinerjaPengajaranController;
use App\Http\Controllers\AkunDosenController;
use App\Http\Controllers\AkunAdminController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\AdminMonitoringController;
use App\Http\Controllers\PenelitianUserController;
use App\Http\Controllers\PengajaranController;


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
Route::get('/', [MonitoringController::class, 'index'])->name('bagianawal');


Route::middleware(['auth'])->group(function () {
    Route::get('/admins/dashboard', [MonitoringController::class, 'dashboardAdmin'])->name('dashboard.admin');
    Route::get('/admin/dashboard/filter', [MonitoringController::class, 'filterDashboardData'])->name('admin.dashboard.filter');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users/dashboard', [MonitoringController::class, 'dashboardUser'])->name('dashboard.user');

});





// perbaikan dari Nas untuk user & admin
// dashboard
Route::get('/dashboard', function () {
    $menuDashbord = 'active';
    return view('dashboard', compact('menuDashbord'));
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth', )->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Admin
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::resource('semester', SemesterController::class)
            ->only(['index', 'store', 'update', 'destroy']);
        Route::resource('mata-kuliah', MataKuliahController::class)
            ->only(['index', 'store', 'update', 'destroy']);
        Route::resource('jabatan-akademik', JabatanAkademikController::class)
            ->only(['index', 'store', 'update', 'destroy']);
        Route::resource('pangkat', PangkatController::class)
            ->only(['index', 'store', 'update', 'destroy']);
        Route::resource('kinerja', KinerjaController::class)
            ->only(['index', 'update', 'show', 'edit']);
        Route::post('/kinerja/update-score/{kinerja}', [KinerjaController::class, 'updateScore'])->name('kinerja.updateScore');
        Route::get('/kinerja/{kinerja}/export-excel', [KinerjaController::class, 'exportExcel'])->name('kinerja.export.excel');
        Route::get('/kinerja/{kinerja}/export-pdf', [KinerjaController::class, 'exportPdf'])->name('kinerja.export.pdf');
        // Add these new routes for filtered exports
        Route::get('/kinerja/export/filtered-excel', [KinerjaController::class, 'exportFilteredExcel'])->name('kinerja.export.filtered.excel');
        Route::get('/kinerja/export/filtered-pdf', [KinerjaController::class, 'exportFilteredPdf'])->name('kinerja.export.filtered.pdf');
        Route::resource('akun-admin', AkunAdminController::class)
            ->only(['index', 'store', 'update', 'destroy']);
        Route::resource('akun-dosen', AkunDosenController::class)
            ->only(['index', 'store', 'update', 'destroy']);
    });
});

// Route Users/Dosen
Route::middleware(['auth'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::resource('data-kinerja', DataKinerjaController::class)
            ->only(['index', 'store', 'update', 'destroy']);
        Route::put('/data-kinerja/update-stored/{id}', [DataKinerjaController::class, 'updateStored'])->name('data-kinerja.updateStored');
        Route::resource('kinerja-penelitian', KinerjaPenelitianController::class)
            ->only(['index', 'store', 'update', 'show', 'destroy']);
        Route::resource('kinerja-pengajaran', KinerjaPengajaranController::class)
            ->only(['index', 'store', 'update', 'show', 'destroy']);
        Route::resource('kinerja-pengabdian', KinerjaPengabdianController::class)
            ->only(['index', 'store', 'update', 'show', 'destroy']);
        Route::resource('kinerja-penunjang', KinerjaPenunjangController::class)
            ->only(['index', 'store', 'update', 'show', 'destroy']);
        Route::resource('arsip', ArsipController::class)
            ->only(['index', 'update', 'show']);
        Route::post('/arsip/update-score/{arsip}', [ArsipController::class, 'updateScore'])->name('arsip.updateScore');
        Route::get('/arsip/{arsip}/export-excel', [ArsipController::class, 'exportExcel'])->name('arsip.export.excel');
        Route::get('/arsip/{arsip}/export-pdf', [ArsipController::class, 'exportPdf'])->name('arsip.export.pdf');
    });
});



// Route Page not found
Route::fallback(function () {
    return response()->view('home.notfound');
});
require __DIR__ . '/auth.php';
