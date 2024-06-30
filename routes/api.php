<?php

use App\Http\Controllers\BahanMentahController;
use App\Http\Controllers\HasilProduksiController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// CRUD routes
Route::resource('users', UserController::class);

// Authentication routes
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);


Route::get('/suppliers', [SupplierController::class, 'index']);
Route::post('/suppliers', [SupplierController::class, 'store']);
Route::get('/suppliers/{id}', [SupplierController::class, 'show']);
Route::post('/suppliers/{id}', [SupplierController::class, 'updateSupplier']);
Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy']);

Route::get('/bahan-mentahs', [BahanMentahController::class, 'index']);
Route::post('/bahan-mentahs', [BahanMentahController::class, 'store']);
Route::get('/bahan-mentahs/{id}', [BahanMentahController::class, 'show']);
Route::post('/bahan-mentahs/{id}', [BahanMentahController::class, 'updateBahanMentah']);
Route::delete('/bahan-mentahs/{id}', [BahanMentahController::class, 'destroy']);

Route::get('/hasil-produksis', [HasilProduksiController::class, 'index']);
Route::post('/hasil-produksis', [HasilProduksiController::class, 'store']);
Route::get('/hasil-produksis/{id}', [HasilProduksiController::class, 'show']);
Route::post('/hasil-produksis/{id}', [HasilProduksiController::class, 'updateHasilProduksi']);
Route::delete('/hasil-produksis/{id}', [HasilProduksiController::class, 'destroy']);