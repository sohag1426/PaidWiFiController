<?php

namespace App\Http\Controllers;

use App\Models\operator;
use App\Models\payment_gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->role == 'developer') {
            $payment_gateways = payment_gateway::all();
            return view('admins.developer.payment-gateways', [
                'payment_gateways' => $payment_gateways,
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
            return view('admins.developer.payment-gateway-create', [
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
        if ($request->file('credentials_path')) {
            $path =  $request->file('credentials_path')->store($request->provider_name . $request->operator_id);
        } else {
            $path = null;
        }

        $payment_gateway = new payment_gateway();
        $payment_gateway->operator_id = $request->operator_id;
        $payment_gateway->provider_name = $request->provider_name;
        $payment_gateway->send_money_provider = $request->send_money_provider;
        $payment_gateway->payment_method = $request->payment_method;
        $payment_gateway->username = $request->username;
        $payment_gateway->password = $request->password;
        $payment_gateway->msisdn = $request->msisdn;
        $payment_gateway->credentials_path = $path;
        $payment_gateway->inheritable = $request->inheritable;
        $payment_gateway->service_charge_percentage = $request->service_charge_percentage;
        $payment_gateway->save();
        $cache_key = 'internet_payment_gw_' . $payment_gateway->operator_id;
        Cache::forget($cache_key);
        return redirect()->route('payment_gateways.index')->with('success', 'Gateway added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\payment_gateway  $payment_gateway
     * @return \Illuminate\Http\Response
     */
    public function show(payment_gateway $payment_gateway)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\payment_gateway  $payment_gateway
     * @return \Illuminate\Http\Response
     */
    public function edit(payment_gateway $payment_gateway)
    {
        return view('admins.developer.payment-gateway-edit', [
            'payment_gateway' => $payment_gateway,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\payment_gateway  $payment_gateway
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, payment_gateway $payment_gateway)
    {
        $cache_key = 'internet_payment_gw_' . $payment_gateway->operator_id;
        Cache::forget($cache_key);
        $payment_gateway->payment_method = $request->payment_method;
        $payment_gateway->username = $request->username;
        $payment_gateway->password = $request->password;
        $payment_gateway->msisdn = $request->msisdn;
        $payment_gateway->inheritable = $request->inheritable;
        $payment_gateway->service_charge_percentage = $request->service_charge_percentage;
        if ($request->file('credentials_path')) {
            $path =  $request->file('credentials_path')->store($payment_gateway->provider_name . $request->operator_id);
            $payment_gateway->credentials_path = $path;
        }
        $payment_gateway->save();
        return redirect()->route('payment_gateways.index')->with('success', 'payment gateway has been updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\payment_gateway  $payment_gateway
     * @return \Illuminate\Http\Response
     */
    public function destroy(payment_gateway $payment_gateway)
    {
        $cache_key = 'internet_payment_gw_' . $payment_gateway->operator_id;
        Cache::forget($cache_key);
        $payment_gateway->delete();
        return redirect()->route('payment_gateways.index')->with('success', 'Gateway has been deleted successfully');
    }


    /**
     * List Internet Payment Gateways.
     *
     * @param  \App\Models\operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function getInternetPaymentGws(operator $operator)
    {
        $cache_key = 'internet_payment_gw_' . $operator->id;

        $ttl = 600;

        return Cache::remember($cache_key, $ttl, function () use ($operator) {

            //use own PGw
            $count = payment_gateway::where('operator_id', $operator->id)->count();

            if ($count) {
                return payment_gateway::where('operator_id', $operator->id)->get();
            }

            if ($operator->role == 'operator' || $operator->role == 'sub_operator') {

                //use Group Admins PGw
                $where = [
                    ['operator_id', '=', $operator->gid],
                    ['inheritable', '=', 1],
                ];

                $count = payment_gateway::where($where)->count();

                if ($count) {
                    return payment_gateway::where($where)->get();
                }

                //use Master Admins PGw
                $where = [
                    ['operator_id', '=', $operator->mgid],
                    ['inheritable', '=', 1],
                ];

                $count = payment_gateway::where($where)->count();

                if ($count) {
                    return payment_gateway::where($where)->get();
                }

                //use Super Admins PGw
                $madmin = operator::find($operator->mgid);

                if ($madmin->using_payment_gateway == 0) {
                    return 0;
                }

                $where = [
                    ['operator_id', '=', $operator->sid],
                    ['inheritable', '=', 1],
                ];

                $count = payment_gateway::where($where)->count();

                if ($count) {
                    return payment_gateway::where($where)->get();
                }
            }

            if ($operator->role == 'group_admin') {

                if ($operator->using_payment_gateway == 0) {
                    return 0;
                }

                //use Super Admins PGw
                $where = [
                    ['operator_id', '=', $operator->sid],
                    ['inheritable', '=', 1],
                ];

                $count = payment_gateway::where($where)->count();

                if ($count) {
                    return payment_gateway::where($where)->get();
                }
            }

            return 0;
        });
    }



    /**
     * Recharge Card Payment Gateways.
     *
     * @param  \App\Models\operator  $operator
     * @return \Illuminate\Http\Response
     */

    public static function rechargeCardGw(operator $operator)
    {
        return payment_gateway::make([
            'id' => 0,
            'operator_id' => $operator->id,
            'provider_name' => 'recharge_card',
            'payment_method' => 'Recharge Card',
        ]);
    }
}
