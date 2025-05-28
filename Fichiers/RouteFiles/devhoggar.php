<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


Route::get('/admin/crud-generator',[\App\Http\Controllers\Hoggar\DevGenerator\Page1Controller::class, 'index'])->middleware('auth');
Route::post('/admin/crud-generator/create',[\Hoggarcrud\Hoggar\Generator\Hoggarcrud::class, 'create'])->middleware('auth');
        
Route::get('/admin/wizard-generator', [\App\Http\Controllers\Hoggar\DevGenerator\Page2Controller::class, 'index'])->middleware('auth');
Route::post('/admin/wizard-generator/create', [\Hoggarcrud\Hoggar\Generator\Hoggarcrud::class, 'create2'])->middleware('auth');

Route::get('/admin/route-generator', [\App\Http\Controllers\Hoggar\DevGenerator\Page3Controller::class, 'index'])->middleware('auth');
Route::post('/admin/route-generator/delete', [\App\Http\Controllers\Hoggar\DevGenerator\Page3Controller::class, 'delete'])->middleware('auth');
Route::post('/admin/route-generator/updateActive', [\App\Http\Controllers\Hoggar\DevGenerator\Page3Controller::class, 'updateActive'])->middleware('auth');
Route::get('/admin/route-generator/create',[\App\Http\Controllers\Hoggar\DevGenerator\Page4Controller::class, 'index'])->middleware('auth');
Route::post('/admin/route-generator/creator',[\App\Http\Controllers\Hoggar\DevGenerator\Page4Controller::class, 'ajouter'])->middleware('auth');
Route::get('/admin/route-generator/edit/{id}', [\App\Http\Controllers\Hoggar\DevGenerator\Page5Controller::class, 'index'])->middleware('auth');
Route::post('/admin/route-generator/edit/record', [\App\Http\Controllers\Hoggar\DevGenerator\Page5Controller::class, 'store'])->middleware('auth');

Route::get('/admin/login',[\App\Http\Controllers\Hoggar\DevGenerator\Page6Controller::class, 'index'])->middleware('guest');
Route::post('/admin/login',[\App\Http\Controllers\Hoggar\DevGenerator\Page6Controller::class, 'login']);
Route::post('/admin/logout',[\App\Http\Controllers\Hoggar\DevGenerator\Page6Controller::class, 'logout']);

