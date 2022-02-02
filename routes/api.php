<?php

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

Route::get('get-inventory-data/{code}/{customer}',[App\Http\Controllers\SalesOrderController::class, 'getPrice']);
Route::get('getAllCounter/{customer}/{date}',[App\Http\Controllers\CartController::class, 'getAllCounter']);
Route::get('countOrderDetail/{code}/{date}',[App\Http\Controllers\SalesOrderDetailController::class, 'countOrderDetail']);

Route::resource('carts', App\Http\Controllers\API\CartAPIController::class);
