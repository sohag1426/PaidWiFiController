<?php

namespace App\Http\Controllers;

use App\Models\all_customer;
use App\Models\customer;
use App\Models\customer_payment;
use App\Models\operator;
use App\Models\package;
use App\Models\payment_gateway;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerPackagePurchaseController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, string $mobile, package $package)
    {
        $master_package = $package->master_package;

        $request->validate([
            'payment_gateway_id' => 'required'
        ]);

        $customer_mobile = validate_mobile($mobile);

        if ($customer_mobile == 0) {
            abort(500, 'Invalid Mobile Number');
        }

        $customer_info = all_customer::where('mobile', $customer_mobile)->firstOrFail();

        $operator = operator::findOrFail($customer_info->operator_id);

        $model = new customer();

        $model->setConnection($operator->radius_db_connection);

        $customer = $model->findOrFail($customer_info->customer_id);

        //payment_gateway
        if ($request->payment_gateway_id == 0) {

            $payment_gateway = PaymentGatewayController::rechargeCardGw($operator);
        } else {

            $payment_gateway = payment_gateway::findOrFail($request->payment_gateway_id);
        }

        //mer_txnid
        $mer_txnid = random_int(1000, 9999) . Carbon::now(config('app.timezone'))->timestamp;

        //customer_payment
        $customer_payment = new customer_payment();
        $customer_payment->mgid = $operator->mgid;
        $customer_payment->gid = $operator->gid;
        $customer_payment->operator_id = $operator->id;
        $customer_payment->customer_id = $customer->id;
        $customer_payment->package_id = $package->id;
        $customer_payment->validity_period = $master_package->validity;
        $customer_payment->previous_package_id = $customer->package_id;
        $customer_payment->payment_gateway_id = $payment_gateway->id;
        $customer_payment->payment_gateway_name = $payment_gateway->provider_name;
        $customer_payment->mobile = $customer->mobile;
        $customer_payment->name = $customer->name;
        $customer_payment->username = $customer->username;
        $customer_payment->type = 'Online';
        $customer_payment->amount_paid = $package->price;
        $customer_payment->mer_txnid = $mer_txnid;
        $customer_payment->date = date(config('app.date_format'));
        $customer_payment->week = date(config('app.week_format'));
        $customer_payment->month = date(config('app.month_format'));
        $customer_payment->year = date(config('app.year_format'));
        $customer_payment->save();

        return CustomerPaymentGatewayRouteController::pgwRoute($payment_gateway, $customer_payment);
    }
}
