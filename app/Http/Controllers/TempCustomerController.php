<?php

namespace App\Http\Controllers;

use App\Models\all_customer;
use App\Models\customer;
use App\Models\temp_customer;
use Illuminate\Http\Request;

class TempCustomerController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admins.group_admin.customers-create-temp');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mobile = validate_mobile($request->mobile);

        //Invalid Mobile
        if ($mobile == 0) {
            return redirect()->route('temp_customers.create')->with('error', 'Invalid Mobile');
        }

        // <<Duplicate Mobile || all_customer
        $duplicate_mobile = all_customer::where('mobile', $mobile)->count();

        if ($duplicate_mobile) {
            return redirect()->route('temp_customers.create')->with('error', 'Duplicate Mobile');
        }
        // Duplicate Mobile || all_customer>>

        // <<Duplicate Mobile || customer
        $duplicate_mobile = customer::where('mobile', $mobile)->count();

        if ($duplicate_mobile) {
            return redirect()->route('temp_customers.create')->with('error', 'Duplicate Mobile');
        }
        // Duplicate Mobile || customer>>

        // Duplicate username for hotspot
        if ($request->connection_type == 'Hotspot') {
            $duplicate_username = customer::where('username', $mobile)->count();
            if ($duplicate_username) {
                return redirect()->route('temp_customers.create')->with('error', 'Duplicate Mobile/Username');
            }
        }

        $request->validate([
            'connection_type' => 'required',
            'name' => 'required',
            'mobile' => 'required',
            'nid' => 'nullable|numeric',
        ]);

        if ($request->user()->role == 'manager') {
            $operator = $request->user()->group_admin;
        } else {
            $operator = $request->user();
        }

        // delete previous attempts
        temp_customer::where('mobile', $mobile)->delete();

        $temp_customer = new temp_customer();
        $temp_customer->mgid = $operator->mgid;
        $temp_customer->gid = $operator->gid;
        $temp_customer->operator_id = $operator->id;
        $temp_customer->company = $operator->company;
        $temp_customer->connection_type = $request->connection_type;
        $temp_customer->name = $request->name;
        $temp_customer->mobile = $mobile;
        $temp_customer->save();

        return redirect()->route('temp_customers.customers.create', ['temp_customer' => $temp_customer->id]);
    }
}
