<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\operator;
use App\Models\package;
use App\Models\pgsql_radreply;
use Illuminate\Http\Request;

class HotspotCustomersLimitController extends Controller
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

        if ($customer->package_id == 0) {
            $package = PackageController::trialPackage($operator);
            $package = $package->master_package;
        } else {
            $package = package::find($customer->package_id);
            if ($package) {
                $package = $package->master_package;
            } else {
                return 0;
            }
        }

        // Port-Limit

        $radreply = new pgsql_radreply();

        $radreply->setConnection($operator->pgsql_connection);

        $radreply->updateOrCreate(
            [
                'mgid' => $customer->mgid,
                'customer_id' => $customer->id,
                'username' => $customer->username,
                'attribute' => 'Port-Limit',
            ],
            [
                'value' => 1,
            ]
        );

        //Mikrotik-Total-Limit
        if ($customer->total_octet_limit > 0) {

            $radreply = new pgsql_radreply();

            $radreply->setConnection($operator->pgsql_connection);

            $radreply->updateOrCreate(
                [
                    'mgid' => $customer->mgid,
                    'customer_id' => $customer->id,
                    'username' => $customer->username,
                    'attribute' => 'Mikrotik-Total-Limit',
                ],
                [
                    'value' => $customer->total_octet_limit,
                ]
            );
        } else {
            $where = [
                ['mgid', '=', $customer->mgid],
                ['customer_id', '=', $customer->id],
                ['attribute', '=', 'Mikrotik-Total-Limit'],
            ];

            $radreply = new pgsql_radreply();

            $radreply->setConnection($operator->pgsql_connection);

            $radreply->where($where)->delete();
        }


        //Mikrotik-Rate-Limit
        if ($customer->rate_limit > 0 && $package->speed_controller == 'Radius_Server') {

            $radreply = new pgsql_radreply();

            $radreply->setConnection($operator->pgsql_connection);

            $radreply->updateOrCreate(
                [
                    'mgid' => $customer->mgid,
                    'customer_id' => $customer->id,
                    'username' => $customer->username,
                    'attribute' => 'Mikrotik-Rate-Limit',
                ],
                [
                    'value' => $customer->rate_limit . $package->rate_unit,
                ]
            );
        } else {
            $where = [
                ['mgid', '=', $customer->mgid],
                ['customer_id', '=', $customer->id],
                ['attribute', '=', 'Mikrotik-Rate-Limit'],
            ];

            $radreply = new pgsql_radreply();

            $radreply->setConnection($operator->pgsql_connection);

            $radreply->where($where)->delete();
        }
    }
}
