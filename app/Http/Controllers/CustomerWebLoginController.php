<?php

namespace App\Http\Controllers;

use App\Models\all_customer;
use App\Models\customer;
use App\Models\operator;
use Illuminate\Http\Request;

class CustomerWebLoginController extends Controller
{
    /**
     * Process Customer Login Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $mobile = session('authenticated_customer_mobile', 0);

        if ($mobile) {
            return redirect()->route('customers.home', ['mobile' => $mobile]);
        } else {
            return view('customers.web-login');
        }
    }


    /**
     * Process Customer Login Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required|numeric',
        ]);

        $mobile = validate_mobile($request->mobile);

        if ($mobile == 0) {
            abort(500, 'Invalid Mobile Number');
        }

        $customer_where = [];
        $customer_where[] = ['mobile', '=', $mobile];

        if ($request->filled('customer_id')) {
            $customer_where[] = ['customer_id', '=', $request->customer_id];
        }

        $central_information = all_customer::where($customer_where)->firstOrFail();

        $operator = operator::findOrFail($central_information->operator_id);

        $model = new customer();

        $model->setConnection($operator->radius_db_connection);

        $customer = $model->findOrFail($central_information->customer_id);

        session(['authenticated_customer_mobile' => $customer->mobile]);

        session(['verified_mobile' => $customer->verified_mobile]);

        $request->session()->regenerate();

        return redirect()->route('customers.home', ['mobile' => $customer->mobile]);
    }


    /**
     * Process Customer Logout Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        if ($request->session()->has('authenticated_customer_mobile')) {

            $request->session()->forget('authenticated_customer_mobile');

            $request->session()->forget('verified_mobile');

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }

        return redirect()->route('root');
    }


    /**
     * Start Web Session
     *
     * @param  \App\Models\Freeradius\customer
     */
    public static function startWebSession(customer $customer)
    {
        session(['authenticated_customer_mobile' => $customer->mobile]);
        session(['verified_mobile' => $customer->verified_mobile]);
    }
}
