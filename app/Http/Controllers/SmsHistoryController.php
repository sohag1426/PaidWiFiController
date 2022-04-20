<?php

namespace App\Http\Controllers;

use App\Models\sms_history;
use Illuminate\Http\Request;

class SmsHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $operator = $request->user();

        $where = [];

        // default filter
        $where[] = ['operator_id', '=', $operator->id];

        // sms_bill_id
        if ($request->filled('sms_bill_id')) {
            $where[] = ['sms_bill_id', '=', $request->sms_bill_id];
        }

        // to_number
        if ($request->filled('to_number')) {
            $where[] = ['to_number', '=', $request->to_number];
        }

        $histories = sms_history::where($where)->orderBy('id', 'desc')->paginate(15);

        return view('admins.group_admin.sms-histories', [
            'histories' => $histories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sms_history  $sms_history
     * @return \Illuminate\Http\Response
     */
    public function show(sms_history $sms_history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sms_history  $sms_history
     * @return \Illuminate\Http\Response
     */
    public function edit(sms_history $sms_history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sms_history  $sms_history
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sms_history $sms_history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sms_history  $sms_history
     * @return \Illuminate\Http\Response
     */
    public function destroy(sms_history $sms_history)
    {
        //
    }
}
