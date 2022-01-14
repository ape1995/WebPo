<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SalesOrderDetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReportController;

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

Route::get('/', function () {
    return redirect()->to('home');
});

Auth::routes(['verify' => true]);
//routing admin cms
Route::group(['middleware' => ['auth']], function(){
    Route::resource('users', 'App\Http\Controllers\UserController');
    Route::resource('roles', 'App\Http\Controllers\RoleController');
    Route::get('dataTableUser',[UserController::class,'dataTable'])->name('users.data');
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::resource('salesOrders', SalesOrderController::class)->except('create');
    Route::get('dataTableSalesOrder',[SalesOrderController::class,'dataTable'])->name('salesOrders.data');
    Route::get('submitOrder/{code}',[SalesOrderController::class,'submitOrder'])->name('salesOrders.submitOrder');
    Route::get('cancelOrder/{code}',[SalesOrderController::class,'cancelOrder'])->name('salesOrders.cancelOrder');
    Route::get('processOrder/{code}',[SalesOrderController::class,'processOrder'])->name('salesOrders.processOrder');
    Route::post('rejectOrder',[SalesOrderController::class,'rejectOrder'])->name('salesOrders.rejectOrder');
    Route::get('printOrder/{code}',[SalesOrderController::class,'printPdf'])->name('salesOrders.printPdf');
    Route::get('resetOrder',[SalesOrderController::class,'resetOrder'])->name('salesOrders.resetOrder');
    Route::get('createOrder', [SalesOrderController::class, 'create'])->name('createOrder');
    Route::resource('salesOrderDetails', SalesOrderDetailController::class);
    Route::get('dataTableSalesOrderDetail/{code}',[SalesOrderDetailController::class,'getData'])->name('salesOrder.dataDetail');
    Route::resource('carts', CartController::class)->except('create');
    Route::get('dataTableCart',[CartController::class,'getData'])->name('carts.data');
    Route::post('updatePassword', [UserController::class, 'updatePassword'])->name('updatePassword');
    Route::get('reportSalesOrder', [ReportController::class, 'index'])->name('reportSalesOrder.index');
    Route::post('reportSalesOrder', [ReportController::class, 'view'])->name('reportSalesOrder.view');
    Route::get('reportSalesOrderDetail', [ReportController::class, 'detailIndex'])->name('reportSalesOrder.detailIndex');
    Route::post('reportSalesOrderDetail', [ReportController::class, 'detailView'])->name('reportSalesOrder.detailView');
});



