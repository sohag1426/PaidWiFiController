<?php

namespace App\Http\Controllers;

use App\Models\temp_package;
use Illuminate\Http\Request;

class TempPackageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'connection_type' => 'required',
        ]);

        $temp_package = new temp_package();
        $temp_package->mgid = $request->user()->id;
        $temp_package->connection_type = $request->connection_type;
        $temp_package->save();

        return redirect()->route('temp_packages.master_packages.create', ['temp_package' => $temp_package->id]);
    }
}
