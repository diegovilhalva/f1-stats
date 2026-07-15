<?php


use App\Http\Controllers\RaceController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\StandingController;

Route::get('/', [SeasonController::class, 'index'])->name('seasons.index');
Route::get('/seasons/{season:year}', [SeasonController::class, 'show'])->name('seasons.show');
Route::get('/seasons/{season:year}/standings', [StandingController::class, 'index'])->name('standings.index');
Route::get('/seasons/{season:year}/races/{round}', [RaceController::class, 'show'])->name('races.show');
