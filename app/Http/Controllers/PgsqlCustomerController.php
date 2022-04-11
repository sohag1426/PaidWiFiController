<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\operator;
use App\Models\pgsql_customer;
use Illuminate\Http\Request;

class PgsqlCustomerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Freeradius\customer $customer
     * @return void
     */
    public static function updateOrCreate(customer $customer)
    {
        $operator = operator::find($customer->operator_id);
        $model = new pgsql_customer();
        $model->setConnection($operator->pgsql_connection);
        $model->updateOrCreate(
            ['mgid' => $customer->mgid, 'customer_id' => $customer->id],
            ['operator_id' => $customer->operator_id, 'username' => $customer->username]
        );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Freeradius\customer  $customer
     * @return void
     */
    public static function destroy(customer $customer)
    {
        $operator = operator::find($customer->operator_id);
        $model = new pgsql_customer();
        $model->setConnection($operator->pgsql_connection);
        $model->where('username', $customer->username)->delete();
    }
}
