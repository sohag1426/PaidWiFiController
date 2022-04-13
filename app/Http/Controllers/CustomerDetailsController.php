<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\pgsql_radacct_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CustomerDetailsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, int $customer)
    {

        $operator_id = $request->user()->id;

        $cache_key = 'customer_' . $operator_id . '_' . $customer;

        $seconds = 600;

        $customer = Cache::remember($cache_key, $seconds, function () use ($customer) {
            return customer::with(['custom_attributes', 'radaccts'])->where('id', $customer)->firstOrFail();
        });

        return self::getDetailedCustomerView($customer);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Freeradius\customer $customer
     * @return \Illuminate\Http\Response
     */
    public static function getDetailedCustomerView(customer $customer)
    {
        $radaccts_history_key = 'radaccts_history_' . $customer->operator_id . '_' . $customer->id;

        $seconds = 600;

        $radaccts_history = Cache::remember($radaccts_history_key, $seconds, function () use ($customer) {
            return pgsql_radacct_history::where('username', $customer->username)->get();
        });

        return view('admins.components.customer-details', [
            'customer' => $customer,
            'radaccts_history' => $radaccts_history,
        ]);
    }
}
