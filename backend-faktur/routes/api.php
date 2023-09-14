<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BarangController;
use App\Http\Controllers\API\FakturController;
use App\Http\Controllers\API\ItemFakturController;
use App\Http\Controllers\API\PelangganController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rute untuk Register dan Login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);


    // Rute untuk Barang
    Route::get('/barang', [BarangController::class, 'index']);
    Route::get('/barang/{id}', [BarangController::class, 'show']);
    Route::post('/barang', [BarangController::class, 'store']);
    Route::put('/barang/{id}', [BarangController::class, 'update']);
    Route::delete('/barang/{id}', [BarangController::class, 'destroy']);

    // Rute untuk Faktur
    Route::get('/faktur', [FakturController::class, 'index']);
    Route::get('/faktur/{id}', [FakturController::class, 'show']);
    Route::post('/faktur', [FakturController::class, 'store']);
    Route::put('/faktur/{id}', [FakturController::class, 'update']);
    Route::delete('/faktur/{id}', [FakturController::class, 'destroy']);
    Route::get('/faktur/search-by-date', [FakturController::class, 'searchByDate']);

    // Rute untuk Item Faktur
    Route::get('/item-faktur', [ItemFakturController::class, 'index']);
    Route::get('/item-faktur/{id}', [ItemFakturController::class, 'show']);
    Route::post('/item-faktur', [ItemFakturController::class, 'store']);
    Route::put('/item-faktur/{id}', [ItemFakturController::class, 'update']);
    Route::delete('/item-faktur/{id}', [ItemFakturController::class, 'destroy']);

    // Rute untuk Pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index']);
    Route::get('/pelanggan/{id}', [PelangganController::class, 'show']);
    Route::post('/pelanggan', [PelangganController::class, 'store']);
    Route::put('/pelanggan/{id}', [PelangganController::class, 'update']);
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy']);
});
