<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\pgsql_radcheck;

class CustomersRadPasswordController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\customer  $customer
     * @return  int
     */
    public static function updateOrCreate(customer $customer)
    {

        // << radius

        # Username updated by foreign key

        $operator = CacheController::getOperator($customer->operator_id);

        $radcheck = new pgsql_radcheck();

        $radcheck->setConnection($operator->pgsql_connection);

        if ($customer->status == 'disabled') {
            $radcheck->updateOrCreate(
                [
                    'mgid' => $customer->mgid,
                    'customer_id' => $customer->id,
                    'username' => $customer->username,
                    'attribute' => 'Cleartext-Password',
                ],
                [
                    'value' => rand(1000, 9999),
                ]
            );
        } else {
            $radcheck->updateOrCreate(
                [
                    'mgid' => $customer->mgid,
                    'customer_id' => $customer->id,
                    'username' => $customer->username,
                    'attribute' => 'Cleartext-Password',
                ],
                [
                    'value' => $customer->password,
                ]
            );
        }

        // radius >>
    }
}
