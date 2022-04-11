<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;

class HotspotCustomersRadAttributesController extends Controller
{
   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public static function updateOrCreate(customer $customer)
    {
        #pgsql_customer
        PgsqlCustomerController::updateOrCreate($customer);

        #radcheck
        CustomersRadPasswordController::updateOrCreate($customer);
        HotspotCustomersExpirationController::updateOrCreate($customer);

        #radreply
        HotspotCustomersLimitController::updateOrCreate($customer);
    }
}
