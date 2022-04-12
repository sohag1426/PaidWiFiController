<?php

namespace App\Http\Controllers;

use App\Models\master_package;
use App\Models\operator;
use App\Models\package;
use Illuminate\Http\Request;

class OperatorMasterPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function index(operator $operator)
    {
        return view('admins.group_admin.operator-master-packages', [
            'operator' => $operator,
            'packages' => $operator->packages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, operator $operator)
    {
        if ($request->user()->role !== 'group_admin') {
            abort(403);
        }

        $master_packages = master_package::where('mgid', $request->user()->id)->get();

        $assigned_master_packages = $operator->assigned_master_packages;

        $packages = $master_packages->diff($assigned_master_packages);

        if ($packages->count() == 0) {
            return redirect(url()->previous())->with('success', 'All Packages were assigned!');
        }

        return view('admins.group_admin.operator-master-packages-create', [
            'operator' => $operator,
            'packages' => $packages,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, operator $operator)
    {

        $request->validate([
            'package_id' => 'numeric|required',
        ]);

        return redirect()->route('operators.master_packages.edit', ['master_package' => $request->package_id, 'operator' => $operator->id]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\master_package  $master_package
     * @return \Illuminate\Http\Response
     */
    public function edit(operator $operator, master_package $master_package)
    {

        return view('admins.group_admin.operator-master-packages-edit', [
            'master_package' => $master_package,
            'operator' => $operator,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\master_package  $master_package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, operator $operator, master_package $master_package)
    {

        if ($request->name == 'Trial') {
            return redirect()->route('operators.master_packages.edit', ['master_package' => $master_package->id, 'operator' => $operator->id])->with('error', 'Trial package cannot be created!');
        }

        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'operator_price' => 'required|numeric',
            'visibility' => 'required|in:public,private',
        ]);

        if ($request->operator_price > $request->price) {
            return redirect()->route('operators.master_packages.edit', ['master_package' => $master_package->id, 'operator' => $operator->id])->with('error', 'package price must be greater than operator price!');
        }

        // duplicate
        $duplicate_where = [
            ['operator_id', '=', $operator->id],
            ['mpid', '=', $master_package->id],
        ];

        if (package::where($duplicate_where)->count() == 0) {
            $package = new package();
            $package->mgid = $request->user()->mgid;
            $package->gid = $request->user()->id;
            $package->operator_id = $operator->id;
            $package->mpid = $master_package->id;
            $package->name = $request->name;
            $package->price = $request->price;
            $package->operator_price = $request->operator_price;
            $package->visibility = $request->visibility;
            $package->save();
            $package->ppid = $package->id;
            $package->save();
        }

        if ($request->user()->id == $operator->id) {
            return redirect()->route('packages.index')->with('success', 'The package added successfully!');
        }

        return redirect()->route('operators.master_packages.index', ['operator' => $operator->id])->with('success', 'The package added successfully!');
    }
}
