<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerTimeLimitController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(customer $customer)
    {
        $this->authorize('editSpeedLimit', $customer);

        return view('admins.group_admin.customer-time-limit-edit', [
            'customer' => $customer,
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
        $request->validate([
            'validity' => 'required|integer',
        ]);

        if ($request->validity > 0) {
            $package_expired_at = Carbon::now(config('app.timezone'))->addDays($request->validity)->isoFormat(config('app.expiry_time_format'));
        } else {
            $package_expired_at = Carbon::now(config('app.timezone'))->isoFormat(config('app.expiry_time_format'));
        }

        $customer->status = 'active';
        $customer->package_expired_at = $package_expired_at;
        $customer->save();

        HotspotCustomersExpirationController::updateOrCreate($customer);

        return redirect()->route('customers.index')->with('success', 'Time Limit has been Extended successfully');
    }
}
