<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Livewire\Login\Index;
use App\Livewire\Index as Home;

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle);
});

Route::get('/', Home::class)->name('home');

Route::get('/login', Index::class)->name('login');

Route::get('/dashboard', Home::class)->name('dashboard');

Route::get('/kalender', Home::class)->name('kalender');

Route::get('/target', Home::class)->name('target');

Route::get('/detail-monitorin/{id}', Home::class)->name('detail-monitoring');

Route::prefix('/dashboard')->group(function () {
    Route::post('/data', [DashboardController::class, 'data']);
    Route::post('/dataPersentase', [DashboardController::class, 'dataInPersentase']);
    Route::get('/downloadTemplate/{idTabel}', [DashboardController::class, 'downloadTabel']);
    Route::get('/listJadwal', [DashboardController::class, 'listJadwal']);
    Route::get('/logout', [DashboardController::class, 'logout']);
});

