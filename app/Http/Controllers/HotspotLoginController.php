<?php

namespace App\Http\Controllers;

use App\Models\all_customer;
use App\Models\customer;
use App\Models\operator;
use App\Models\pgsql_radacct_history;
use App\Models\temp_customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HotspotLoginController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // <<validate mobile>>
        $mobile = $request->mobile = validate_mobile($request->mobile);

        if ($mobile == 0) {
            abort(500, 'Invalid Mobile Number');
        }

        // <<validate request>>
        $request->validate([
            'system_identity' => ['required', 'string'],
            'login_ip' => ['required', 'string'],
            'login_mac_address' => ['required', 'string'],
        ]);

        //  <router_ip>>
        $router_ip = NasIdentifierController::getNasIpAddress($request->system_identity);
        if ($router_ip == 0) {
            abort(500, 'Bad Identity');
        }

        // <<operator: Use to set database connection>>
        $operator = NasIdentifierController::getOperator($request->system_identity);
        if (!$operator) {
            abort(500, 'Operator Not Found');
        }

        // << router : Use to set customer router property
        $router = NasIdentifierController::getRouter($request->system_identity);
        if (!$router) {
            abort(500, 'Router Not Found');
        }

        // <<count customer in the requested radius server>>
        $model = new customer();
        $model->setConnection($operator->radius_db_connection);
        $mobile_count = $model->where('mobile', $mobile)->count();
        $mac_count = $model->where('username', $request->login_mac_address)->count();

        // << 0 0 |  Registerd with other radius server | Require Registration >>
        if ($mobile_count == 0 && $mac_count == 0) {
            $customer_count = 0;
        }

        // << 0 1 | Forgot mobile number | Show Profile >>
        if ($mobile_count == 0 && $mac_count == 1) {
            $customer_count = 1;
        }

        // << 1 0 | Lost or changed device | Require Mac Replace | Not Hotspot Customer>>
        if ($mobile_count == 1 && $mac_count == 0) {
            $customer_count = 10;
        }

        // << 1 1 | Found one or multiple customer | Consider only the device | Show profile >>
        if ($mobile_count == 1 && $mac_count == 1) {
            $customer_count = 11;
        }

        // <<case#1 Registered with other network || different radius server>>
        if ($customer_count == 0) {

            $central_info_count = all_customer::where('mobile', $mobile)->count();

            if ($central_info_count == 1) {

                $central_customer_info = all_customer::where('mobile', $mobile)->firstOrFail();

                $registered_operator = operator::findOrFail($central_customer_info->operator_id);

                $model = new customer();

                $model->setConnection($registered_operator->radius_db_connection);

                $customer = $model->findOrFail($central_customer_info->customer_id);

                $customer->link_login_only = $request->link_login_only;

                $customer->save();

                return redirect()->route('customers.network-collision', ['mobile' => $mobile, 'new_network' => $operator->company]);
            }
        }

        // <<case#2 new registration>>
        if ($customer_count == 0) {

            //remove previous attempts
            temp_customer::where('mobile', $mobile)->delete();

            //add new attempt
            $tmp_customer = new temp_customer();
            $tmp_customer->mgid = $operator->mgid;
            $tmp_customer->gid = $operator->gid;
            $tmp_customer->operator_id = $operator->id;
            $tmp_customer->company = $operator->company;
            $tmp_customer->connection_type = 'Hotspot';
            $tmp_customer->name = $request->mobile;
            $tmp_customer->mobile = $request->mobile;
            $tmp_customer->username = $request->login_mac_address;
            $tmp_customer->password = $request->login_mac_address;
            $tmp_customer->router_ip = $router_ip;
            $tmp_customer->router_id = $router->id;
            $tmp_customer->link_login_only = $request->link_login_only;
            $tmp_customer->link_logout = $request->link_logout;
            $tmp_customer->login_ip = $request->login_ip;
            $tmp_customer->login_mac_address = $request->login_mac_address;
            $tmp_customer->save();

            return redirect()->route('temp_customer.mobile.verification', ['mobile' => $mobile]);
        }

        // <<case#3 Not hotspot customer Or Require MAC Change>>
        if ($customer_count == 10) {

            $model = new customer();
            $model->setConnection($operator->radius_db_connection);
            $customer = $model->where('mobile', $mobile)->first();

            // <<billed ppp customer>>
            if ($customer->connection_type == 'PPPoE' && $customer->payment_status == 'billed') {
                CustomerWebLoginController::startWebSession($customer);
                return redirect()->route('customers.bills', ['mobile' => $customer->mobile]);
            }

            // <<Only Hotspot customer is supported>>
            if ($customer->connection_type !== 'Hotspot') {
                $message = 'Captive portal login for ' . $customer->connection_type . ' user not supported';
                abort(500, $message);
            }

            // <<Replace MAC Address >> Auto Login Failed>>
            if ($customer->connection_type === 'Hotspot' && $customer->username !== $request->login_mac_address) {
                // <<save new informations >> Will be Required to set the new MAC as new Username and everything else to display as customer info>>
                $customer->link_login_only = $request->link_login_only;
                $customer->link_logout = $request->link_logout;
                $customer->login_ip = $request->login_ip;
                $customer->login_mac_address = $request->login_mac_address;
                $customer->router_ip = $router_ip;
                $customer->router_id = $router->id;
                $customer->save();
                CustomerWebLoginController::startWebSession($customer);
                return redirect()->route('customer.suspicious-login', ['mobile' => $mobile]);
            }
        }


        // <<found customer>>
        if ($customer_count == 1 || $customer_count == 11) {

            $model = new customer();
            $model->setConnection($operator->radius_db_connection);
            $customer = $model->where('username', $request->login_mac_address)->first();

            // <<In Case billed ppp customer>>
            if ($customer->connection_type == 'PPPoE' && $customer->payment_status == 'billed') {
                CustomerWebLoginController::startWebSession($customer);
                return redirect()->route('customers.bills', ['mobile' => $customer->mobile]);
            }

            // <<In Case Not a Hotspot customer>>
            if ($customer->connection_type !== 'Hotspot') {
                $message = 'Captive portal login for ' . $customer->connection_type . ' user not supported';
                abort(500, $message);
            }

            // <<save new informations > router_ip will be used by system for force login user and everything else as user info >>
            $customer->link_login_only = $request->link_login_only;
            $customer->link_logout = $request->link_logout;
            $customer->login_ip = $request->login_ip;
            $customer->login_mac_address = $request->login_mac_address;
            $customer->router_ip = $router_ip;
            $customer->router_id = $router->id;
            $customer->save();

            // <<case#4 Customer is suspended>>

            // <<suspended due to Volume Limit>>
            if ($customer->total_octet_limit) {
                $pgsql_radacct_history = new pgsql_radacct_history();
                $pgsql_radacct_history->setConnection($operator->pgsql_connection);
                $download = $pgsql_radacct_history->where('username', '=', $customer->username)->sum('acctoutputoctets');
                $upload = $pgsql_radacct_history->where('username', '=', $customer->username)->sum('acctinputoctets');
                if (($download + $upload) > $customer->total_octet_limit) {
                    $customer->status = 'suspended';
                    $customer->suspend_reason = 'volume_limit_exceeds';
                    $customer->save();
                }
            }

            //  <<suspended due to Time Limit>>
            $expiration = Carbon::createFromIsoFormat(config('app.expiry_time_format'), $customer->package_expired_at);
            $now = Carbon::now(config('app.timezone'));
            if ($expiration->lessThan($now)) {
                $customer->status = 'suspended';
                $customer->suspend_reason = 'time_limit_exceeds';
                $customer->save();
            }

            if ($customer->status === 'suspended') {

                CustomerWebLoginController::startWebSession($customer);

                return redirect()->route('customers.packages', ['mobile' => $customer->mobile]);
            }

            // <<case#5 Auto Login Failed>>
            HotspotInternetLoginController::login($customer);

            //show Profile
            CustomerWebLoginController::startWebSession($customer);

            return redirect()->route('customers.profile', ['mobile' => $customer->mobile]);
        }
    }
}
