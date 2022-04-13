<?php

namespace App\Http\Controllers;

use App\Models\all_customer;
use App\Models\customer;
use App\Models\temp_customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerCreateController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\temp_customer  $temp_customer
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, temp_customer $temp_customer)
    {
        return view('admins.group_admin.customers-create', [
            'temp_customer' => $temp_customer,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\temp_customer  $temp_customer
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, temp_customer $temp_customer)
    {
        //package Information
        $package = PackageController::trialPackage($request->user());
        $master_package = $package->master_package;
        $package_started_at = Carbon::now(config('app.timezone'))->isoFormat(config('app.expiry_time_format'));

        $package_expired_at = Carbon::now(config('app.timezone'))->addDays($master_package->validity)->isoFormat(config('app.expiry_time_format'));

        $customer = new customer();
        //General Information
        $customer->house_no = $request->house_no;
        $customer->road_no = $request->road_no;
        $customer->thana = $request->thana;
        $customer->district = $request->district;
        $customer->type_of_client = $request->type_of_client;
        $customer->type_of_connection = $request->type_of_connection;
        $customer->type_of_connectivity = $request->type_of_connectivity;

        //Registration timestamp
        $customer->registration_date = date(config('app.date_format'));
        $customer->registration_week = date(config('app.week_format'));
        $customer->registration_month = date(config('app.month_format'));
        $customer->registration_year = date(config('app.year_format'));

        //Import from temp_customer
        $customer->mgid = $temp_customer->mgid;
        $customer->gid = $temp_customer->gid;
        $customer->operator_id = $temp_customer->operator_id;
        $customer->company = $temp_customer->company;
        $customer->connection_type = $temp_customer->connection_type;
        $customer->zone_id = $temp_customer->zone_id;
        $customer->device_id = $temp_customer->device_id;
        $customer->name = $temp_customer->name;
        $customer->mobile = $temp_customer->mobile;
        $customer->verified_mobile = 1;
        $customer->email = $temp_customer->email;
        $customer->billing_profile_id = $temp_customer->billing_profile_id;
        $customer->username = trim($temp_customer->username);
        $customer->password = trim($temp_customer->password);
        $customer->package_id = $package->id;
        $customer->package_name = $package->name;
        $customer->package_started_at = $package_started_at;
        $customer->package_expired_at = $package_expired_at;
        $customer->rate_limit = $master_package->rate_limit;
        $customer->total_octet_limit = $master_package->total_octet_limit;
        $customer->router_ip = $temp_customer->router_ip;
        $customer->login_ip = $temp_customer->login_ip;
        $customer->status = 'active';
        $customer->payment_status = 'paid';

        $customer->username = $temp_customer->mobile;
        $customer->password = $temp_customer->mobile;

        $customer->save();

        //Central customer information
        $all_customer = new all_customer();
        $all_customer->mgid = $request->user()->mgid;
        $all_customer->operator_id = $temp_customer->operator_id;
        $all_customer->customer_id = $customer->id;
        $all_customer->mobile = $temp_customer->mobile;
        $all_customer->save();

        HotspotCustomersRadAttributesController::updateOrCreate($customer);

        //delete temp customer information
        $temp_customer->delete();


        //return customer's list
        $url = route('customers.index') . '?refresh=1';
        return redirect($url)->with('success', 'The customer has been added successfully!');
    }
}
