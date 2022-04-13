<?php

namespace App\Http\Controllers;

use App\Models\card_distributor;
use Illuminate\Http\Request;

class CardDistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [
            ['operator_id', '=', $request->user()->id],
        ];

        $card_distributors = card_distributor::where($where)->get();

        return view('admins.group_admin.card-distributors', [
            'card_distributors' => $card_distributors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('admins.group_admin.card-distributors-create');
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
            abort(500, 'invalid mobile number');
        }

        $request->validate([
            'name' => 'required|string',
            'mobile' => 'required',
            'store_name' => 'required',
            'store_address' => 'required',
        ]);

        $card_distributor = new card_distributor();
        $card_distributor->operator_id = $request->user()->id;
        $card_distributor->name = $request->name;
        $card_distributor->mobile = $request->mobile;
        $card_distributor->store_name = $request->store_name;
        $card_distributor->store_address = $request->store_address;
        $card_distributor->save();
        return redirect()->route('card_distributors.index')->with('success', 'Card Distributor has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\card_distributor  $card_distributor
     * @return \Illuminate\Http\Response
     */
    public function show(card_distributor $card_distributor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\card_distributor  $card_distributor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, card_distributor $card_distributor)
    {
        return view('admins.group_admin.card-distributors-edit', [
            'card_distributor' => $card_distributor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\card_distributor  $card_distributor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, card_distributor $card_distributor)
    {
        $mobile = validate_mobile($request->mobile);

        //Invalid Mobile
        if ($mobile == 0) {
            abort(500, 'invalid mobile number');
        }

        if ($request->user()->id !== $card_distributor->operator_id) {
            abort(500, 'not authorized');
        }

        $request->validate([
            'name' => 'required|string',
            'mobile' => 'required',
            'store_name' => 'required',
            'store_address' => 'required',
        ]);

        $card_distributor->name = $request->name;
        $card_distributor->mobile = $request->mobile;
        $card_distributor->store_name = $request->store_name;
        $card_distributor->store_address = $request->store_address;
        $card_distributor->save();
        return redirect()->route('card_distributors.index')->with('success', 'Card Distributor has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\card_distributor  $card_distributor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, card_distributor $card_distributor)
    {

        if ($request->user()->id !== $card_distributor->operator_id) {
            abort(500, 'not authorized');
        }

        $card_distributor->delete();
        return redirect()->route('card_distributors.index')->with('success', 'Deleted successfully!');
    }
}
