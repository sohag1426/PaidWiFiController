<?php

namespace App\Http\Controllers;

use App\Models\master_package;
use App\Models\temp_package;
use Illuminate\Http\Request;

class PackageCreateController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\temp_package  $temp_package
     * @return \Illuminate\Http\Response
     */
    public function create(temp_package $temp_package)
    {
        return view('admins.group_admin.packages-create', [
            'temp_package' => $temp_package,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\temp_package  $temp_package
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, temp_package $temp_package)
    {
        //validate
        if ($request->name == 'Trial') {
            return redirect()->route('master_packages.index')->with('error', 'Trial package cannot be created!');
        }


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'rate_limit' => ['required', 'integer'],
            'speed_controller' => ['required', 'in:Router,Radius_Server'],
            'rate_unit' => ['nullable', 'in:M,k'],
            'validity' => ['nullable', 'integer'],
            'volume_limit' => ['required', 'integer'],
            'volume_unit' => ['required'],
        ]);

        $master_package = new master_package();
        $master_package->mgid = $request->user()->id;
        $master_package->pppoe_profile_id = $temp_package->pppoe_profile_id;
        $master_package->connection_type = $temp_package->connection_type;
        $master_package->name = $request->name;

        if ($request->filled('price')) {
            $master_package->price = $request->price;
        }

        if ($request->filled('operator_price')) {
            $master_package->operator_price = $request->operator_price;
        }

        $master_package->rate_limit = $request->rate_limit;
        $master_package->rate_unit = $request->rate_unit;
        $master_package->speed_controller = $request->speed_controller;
        $master_package->volume_limit = $request->volume_limit;
        $master_package->volume_unit = $request->volume_unit;

        if ($request->filled('visibility')) {
            $master_package->visibility = $request->visibility;
        }

        if ($request->filled('validity')) {
            $master_package->validity = $request->validity;
        } else {
            $master_package->validity = 30;
        }

        $master_package->save();

        $temp_package->delete();

        return redirect()->route('master_packages.index')->with('success', 'Package has been added successfully');
    }
}
