<?php



// User
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DatadiriUserController as UserDatadiriUserController;
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
    Route::get('/dashboard-admin', [AdminMonitoringController::class, 'dashboard'])->name('dashboardadmin');
    Route::get('/penelitian-admin', [AdminMonitoringController::class, 'adminPenelitian'])->name('adminPenelitian');
    Route::post('/penelitian/nilai/{id}', [AdminMonitoringController::class, 'nilaiPenelitian'])->name('Penelitian.nilai');

    Route::get('/pengabdian-admin', [AdminMonitoringController::class, 'adminPengabdian'])->name('adminPengabdian');
    Route::post('/pengabdian/nilai/{id}', [AdminMonitoringController::class, 'nilaiPengabdian'])->name('Pengabdian.nilai');

    Route::get('/pengajaran-admin', [AdminMonitoringController::class, 'adminPengajaran'])->name('adminPengajaran');
    Route::post('/pengajaran/nilai/{id}', [AdminMonitoringController::class, 'nilaiPengajaran'])->name('Pengajaran.nilai');

    Route::get('/penunjang-admin', [AdminMonitoringController::class, 'adminPenunjang'])->name('adminPenunjang');
    Route::post('/penunjang/nilai/{id}', [AdminMonitoringController::class, 'nilaiPenunjang'])->name('Penunjang.nilai');

    Route::get('/data-user', [AdminMonitoringController::class, 'index'])->name('users');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard-user', [MonitoringController::class, 'dashboard'])->name('dashboarduser');
    Route::get('/penelitian-user', [MonitoringController::class, 'userPenelitian'])->name('userPenelitian');
    Route::post('/penelitian/store', [MonitoringController::class, 'storePenelitian'])->name('Penelitian.store');
    Route::put('/penelitian/update/{id}', [MonitoringController::class, 'updatePenelitian'])->name('Penelitian.update');
    Route::delete('/penelitian/delete/{id}', [MonitoringController::class, 'deletePenelitian'])->name('Penelitian.delete');

    Route::get('/pengabdian-user', [MonitoringController::class, 'userPengabdian'])->name('userPengabdian');
    Route::post('/pengabdian/store', [MonitoringController::class, 'storePengabdian'])->name('Pengabdian.store');
    Route::put('/pengabdian/update/{id}', [MonitoringController::class, 'updatePengabdian'])->name('Pengabdian.update');
    Route::delete('/delete/{id}', [MonitoringController::class, 'deletePengabdian'])->name('Pengabdian.delete');

    Route::get('/pengajaran-user', [MonitoringController::class, 'userPengajaran'])->name('userPengajaran');
    Route::post('/pengajaran/store', [MonitoringController::class, 'storePengajaran'])->name('Pengajaran.store');
    Route::put('/pengajaran/update/{id}', [MonitoringController::class, 'updatePengajaran'])->name('Pengajaran.update');
    Route::delete('/pengajaran/delete/{id}', [MonitoringController::class, 'deletePengajaran'])->name('Pengajaran.delete');

    Route::get('/penunjang-user', [MonitoringController::class, 'userPenunjang'])->name('userPenunjang');
    Route::post('/penunjang/store', [MonitoringController::class, 'storePenunjang'])->name('Penunjang.store');
    Route::put('/penunjang/update/{id}', [MonitoringController::class, 'updatePenunjang'])->name('Penunjang.update');
    Route::delete('/penunjang/delete/{id}', [MonitoringController::class, 'deletePenunjang'])->name('Penunjang.delete');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/penelitian-user', [PenelitianUserController::class, 'index'])->name('Penelitian.index');
    Route::post('/penelitian-user/store', [PenelitianUserController::class, 'store'])->name('Penelitian.store');
    Route::put('/penelitian-user/update/{id}', [PenelitianUserController::class, 'update'])->name('Penelitian.update');
    Route::delete('/penelitian-user/delete/{id}', [PenelitianUserController::class, 'destroy'])->name('Penelitian.delete');
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

Route::middleware(['auth',])->group(function () {
    Route::resource('data-user', UserDatadiriUserController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::get('/penelitian/user', [PenelitianUserController::class, 'index'])->name('userPenelitian');
});
Route::get('/pengajaran', [PengajaranController::class, 'index'])->name('Pengajaran.index');
Route::post('/pengajaran/store', [PengajaranController::class, 'store'])->name('Pengajaran.store');
Route::put('/pengajaran/update/{id}', [PengajaranController::class, 'update'])->name('Pengajaran.update');
Route::delete('/pengajaran/delete/{id}', [PengajaranController::class, 'destroy'])->name('Pengajaran.delete');


// not found
Route::fallback(function () {
    return response()->view('home.notfound');
});
require __DIR__ . '/auth.php';
