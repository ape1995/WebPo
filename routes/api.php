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

Route::get('get-total-amount-by-id/{id}',[App\Http\Controllers\SalesOrderController::class, 'getAmountById']);
Route::get('get-inventory-data/{code}/{customer}/{date}',[App\Http\Controllers\SalesOrderController::class, 'getPrice']);
Route::get('get-inventory-data-2/{code}/{rbp}/{date}',[App\Http\Controllers\PacketDiscountDetailController::class, 'getPrice']);
Route::get('get-pakcet-data/{code}',[App\Http\Controllers\PacketDiscountController::class, 'getPacketData']);
Route::get('getActivePackets/{code}/{user}',[App\Http\Controllers\PacketDiscountController::class, 'getActivePakcets']);
Route::get('cek-data-packet-code/{date}',[App\Http\Controllers\PacketDiscountController::class, 'getCode']);
Route::get('getAllCounter/{customer}/{date}',[App\Http\Controllers\CartController::class, 'getAllCounter']);
Route::get('getAllCounterPromo/{customer}/{date}',[App\Http\Controllers\CartPromoController::class, 'getAllCounter']);
Route::get('getAllCounterDiscount/{user}',[App\Http\Controllers\PacketDiscountDetailController::class, 'getAllCounter']);
Route::get('getAllCounterDiscountDetail/{code}',[App\Http\Controllers\PacketDiscountDetailController::class, 'getAllCounterDetail']);
Route::get('countOrderDetail/{code}/{date}',[App\Http\Controllers\SalesOrderDetailController::class, 'countOrderDetail']);
Route::get('countOrderPromoDetail/{code}/{date}',[App\Http\Controllers\SalesOrderPromoDetailController::class, 'countOrderDetail']);
Route::get('get-outlet-data/{code}', [App\Http\Controllers\EstimasiController::class, 'getOutletData']);
Route::get('update-ds-status/{code}', [App\Http\Controllers\DsRuleController::class, 'updateStatus']);
Route::resource('carts', App\Http\Controllers\API\CartAPIController::class);
route::get('get-promo-active/{date}/{user}', [App\Http\Controllers\PacketDiscountController::class, 'getPromoActive']);
route::get('get-promo-product-active/{date}/{user}/{type}', [App\Http\Controllers\BundlingProductController::class, 'getProductActive']);
Route::get('get-promo-data/{code}',[App\Http\Controllers\PacketDiscountController::class, 'getPromoData']);
Route::get('get-first-order-data/{customercode}',[App\Http\Controllers\CustomerFirstOrderController::class, 'getFirstOrder']);
Route::get('get-promo-hold-duration/{code}', [App\Http\Controllers\PromoHoldDurationController::class, 'getDataByCode']);
Route::get('validate-order-type/{code}/{user}/{deliverydate}', [App\Http\Controllers\CustomerFirstOrderController::class, 'validateOrderType']);
Route::get('get-gimmick-active/{code}/{deliverydate}', [App\Http\Controllers\BundlingGimmickController::class, 'getGimmickACtive']);
