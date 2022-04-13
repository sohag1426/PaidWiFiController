<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;

class CustomerSpeedLimitController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(customer $customer)
    {
        return view('admins.group_admin.customer-speed-limit-edit', [
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, customer $customer)
    {
        //validate
        $request->validate([
            'rate_limit' => ['required', 'integer'],
        ]);

        $customer->status = 'active';
        $customer->rate_limit = $request->rate_limit;
        $customer->save();

        HotspotCustomersLimitController::updateOrCreate($customer);

        return redirect()->route('customers.index')->with('success', 'Speed Limit has been updated successfully');
    }
}
