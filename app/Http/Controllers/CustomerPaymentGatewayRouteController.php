<?php

namespace App\Http\Controllers;

use App\Models\customer_payment;
use App\Models\payment_gateway;
use Illuminate\Http\Request;

class CustomerPaymentGatewayRouteController extends Controller
{
    /**
     * Route to Payment Gateway
     *
     * @param  \App\Models\payment_gateway  $payment_gateway
     * @param  \App\Models\customer_payment  $customer_payment
     * @return \Illuminate\Http\Response
     */
    public static function pgwRoute(payment_gateway $payment_gateway, customer_payment $customer_payment)
    {

        switch ($payment_gateway->provider_name) {
            case 'recharge_card':
                $customer_payment->type = 'RechargeCard';
                $customer_payment->save();
                return redirect()->route('customer_payments.recharge-cards.create', ['customer_payment' => $customer_payment->id]);
                break;
        }
    }
}
