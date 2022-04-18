<?php

use App\Http\Controllers\CardRechargeController;
use App\Http\Controllers\CustomerMobileVerificationController;
use App\Http\Controllers\CustomerPackagePurchaseController;
use App\Http\Controllers\CustomersMacAddressReplaceController;
use App\Http\Controllers\CustomersWebInterfaceController;
use App\Http\Controllers\CustomerWebLoginController;
use App\Http\Controllers\HotspotLoginController;
use App\Http\Controllers\RechargeCardPaymentController;
use App\Http\Controllers\TempCustomerMobileVerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

#start <<web login>>
Route::get('/', [CustomerWebLoginController::class, 'create'])
    ->name('root');

Route::post('customer/web/login', [CustomerWebLoginController::class, 'login'])
    ->middleware('guest')
    ->name('customer.web.login');

Route::get('customer/web/logout', [CustomerWebLoginController::class, 'logout'])
    ->middleware('customer.auth')
    ->name('customer.web.logout');
#end <<web login>>


#start <<Web Interface>>
Route::middleware(['customer.auth', 'customer.verified'])->group(function () {

    Route::get('customers/{mobile}/home', [CustomersWebInterfaceController::class, 'home'])
        ->name('customers.home');

    Route::get('customers/{mobile}/profile', [CustomersWebInterfaceController::class, 'profile'])
        ->name('customers.profile');

    Route::get('customers/{mobile}/radaccts', [CustomersWebInterfaceController::class, 'radaccts'])
        ->name('customers.radaccts');

    Route::get('customers/{mobile}/packages', [CustomersWebInterfaceController::class, 'packages'])
        ->name('customers.packages');

    Route::get('customers/{mobile}/card-store', [CustomersWebInterfaceController::class, 'cardStores'])
        ->name('customers.card-stores');

    Route::get('customers/{mobile}/payments', [CustomersWebInterfaceController::class, 'payments'])
        ->name('customers.payments');

    Route::get('customers/{mobile}/card-recharge/create', [CardRechargeController::class, 'create'])
        ->name('card-recharge.create');

    Route::post('customers/{mobile}/card-recharge', [CardRechargeController::class, 'store'])
        ->name('card-recharge.store');
});

Route::get('customers/network collision/{mobile}/{new_network}', [CustomersWebInterfaceController::class, 'networkCollision'])
    ->middleware('guest')
    ->name('customers.network-collision');
#end <<Web Interface>>

#start <<Create Payment>>
Route::get('customers/{mobile}/package/{package}/purchase', [CustomerPackagePurchaseController::class, 'create'])
    ->name('customers.purchase-package');
#end <<Create Payment>>

#start <<hotspot login & MAC Replace>>
Route::prefix('hotspot')->group(function () {

    Route::get('/demo/login', function () {
        return view('customers.hotspot-demo-login');
    })->middleware('guest');

    Route::post('/login', [HotspotLoginController::class, 'store'])
        ->middleware('guest')
        ->name('hotspot.login');

    Route::get('/suspicious/login/{mobile}', [CustomersMacAddressReplaceController::class, 'initiate'])
        ->middleware('guest')
        ->name('customer.suspicious-login');

    Route::get('/replace-mac-address/{mobile}', [CustomersMacAddressReplaceController::class, 'create'])
        ->middleware('guest')
        ->name('customer.replace.mac');

    Route::post('/replace-mac-address/{mobile}', [CustomersMacAddressReplaceController::class, 'store'])
        ->middleware('guest');
});
#stop <<hotspot login & MAC Replace>>

#start <<Mobile Verification>>
Route::get('customer/temp/{mobile}/mobile/verification', [TempCustomerMobileVerificationController::class, 'create'])
    ->middleware('guest')
    ->name('temp_customer.mobile.verification');

Route::post('customer/temp/{mobile}/mobile/verification', [TempCustomerMobileVerificationController::class, 'store'])
    ->middleware('guest');

Route::middleware(['customer.auth'])->group(function () {

    Route::get('customer/{mobile}/mobile/verification', [CustomerMobileVerificationController::class, 'create'])
        ->name('customer.mobile.verification');

    Route::post('customer/{mobile}/mobile/verification', [CustomerMobileVerificationController::class, 'store']);
});
#end <<Mobile Verification>>


#start <<Payment>>
Route::middleware(['customer.auth'])->group(function () {

    //Pay Internet Payment with recharge cards
    Route::resource('customer_payments.recharge-cards', RechargeCardPaymentController::class)
        ->only(['create', 'store']);
});
