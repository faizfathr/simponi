<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataRequestController;
use App\Livewire\Dashboard\Kalender;
use App\Livewire\Login\Index;
use App\Livewire\Index as Home;

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle);
});

Route::get('/', Home::class)->name('home');

Route::get('/login', Index::class)->name('login');

Route::get('/kalender', Kalender::class)->name('kalender');

Route::prefix('/dashboard')->group(function () {
    Route::get('/detail-monitoring/{id}', [DashboardController::class, 'pageDetail'])->name('dashboard.detail-monitoring');
    Route::post('/data', [DashboardController::class, 'data']);
    Route::post('/dataPersentase', [DashboardController::class, 'dataInPersentase']);
    Route::get('/downloadTemplate/{idTabel}', [DashboardController::class, 'downloadTabel']);
    Route::get('/listJadwal', [DashboardController::class, 'listJadwal']);
    Route::get('/logout', [DashboardController::class, 'logout']);
});

