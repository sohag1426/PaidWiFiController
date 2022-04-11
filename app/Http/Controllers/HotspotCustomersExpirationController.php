<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\operator;
use App\Models\pgsql_radcheck;
use Illuminate\Http\Request;

class HotspotCustomersExpirationController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\customer  $customer
     * @return void
     */
    public static function updateOrCreate(customer $customer)
    {
        $operator = operator::find($customer->operator_id);

        if ($customer->package_expired_at) {

            $radcheck = new pgsql_radcheck();

            $radcheck->setConnection($operator->pgsql_connection);

            $radcheck->updateOrCreate(
                [
                    'mgid' => $customer->mgid,
                    'customer_id' => $customer->id,
                    'username' => $customer->username,
                    'attribute' => 'Expiration',
                ],
                [
                    'value' => $customer->package_expired_at,
                ]
            );
        } else {
            $where = [
                ['mgid', '=', $customer->mgid],
                ['customer_id', '=', $customer->id],
                ['attribute', '=', 'Expiration'],
            ];

            $radcheck = new pgsql_radcheck();

            $radcheck->setConnection($operator->pgsql_connection);

            $radcheck->where($where)->delete();
        }
    }
}
