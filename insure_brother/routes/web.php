<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\InsuranceController;
use \App\Http\Controllers\ResponseController;

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

Route::get('/', [ResponseController::class, 'index']);

Route::get('/dashboard', [InsuranceController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/insurance/create', function () {
    return view('insurance');
})->middleware('auth')->name('create_insurance');
Route::post('/insurance/create', [InsuranceController::class, 'create'])->middleware('auth')->name('create_insurance');
Route::get('/insurance/{id}/read', [InsuranceController::class, 'read'])->middleware('auth');
Route::post('/insurance/{id}/update', [InsuranceController::class, 'update'])->middleware('auth')->name('update_insurance');
Route::post('/insurance/{id}/delete', [InsuranceController::class, 'delete'])->middleware('auth')->name('delete_insurance');

require __DIR__ . '/auth.php';
