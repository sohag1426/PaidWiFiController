<?php

namespace App\Http\Controllers;

use App\Models\operator;
use App\Models\sms_gateway;
use App\Models\sms_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SmsGatewayController extends Controller
{
    /**
     * Get the SMS Gateway for the operator
     *
     * @param  \App\Models\operator  $operator
     * @return  \App\Models\sms_gateway
     */

    public function getSmsGw(operator $operator)
    {

        $cache_key = 'sms_gw_' . $operator->id;

        $ttl = 600;

        return Cache::remember($cache_key, $ttl, function () use ($operator) {

            //use own Gateway
            $count = sms_gateway::where('operator_id', $operator->id)->count();
            if ($count) {
                return sms_gateway::where('operator_id', $operator->id)->first();
            }
            return sms_gateway::make([
                'id' => 0,
                'operator_id' => 0,
                'provider_name' => 'Demo',
                'unit_price' => '0.0',
                'from_number' => '01751000000',
            ]);
        });
    }



    /**
     * send sms to number
     *
     * @param  \App\Models\operator  $operator
     * @param string $mobile_number
     * @param string $message
     * @param int $customer_id
     *
     * @return mixed
     */

    public function sendSms(operator $operator, string $mobile_number, string $message, int $customer_id = 0)
    {

        // Disabled Messages
        if (strlen($message) < 5) {
            return 0;
        }

        //sms gw
        $sms_gateway = $this->getSmsGw($operator);

        //sms_history
        $sms_history = new sms_history();
        $sms_history->operator_id = $operator->id;
        $sms_history->customer_id = $customer_id;
        $sms_history->sms_gateway_id = $sms_gateway->id;
        $sms_history->from_number = $sms_gateway->from_number;
        $sms_history->to_number = $mobile_number;
        $sms_history->status_text = 'Pending';
        $sms_history->sms_body = $message;
        $sms_history->date = date(config('app.date_format'));
        $sms_history->week = date(config('app.week_format'));
        $sms_history->month = date(config('app.month_format'));
        $sms_history->year = date(config('app.year_format'));
        $sms_history->save();

        // demo sms gateway
        if ($sms_gateway->id == 0) {
            return $sms_history->id;
        }

        // demo mgid
        if ($operator->mgid == config('consumer.demo_gid')) {
            $sms_history->status_text = 'Successful';
            $sms_history->save();
            return $sms_history->id;
        }

        return $sms_history->id;
    }



    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->role == 'developer') {
            $sms_gateways = sms_gateway::all();
            return view('admins.developer.sms-gateways', [
                'sms_gateways' => $sms_gateways,
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->user()->role == 'developer') {
            $operators = operator::all();
            return view('admins.developer.sms-gateway-create', [
                'operators' => $operators,
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cache_key = 'sms_gw_' . $request->operator_id;
        if (Cache::has($cache_key)) {
            Cache::forget($cache_key);
        }
        $sms_gateway = new sms_gateway();
        $sms_gateway->operator_id = $request->operator_id;
        $sms_gateway->provider_name = $request->provider_name;
        $sms_gateway->username = $request->username;
        $sms_gateway->password = $request->password;
        $sms_gateway->from_number = $request->from_number;
        $sms_gateway->post_url = $request->post_url;
        $sms_gateway->delivery_report_url = $request->delivery_report_url;
        $sms_gateway->balance_check_url = $request->balance_check_url;
        $sms_gateway->unit_price = $request->unit_price;
        $sms_gateway->saleable = $request->saleable;
        $sms_gateway->save();
        return redirect()->route('sms_gateways.index')->with('success', 'SMS gateway has been added successfully!');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sms_gateway  $sms_gateway
     * @return \Illuminate\Http\Response
     */
    public function edit(sms_gateway $sms_gateway)
    {
        return view('admins.developer.sms-gateway-edit', [
            'sms_gateway' => $sms_gateway,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sms_gateway  $sms_gateway
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sms_gateway $sms_gateway)
    {
        $cache_key = 'sms_gw_' . $sms_gateway->operator_id;
        if (Cache::has($cache_key)) {
            Cache::forget($cache_key);
        }
        $sms_gateway->username = $request->username;
        $sms_gateway->password = $request->password;
        $sms_gateway->from_number = $request->from_number;
        $sms_gateway->post_url = $request->post_url;
        $sms_gateway->delivery_report_url = $request->delivery_report_url;
        $sms_gateway->balance_check_url = $request->balance_check_url;
        $sms_gateway->unit_price = $request->unit_price;
        $sms_gateway->saleable = $request->saleable;
        $sms_gateway->save();

        return redirect()->route('sms_gateways.index')->with('success', 'SMS Gateway has been updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sms_gateway  $sms_gateway
     * @return \Illuminate\Http\Response
     */
    public function destroy(sms_gateway $sms_gateway)
    {
        $cache_key = 'sms_gw_' . $sms_gateway->operator_id;
        if (Cache::has($cache_key)) {
            Cache::forget($cache_key);
        }
        $sms_gateway->delete();
        return redirect()->route('sms_gateways.index')->with('success', 'SMS Gateway has been deleted successfully');
    }
}
