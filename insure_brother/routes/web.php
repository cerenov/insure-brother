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

Route::get('/', [InsuranceController::class, 'indexForClient'])->name('home');
Route::get('/insurance/{id}/read-client', [InsuranceController::class, 'readForClient'])->name('read_insurance_for_client');
Route::post('/response/create', [ResponseController::class, 'create'])->name('create_response');

Route::middleware(['auth'])->group(function () {
    Route::get('/insurance/create', function () {
        return view('users.new_insurance');
    })->name('create_insurance');
    Route::get('/dashboard', [InsuranceController::class, 'index'])->name('dashboard');
    Route::post('/insurance/create', [InsuranceController::class, 'create'])->name('create_insurance');
    Route::get('/insurance/{id}/read', [InsuranceController::class, 'read'])->name('read_insurance');
    Route::post('/insurance/{id}/update', [InsuranceController::class, 'update'])->name('update_insurance');
    Route::post('/insurance/{id}/delete', [InsuranceController::class, 'delete'])->name('delete_insurance');
    Route::get('/responses', [ResponseController::class, 'index'])->name('index_response');
    Route::get('/responses/{id}/read', [ResponseController::class, 'read'])->name('read_response');
});

require __DIR__ . '/auth.php';
