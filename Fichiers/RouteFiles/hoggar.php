<?php




use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/admin', [\App\Http\Controllers\Hoggar\Dashboard\DashboardController::class, 'index'])->middleware('auth');