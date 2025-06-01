<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Livewire\Dashboard\MonitoringIpek;
use App\Livewire\Dashboard\MonitoringPertanian;
use App\Livewire\Login\Index;
use App\Livewire\Index as Home;

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle);
});

Route::get('/', Home::class)->name('home');

Route::get('/monitoring-pertanian', Home::class)->name('monitoring-pertanian');

Route::get('/monitoring-ipek', Home::class)->name('monitoring-ipek');

Route::get('/login', Index::class)->name('login');

Route::get('/kalender', Home::class)->name('kalender');

Route::middleware(['auth', 'role:admin,Staf Stat. Produksi,Kepala BPS'])->group(function(){
    Route::get('/target', Home::class)->name('target');
    
    Route::get('/progres-pertanian', Home::class)->name('progres-pertanian');
    
    Route::get('/progres-ipek', Home::class)->name('progres-ipek');
    
    Route::get('/detail-monitorin/{id}', Home::class)->name('detail-monitoring');
    
    Route::get('/dashboard/logout', [DashboardController::class, 'logout']);
});

Route::prefix('/dashboard')->group(function () {
    Route::post('/data', [DashboardController::class, 'data']);
    Route::post('/dataPersentase', [DashboardController::class, 'dataInPersentase']);
    Route::get('/downloadTemplate/{idTabel}', [DashboardController::class, 'downloadTabel']);
    Route::get('/downloadDirektori', [DashboardController::class, 'downloadDirektori']);
    Route::get('/listJadwal', [DashboardController::class, 'listJadwal']);
});

