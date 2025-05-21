<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataRequestController;

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle);
});

Route::get('/', function () {
    return view('home');
});

Route::get('/survei/pp-tpi', function () {
    return view('survei.pp-tpi');
});
Route::post('/createSpreadSheet', [HomeController::class, 'createSheet']);

Route::get('/login_sso', [HomeController::class, 'run']);

Route::prefix('/dashboard')->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/detail-monitoring/{id}', [DashboardController::class, 'pageDetail'])->name('dashboard.detail-monitoring');
    Route::post('/data', [DashboardController::class, 'data']);
    Route::post('/dataPersentase', [DashboardController::class, 'dataInPersentase']);
    Route::get('/downloadTemplate/{idTabel}', [DashboardController::class, 'downloadTabel']);
    Route::get('/listJadwal', [DashboardController::class, 'listJadwal']);
});
