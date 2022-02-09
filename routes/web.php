<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MailSettingController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SalesOrderDetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\EstimasiController;

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

if ( file_exists( app_path( 'Http/Controllers/LocalizationController.php') ) ) 
{
  Route::get('lang/{locale}', [LocalizationController::class,'lang']);
}

Route::get('/', function () {
    return redirect()->to('home');
});

Auth::routes(['verify' => true]);
//routing admin cms
Route::group(['middleware' => ['auth']], function(){
    Route::resource('users', 'App\Http\Controllers\UserController');
    Route::post('users-import', [UserController::class,'import'])->name('users.import');
    Route::resource('roles', 'App\Http\Controllers\RoleController');
    Route::get('roles-inactive/{code}',[RoleController::class,'inactive'])->name('roles.inactive');
    Route::get('roles-active/{code}',[RoleController::class,'active'])->name('roles.active');
    Route::resource('parameters', App\Http\Controllers\ParameterController::class);
    Route::get('dataTableUser',[UserController::class,'dataTable'])->name('users.data');
    Route::get('users-inactive/{code}',[UserController::class,'inactive'])->name('users.inactive');
    Route::get('users-active/{code}',[UserController::class,'active'])->name('users.active');
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::resource('salesOrders', SalesOrderController::class)->except('create');
    Route::get('salesOrders-Filter', [SalesOrderController::class,'filter'])->name('salesOrders.filter');
    Route::get('dataTableSalesOrder',[SalesOrderController::class,'dataTable'])->name('salesOrders.data');
    Route::get('submitOrder/{code}',[SalesOrderController::class,'submitOrder'])->name('salesOrders.submitOrder');
    Route::get('cancelOrder/{code}',[SalesOrderController::class,'cancelOrder'])->name('salesOrders.cancelOrder');
    Route::get('processOrder/{code}',[SalesOrderController::class,'processOrder'])->name('salesOrders.processOrder');
    Route::post('SOuploadAttachments',[SalesOrderController::class,'uploadAttachment'])->name('salesOrders.uploadAttachment');
    Route::post('rejectOrder',[SalesOrderController::class,'rejectOrder'])->name('salesOrders.rejectOrder');
    Route::get('printOrder/{code}',[SalesOrderController::class,'printPdf'])->name('salesOrders.printPdf');
    Route::get('createReOrder/{code}',[SalesOrderController::class,'reOrder'])->name('salesOrders.reOrder');
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
    Route::get('reportRequest1', [ReportController::class, 'report1Index'])->name('reportSalesOrder.report1Index');
    Route::post('reportRequest1', [ReportController::class, 'report1View'])->name('reportSalesOrder.report1View');
    Route::get('reportCustomer', [ReportController::class, 'reportCustomerIndex'])->name('reportSalesOrder.reportCustomerIndex');
    Route::post('reportCustomer', [ReportController::class, 'reportCustomerView'])->name('reportSalesOrder.reportCustomerView');
    Route::get('reportBalance', [ReportController::class, 'reportBalanceIndex'])->name('reportSalesOrder.reportBalanceIndex');
    Route::post('reportBalance', [ReportController::class, 'reportBalanceView'])->name('reportSalesOrder.reportBalanceView');
    Route::resource('mailSettings', App\Http\Controllers\MailSettingController::class);
    Route::get('mailSettings-active/{code}',[MailSettingController::class,'active'])->name('mailSettings.active');
    Route::resource('parameterVATs', App\Http\Controllers\ParameterVATController::class);
    Route::resource('adds', App\Http\Controllers\AddController::class);
    Route::resource('attachments', App\Http\Controllers\AttachmentController::class)->except('index', 'create', 'show');
    Route::resource('estimasi', EstimasiController::class);
    Route::post('estimasi-updateData', [EstimasiController::class,'updateData'])->name('estimasi.updateData');
    Route::post('dataTableEstimasi',[EstimasiController::class,'dataTable'])->name('estimasi.data');
});


Route::get('/send_notification', [SendEmailController::class, 'send']);




