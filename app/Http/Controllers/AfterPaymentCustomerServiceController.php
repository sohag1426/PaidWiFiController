<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\customer_payment;
use App\Models\operator;
use App\Models\package;
use Illuminate\Http\Request;

class AfterPaymentCustomerServiceController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\customer_payment $customer_payment
     * @return void
     */
    public static function update(customer_payment $customer_payment)
    {
        $operator = operator::findOrFail($customer_payment->operator_id);

        $package = package::findOrFail($customer_payment->package_id);

        $master_package = $package->master_package;

        $model = new customer();
        $model->setConnection($operator->node_connection);
        $customer = $model->findOrFail($customer_payment->customer_id);

        $package_price = PackageController::price($customer, $package);

        $package_started_at = BillingHelper::startingDate($customer);

        $validity = $customer_payment->validity_period;

        if ($customer_payment->discount > 1) {
            $plus_validity = round(($master_package->validity / $package_price) * $customer_payment->discount);
            $validity = $validity + $plus_validity;
        }

        $package_expired_at = BillingHelper::stoppingDate($customer, $validity);

        $octet_limit = round(($master_package->total_octet_limit / $package_price) * $customer_payment->amount_paid);

        //update customer
        $customer->package_id = $package->id;
        $customer->package_name = $package->name;
        $customer->package_started_at = $package_started_at;
        $customer->package_expired_at = $package_expired_at;
        $customer->rate_limit = $master_package->rate_limit;
        $customer->total_octet_limit = $octet_limit;
        $customer->save();
        HotspotCustomersRadAttributesController::updateOrCreate($customer);
    }
}
