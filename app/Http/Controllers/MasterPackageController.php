<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\master_package;
use Illuminate\Http\Request;

class MasterPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $master_packages = master_package::where('mgid', $request->user()->id)
            ->get();

        return view('admins.group_admin.master-packages', [
            'master_packages' => $master_packages,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\master_package  $master_package
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, master_package $master_package)
    {
        if (!$request->user()) {
            return 'unauthorized!';
        }

        if ($request->user()->mgid !== $master_package->mgid) {
            return 'unauthorized';
        }

        return view('admins.components.master_package', [
            'master_package' => $master_package,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\master_package  $master_package
     * @return \Illuminate\Http\Response
     */
    public function edit(master_package $master_package)
    {
        $this->authorize('update', $master_package);

        return view('admins.group_admin.master-packages-edit', [
            'master_package' => $master_package,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\master_package  $master_package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, master_package $master_package)
    {
        $this->authorize('update', $master_package);

        if ($request->user()->can('updateName', $master_package)) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
            ]);
        }

        // validate
        if ($master_package->connection_type == 'StaticIp') {
            $request->validate([
                'validity' => ['required', 'integer'],
            ]);
        } else {
            $request->validate([
                'validity' => ['required', 'integer'],
                'rate_limit' => ['required', 'integer'],
                'rate_unit' => ['nullable', 'in:M,k'],
                'speed_controller' => ['required', 'in:Router,Radius_Server'],
                'volume_limit' => ['required', 'integer'],
                'volume_unit' => ['required'],
            ]);
        }

        if ($request->user()->can('updateName', $master_package)) {
            $master_package->name = $request->name;
        }
        $master_package->validity = $request->validity;
        if ($master_package->connection_type !== 'StaticIp') {
            $master_package->rate_limit = $request->rate_limit;
            $master_package->rate_unit = $request->rate_unit;
            $master_package->speed_controller = $request->speed_controller;
            $master_package->volume_limit = $request->volume_limit;
            $master_package->volume_unit = $request->volume_unit;
        }
        $master_package->save();

        return redirect()->route('master_packages.index')->with('success', 'Package has been edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\master_package  $master_package
     * @return \Illuminate\Http\Response
     */
    public function destroy(master_package $master_package)
    {
        $this->authorize('delete', $master_package);

        $customer_count = self::customerCount($master_package);

        if ($customer_count == 0) {
            $message = "Master Package: " . $master_package->name . " has been removed successfully!";
            $master_package->delete();
            return redirect()->route('master_packages.index')->with('success', $message);
        } else {
            $message = "Can not delete the package. " . $customer_count . " Customers are using this package.";
            return redirect()->route('master_packages.index')->with('error', $message);
        }
    }

    /**
     * Count Customers
     *
     * @param  \App\Models\master_package  $master_package
     * @return int
     */
    public static function customerCount(master_package $master_package)
    {
        $customer_count = 0;
        foreach ($master_package->packages as $package) {
            $customers = customer::where('package_id', $package->id)->count();
            $customer_count = $customer_count + $customers;
        }
        return $customer_count;
    }
}
