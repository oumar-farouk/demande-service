<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CitoyenController;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\DemandePiecesController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard','App\Http\Controllers\DashboardController@index')->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/download/{file}', [FileController::class, 'download'])->name('file.download');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('services/add-piece/{service}', 'App\Http\Controllers\ServiceController@createpiece')->middleware(['auth', 'verified'])->name('services.addpiece');
Route::post('services/store-piece', 'App\Http\Controllers\ServiceController@storepiece')->middleware(['auth', 'verified'])->name('services.storepiece');
Route::get('services/edit-piece/{service}', 'App\Http\Controllers\ServiceController@editpiece')->middleware(['auth', 'verified'])->name('services.editpiece');
Route::put('services/update-piece', 'App\Http\Controllers\ServiceController@updatepiece')->middleware(['auth', 'verified'])->name('services.updatepiece');
Route::delete('services/delete-piece', 'App\Http\Controllers\ServiceController@destroypiece')->middleware(['auth', 'verified'])->name('services.destroypiece');
Route::resource('services', ServiceController::class)->middleware(['auth', 'verified']);

Route::resource('citoyens', CitoyenController::class)->middleware(['auth', 'verified']);
Route::resource('pieces', PieceController::class)->middleware(['auth', 'verified']);

Route::get('demandes/add-piece/{demande}', 'App\Http\Controllers\DemandeController@addDemandePiece')->middleware(['auth', 'verified'])->name('demandes.addpiece');
Route::post('demandes/store-piece', 'App\Http\Controllers\DemandeController@storeDemandePiece')->middleware(['auth', 'verified'])->name('demandes.storepiece');

Route::resource('demandes', DemandeController::class)->middleware(['auth', 'verified']);

Route::resource('demandepieces', DemandePiecesController::class)->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
