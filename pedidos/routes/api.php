<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::resource('customers', CustomerController::class, ['except' => ['create', 'edit']]);
Route::resource('suppliers', SupplierController::class, ['except' => ['create', 'edit']]);
Route::resource('orders', OrderController::class, ['except' => ['create', 'edit']]);
Route::get('orders/{order}/codigo_rastreamento',[OrderController::class,'showCodigoRastreamento'])->name('orders.show.codigo_rastreamento');
