<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\customer_payment;
use App\Models\operator;
use Illuminate\Http\Request;

class CustomersPaymentProcessController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(customer_payment $customer_payment)
    {
        $customer_payment->refresh();

        //Successful
        if ($customer_payment->pay_status !== 'Successful') {
            return 0;
        }

        //not used
        if ($customer_payment->used !== 0) {
            return 0;
        }
        $customer_payment->used = 1;
        $customer_payment->save();

        // operator
        $operator = operator::findOrFail($customer_payment->operator_id);

        // customer
        $model = new customer();
        $model->setConnection($operator->radius_db_connection);
        $customer = $model->findOrFail($customer_payment->customer_id);

        // payment_status
        $customer->status = 'active';
        $customer->texted_locked_status = 0;
        $customer->save();

        // After Payment Service
        AfterPaymentCustomerServiceController::update($customer_payment);

        // cache clear
        CacheController::forgetCustomer($customer);

        // login
        if ($customer->connection_type == 'Hotspot') {
            HotspotInternetLoginController::login($customer);
        }

        // require_sms_notice
        if ($customer_payment->require_sms_notice == 0) {
            return 1;
        }

        // No SMS for Recharge Card
        if ($customer_payment->payment_gateway_name === 'recharge_card') {
            return 1;
        }

        return 1;
    }
}
