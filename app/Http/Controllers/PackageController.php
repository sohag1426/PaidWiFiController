<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\master_package;
use App\Models\operator;
use App\Models\package;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $operator = $request->user();

        $packages = package::where('operator_id', $operator->id)->get();

        return view('admins.group_admin.packages', [
            'operator' => $operator,
            'packages' => $packages,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, package $package)
    {

        return view('admins.group_admin.packages-edit', [
            'package' => $package,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, package $package)
    {
        $this->authorize('update', $package);

        // validate
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'price' => 'integer|nullable',
            'operator_price' => 'integer|nullable',
            'visibility' => ['nullable', 'in:public,private'],
        ]);

        if ($request->filled('name')) {
            $this->authorize('updateName', $package);
            $package->name = $request->name;
        }

        if ($request->filled('price')) {
            $this->authorize('updatePrice', $package);
            $package->price = $request->price;
        }

        if ($request->filled('operator_price')) {
            $this->authorize('updateOperatorPrice', $package);
            $package->operator_price = $request->operator_price;
        }

        if ($request->filled('visibility')) {
            $package->visibility = $request->visibility;
        }

        $package->save();

        // name was changed
        if ($package->wasChanged('name')) {

            $where = [
                ['mgid', '=', $package->mgid],
                ['package_id', '=', $package->id],
            ];

            customer::where($where)->update(['package_name' => $package->name]);
        }

        if ($request->user()->id == $package->operator_id) {
            return redirect()->route('packages.index')->with('success', 'Package Updated Successfully!');
        }

        $operator = $request->user();

        switch ($operator->role) {
            case 'group_admin':
                return redirect()->route('operators.master_packages.index', ['operator' => $package->operator->id])->with('success', 'Package Updated Successfully!');
                break;
            case 'operator':
                return redirect()->route('operators.packages.index', ['operator' => $package->operator->id])->with('success', 'Package Updated Successfully!');
                break;
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, package $package)
    {
        $this->authorize('delete', $package);

        // package belongs to it's child package
        foreach ($package->child_packages as $child_package) {
            if ($child_package->customer_count > 0) {
                return redirect(url()->previous())->with('success', 'The package is being used! Can not Delete!');
            } else {
                $child_package->delete();
            }
        }

        return redirect(url()->previous())->with('success', 'Package has been deleted successfully!');
    }


    /**
     * Trial Package.
     *
     * @return \App\Models\package
     */
    public static function trialPackage(operator $operator)
    {
        // return if found Trial package
        $package = package::where('mgid', $operator->mgid)
            ->where('name', 'Trial')
            ->first();

        if ($package) {
            return $package;
        }

        // create and return new Trial package
        $master_package = new master_package();
        $master_package->mgid = $operator->mgid;
        $master_package->connection_type = 'Hotspot';
        $master_package->name = 'Trial';
        $master_package->rate_limit = 0;
        $master_package->rate_unit = 'M';
        $master_package->speed_controller = 'Radius_Server';
        $master_package->volume_limit = 100;
        $master_package->volume_unit = 'MB';
        $master_package->validity = 1;
        $master_package->save();

        $package = new package();
        $package->mgid = $operator->mgid;
        $package->gid = $operator->mgid;
        $package->operator_id = $operator->mgid;
        $package->mpid = $master_package->id;
        $package->name = 'Trial';
        $package->price = 0;
        $package->operator_price = 0;
        $package->visibility = 'private';
        $package->save();
        $package->ppid = $package->id;
        $package->save();

        return $package;
    }


    /**
     * Invoice.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function invoice(package $package)
    {
        $master_package = $package->master_package;

        $now = Carbon::now(config('app.timezone'));

        return collect([
            'package_name' => $package->name,
            'customers_amount' => $package->price,
            'operators_amount' => $package->operator_price,
            'validity' => $master_package->validity,
            'start_date' => $now->format(config('app.billing_period_format')),
            'stop_date' => Carbon::now(config('app.timezone'))->addDays($master_package->validity)->format(config('app.billing_period_format')),
        ]);
    }


    /**
     * Get Package Price.
     *
     * @param  \App\Models\customer $customer
     * @param  \App\Models\package  $package
     * @return int
     */
    public static function price(customer $customer, package $package)
    {
        $package_price = $package->price;

        return $package_price;
    }

    /**
     * Get discount.
     *
     * @param  \App\Models\customer $customer
     * @param  \App\Models\package  $new_package
     * @return int
     */
    public static function discount(customer $customer)
    {
        if ($customer->connection_type === 'Hotspot') {
            return 0;
        } else {
            if ($customer->status == 'suspended' || $customer->status == 'disabled') {
                return 0;
            }
            // Already Expired
            if (Carbon::createFromIsoFormat(config('app.expiry_time_format'), $customer->package_expired_at)->lessThan(Carbon::now(config('app.timezone')))) {
                return 0;
            }
            $active_package = package::find($customer->package_id);
            if (!$active_package) {
                return 0;
            }
            $master_package = $active_package->master_package;
            $package_price = self::price($customer, $active_package);
            $period_start = Carbon::now(config('app.timezone'))->format(config('app.date_format'));
            $expiration = Carbon::createFromIsoFormat(config('app.expiry_time_format'), $customer->package_expired_at)->format(config('app.date_format'));
            $discount_validity = Carbon::createFromFormat(config('app.date_format'), $period_start)->diffInDays(Carbon::createFromFormat(config('app.date_format'), $expiration));
            $discount = round(($package_price / $master_package->validity) * $discount_validity);
            if ($discount > 0) {
                return $discount;
            } else {
                return 0;
            }
        }
    }

    /**
     * Get discount.
     *
     * @param  \App\Models\customer $customer
     * @param  \App\Models\package  $new_package
     * @return int
     */
    public static function operatorsDiscount(customer $customer)
    {
        if ($customer->connection_type === 'Hotspot') {
            return 0;
        } else {
            if ($customer->status == 'suspended' || $customer->status == 'disabled') {
                return 0;
            }
            // Already Expired
            if (Carbon::createFromIsoFormat(config('app.expiry_time_format'), $customer->package_expired_at)->lessThan(Carbon::now(config('app.timezone')))) {
                return 0;
            }
            $active_package = package::find($customer->package_id);
            $master_package = $active_package->master_package;
            $period_start = Carbon::now(config('app.timezone'))->format(config('app.date_format'));
            $expiration = Carbon::createFromIsoFormat(config('app.expiry_time_format'), $customer->package_expired_at)->format(config('app.date_format'));
            $discount_validity = Carbon::createFromFormat(config('app.date_format'), $period_start)->diffInDays(Carbon::createFromFormat(config('app.date_format'), $expiration));
            $discount = round(($active_package->operator_price / $master_package->validity) * $discount_validity);
            if ($discount > 0) {
                return $discount;
            } else {
                return 0;
            }
        }
    }
}
