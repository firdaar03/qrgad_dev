<?php

use App\Http\Controllers\Auth\Qrgad\LoginController;
use App\Http\Controllers\Cms\Qrgad\AsetController;
use App\Http\Controllers\Cms\Qrgad\PerusahaanController;
use App\Http\Controllers\Cms\Qrgad\DashboardController;
use App\Http\Controllers\Cms\Qrgad\FasilitasController;
use App\Http\Controllers\Cms\Qrgad\InventoryController;
use App\Http\Controllers\Cms\Qrgad\JadwalRuanganController;
use App\Http\Controllers\Cms\Qrgad\KategoriKonsumableController;
use App\Http\Controllers\Cms\Qrgad\KeluhanController;
use App\Http\Controllers\Cms\Qrgad\KendaraanController;
use App\Http\Controllers\Cms\Qrgad\KeranjangKonsumableController;
use App\Http\Controllers\Cms\Qrgad\KonsumableController;
use App\Http\Controllers\Cms\Qrgad\LokasiController;
use App\Http\Controllers\Cms\Qrgad\LokasiMaintainController;
use App\Http\Controllers\Cms\Qrgad\RuanganController;
use App\Http\Controllers\Cms\Qrgad\SubKategoriKonsumableController;
use App\Http\Controllers\Cms\Qrgad\SupirController;
use App\Http\Controllers\Cms\Qrgad\TripController;
use App\Http\Controllers\Cms\Qrgad\UserController;
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




Route::get('/', function() {
    return view('Qrgad/login/index');
 }) -> name('login')->middleware('guest');

Route::get('/login', function() {
    return view('Qrgad/login/index');
 }) -> name('login')->middleware('guest');
 
Route::post('/login',[LoginController::class, 'authenticate']);

Route::post('/logout',[LoginController::class, 'logout']);

Route::middleware('auth')->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'admin']);
    Route::get('/ruangan-dashboard-get-by-day/{id}', [DashboardController::class, 'getByDay']);
   
    //User
    Route::resource('/user', UserController::class);

    // Ruangan
    Route::resource('/ruangan', RuanganController::class);
    Route::get('/ruangan-report', [RuanganController::class, 'report']);
    Route::get('/ruangan-get-by-day/{id}', [RuanganController::class, 'getByDay']);

    // fasilitas
    Route::resource('/fasilitas', FasilitasController::class);
    Route::get('/fasilitas-read', [FasilitasController::class, 'read']);
    Route::get('/fasilitas-delete/{id}', [FasilitasController::class, 'delete']);

    // lokasi
    Route::resource('/lokasi', LokasiController::class);
    Route::get('/lokasi-read', [LokasiController::class, 'read']);
    Route::get('/lokasi-delete/{id}', [LokasiController::class, 'delete']);

    // jadwal ruangan
    Route::resource('/jadwal-ruangan', JadwalRuanganController::class);
    Route::get('/jadwal-ruangan-get-by-day', [JadwalRuanganController::class, 'getByDay']);
    Route::get('/jadwal-ruangan-validate-date', [JadwalRuanganController::class, 'validateDate']);
    Route::get('/jadwal-ruangan-history', [JadwalRuanganController::class, 'history']);
    Route::get('/jadwal-ruangan-ticket/{id}', [JadwalRuanganController::class, 'ticket']);
    // Route::get('/wa', [JadwalRuanganController::class, 'testWa']);
    
    // perusahaan
    Route::resource('/perusahaan', PerusahaanController::class);
    Route::get('/perusahaan-read', [PerusahaanController::class, 'read']);
    
    // keluhan
    Route::resource('/keluhan', KeluhanController::class);
    Route::get('/keluhan-dashboard', [KeluhanController::class, 'dashboard']);
    Route::get('/keluhan-dashboard-read/{type}', [KeluhanController::class, 'read']);
    Route::get('/keluhan-dashboard-confirm-response/{id}', [KeluhanController::class, 'confirmResponse']);
    Route::get('/keluhan-dashboard-edit-response/{id}', [KeluhanController::class, 'editResponse']);
    Route::post('/keluhan-dashboard-response/{id}', [KeluhanController::class, 'response']);
    Route::post('/keluhan-dashboard-update-response/{id}', [KeluhanController::class, 'updateResponse']);
    Route::get('/keluhan-dashboard-get-limit-stock/{id}', [KeluhanController::class, 'getLimitStock']);
    Route::get('/keluhan-dashboard-filter-sub-grup-aset/{id}', [KeluhanController::class, 'filterSubGrupAset']);
    Route::get('/keluhan-dashboard-input-action/{id}', [KeluhanController::class, 'inputAction']);
    Route::get('/keluhan-dashboard-input-close/{id}', [KeluhanController::class, 'inputClose']);
    Route::post('/keluhan-dashboard-action', [KeluhanController::class, 'action']);
    Route::post('/keluhan-dashboard-close', [KeluhanController::class, 'close']);

    // keranjang konsumable
    Route::resource('/keranjang', KeranjangKonsumableController::class);
    Route::get('/keranjang-view', [KeranjangKonsumableController::class, 'view']);

    // lokasi maintain
    Route::resource('/lokasi-maintain', LokasiMaintainController::class);
    Route::get('/lokasi-maintain-read', [LokasiMaintainController::class, 'read']);
    Route::get('/lokasi-maintain-delete/{id}', [LokasiMaintainController::class, 'delete']);
    
    // kategori konsumable
    Route::resource('/kategori-konsumable', KategoriKonsumableController::class);
    Route::get('/kategori-konsumable-read', [KategoriKonsumableController::class, 'read']);
    Route::get('/kategori-konsumable-delete/{id}', [KategoriKonsumableController::class, 'delete']);
    
    // sub kategori konsumable
    Route::resource('/sub-kategori-konsumable', SubKategoriKonsumableController::class);

     // konsumable
    Route::resource('/konsumable', KonsumableController::class);
    Route::get('/konsumable-filter/{id}', [KonsumableController::class, 'filterSubKategori']);

      // inventory
    Route::resource('/inventory', InventoryController::class);
    Route::get('/inventory-tambah/{id}', [InventoryController::class, 'tambah']);
    Route::get('/inventory-report', [InventoryController::class, 'report']);
    
    // kendaraan
    Route::resource('/kendaraan', KendaraanController::class);
    
    // supir
    Route::resource('/supir', SupirController::class);

    // aset
    Route::resource('/aset', AsetController::class);
    Route::post('/aset-import',[AsetController::class,'import']);
    Route::get('/aset-export',[AsetController::class,'exportAset']);
    Route::post('/import',[AsetController::class,'import']);
    Route::get('/export-aset',[AsetController::class,'exportAset']);
    
    // trip
    Route::resource('/trip', TripController::class);
    Route::get('/trip-schedule',[TripController::class,'schedule']);
    Route::get('/trip-schedule/{id}',[TripController::class,'showSchedule']);
    Route::post('/trip-read',[TripController::class,'read']);
    Route::post('/trip-read-schedule',[TripController::class,'readSchedule']);
    Route::get('/trip-confirm-approve/{id}',[TripController::class,'confirmApprove']);
    Route::get('/trip-approve/{id}',[TripController::class,'approve']);
    Route::get('/trip-confirm-reject/{id}',[TripController::class,'confirmReject']);
    Route::post('/trip-reject/{id}',[TripController::class,'reject']);
    Route::get('/trip-confirm-response/{id}',[TripController::class,'confirmResponse']);
    Route::get('/trip-response/{id}',[TripController::class,'response']);
    Route::get('/trip-pick-car/{id}',[TripController::class,'pickCar']);
    Route::post('/trip-confirm-set-trip/{id}',[TripController::class,'confirmSetTrip']);
    Route::post('/trip-set-trip/{id}',[TripController::class,'setTrip']);
    Route::get('/trip-ticket/{id}',[TripController::class,'ticket']);
    Route::get('/trip-check',[TripController::class,'checkTrip']);
    Route::get('/trip-check-scan',[TripController::class,'checkTripScan']);
    Route::get('/trip-check-id-trip/{id}',[TripController::class,'checkTripIdTrip']);
    Route::get('/trip-check/{id}',[TripController::class,'checkTripById']);
    Route::post('/trip-filter',[TripController::class,'tripFilter']);
    // Route::get('/trip-view/{id}',[TripController::class,'viewTrip']);
    Route::post('/trip-check-out',[TripController::class,'checkOut']);
    Route::post('/trip-check-in',[TripController::class,'checkIn']);
    
});


?>