<?php

use App\Http\Controllers\ActiveCustomerWidgetController;
use App\Http\Controllers\CardDistributorController;
use App\Http\Controllers\CardDistributorPaymentsController;
use App\Http\Controllers\CardDistributorsPaymentsDownloadController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerCreateController;
use App\Http\Controllers\CustomerDetailsController;
use App\Http\Controllers\CustomerDuplicateValueCheckController;
use App\Http\Controllers\CustomerSpeedLimitController;
use App\Http\Controllers\CustomersSmsHistoryCreateController;
use App\Http\Controllers\CustomerTimeLimitController;
use App\Http\Controllers\CustomerVolumeLimitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GlobalCustomerSearchController;
use App\Http\Controllers\MasterPackageController;
use App\Http\Controllers\NasController;
use App\Http\Controllers\OnlineCustomersController;
use App\Http\Controllers\OnlineCustomerWidgetController;
use App\Http\Controllers\OperatorMasterPackageController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackageCreateController;
use App\Http\Controllers\RechargeCardController;
use App\Http\Controllers\RechargeCardDownloadController;
use App\Http\Controllers\RouterConfigurationController;
use App\Http\Controllers\SmsHistoryController;
use App\Http\Controllers\SuspendCustomerWidgetController;
use App\Http\Controllers\TempCustomerController;
use App\Http\Controllers\TempPackageController;
use Illuminate\Support\Facades\Route;

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


Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
});


/*
|--------------------------------------------------------------------------
| Dashboard Widgets
|--------------------------------------------------------------------------
*/
Route::prefix('widgets')->middleware(['auth'])->group(function () {

    Route::resource('active_customer_widget', ActiveCustomerWidgetController::class)
        ->only(['index']);

    Route::resource('suspend_customer_widget', SuspendCustomerWidgetController::class)
        ->only(['index']);

    Route::resource('online_customer_widget', OnlineCustomerWidgetController::class)
        ->only(['index']);
});



/*
|--------------------------------------------------------------------------
| Group Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth'])->group(function () {

    // <<Router
    Route::resource('routers', NasController::class);

    Route::resource('routers.configuration', RouterConfigurationController::class)
        ->only(['create', 'store']);
    // Router>>

    // <<master packages
    Route::resource('master_packages', MasterPackageController::class)
        ->only(['index', 'show', 'edit', 'update', 'destroy']);

    Route::resource('temp_packages', TempPackageController::class)
        ->only(['store']);

    Route::resource('temp_packages.master_packages', PackageCreateController::class)
        ->only(['create', 'store']);

    Route::resource('operators.master_packages', OperatorMasterPackageController::class)
        ->only(['index', 'create', 'store', 'edit', 'update']);
    // master packages>>

});


/*
|--------------------------------------------------------------------------
| General Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth'])->group(function () {

    // <<packages
    Route::resource('packages', PackageController::class)
        ->only(['index', 'edit', 'update', 'destroy']);
    // packages>>

    // << recharge cards
    Route::resource('card_distributors', CardDistributorController::class)
        ->except(['show']);

    Route::resource('distributor_payments', CardDistributorPaymentsController::class)
        ->only(['index', 'create', 'store']);

    Route::resource('distributor_payments_download', CardDistributorsPaymentsDownloadController::class)
        ->only(['create', 'store']);

    Route::resource('recharge_cards', RechargeCardController::class)
        ->only(['index', 'create', 'store', 'destroy']);

    Route::resource('recharge_cards_download', RechargeCardDownloadController::class)
        ->only(['create', 'store']);
    // recharge cards>>

    #start <<customer list, create & edit>>

    Route::get('/check-customers-uniqueness', [CustomerDuplicateValueCheckController::class, '__invoke']);

    Route::resource('temp_customers', TempCustomerController::class)
        ->only(['create', 'store']);

    Route::resource('temp_customers.customers', CustomerCreateController::class)
        ->only(['create', 'store']);

    Route::resource('customers', CustomerController::class)
        ->except(['create', 'store']);

    Route::resource('/global-customer-search', GlobalCustomerSearchController::class)
        ->only(['index', 'show']);

    Route::resource('/customer-details', CustomerDetailsController::class)
        ->only(['show'])
        ->parameters([
            'customer-details' => 'customer'
        ]);

    Route::resource('/customer-package-time-limit', CustomerTimeLimitController::class)
        ->only(['edit', 'update'])
        ->parameters([
            'customer-package-time-limit' => 'customer'
        ]);

    Route::resource('/customer-package-speed-limit', CustomerSpeedLimitController::class)
        ->only(['edit', 'update'])
        ->parameters([
            'customer-package-speed-limit' => 'customer'
        ]);

    Route::resource('/customer-package-volume-limit', CustomerVolumeLimitController::class)
        ->only(['edit', 'update'])
        ->parameters([
            'customer-package-volume-limit' => 'customer'
        ]);

    Route::resource('customers.sms_histories', CustomersSmsHistoryCreateController::class)
        ->only(['create', 'store']);

    Route::resource('online_customers', OnlineCustomersController::class)
        ->only(['index', 'show']);

    #end <<customer list, create & edit>>

    Route::resource('sms_histories', SmsHistoryController::class)
        ->only(['index', 'create', 'store', 'show']);

});


require __DIR__ . '/auth.php';
require __DIR__ . '/routes_of_customers.php';
