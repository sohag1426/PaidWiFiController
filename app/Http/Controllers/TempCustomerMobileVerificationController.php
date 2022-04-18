<?php

namespace App\Http\Controllers;

use App\Models\all_customer;
use App\Models\customer;
use App\Models\operator;
use App\Models\temp_customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TempCustomerMobileVerificationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $mobile
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, string $mobile)
    {
        $customer_mobile = validate_mobile($mobile);

        if ($customer_mobile == 0) {
            abort(500, 'Invalid Mobile Number');
        }

        $customer_where = [
            ['connection_type', '=', 'Hotspot'],
            ['mobile', '=', $customer_mobile],
        ];

        $customer = temp_customer::where($customer_where)->firstOrFail();

        $operator = operator::findOrFail($customer->operator_id);

        //send and save otp
        if ($request->session()->has('sms_sent') == false) {

            $otp = random_int(1000, 9999);

            $customer->otp = $otp;

            $customer->save();

            $message =  route('root') . 'এ ব্যবহার করার জন্য কোডঃ ' . $otp;

            $sms_gateway = new SmsGatewayController();

            $sms_gateway->sendSms($operator, $customer->mobile, $message, $customer->id);

            session(['sms_sent' => $otp]);
        }

        return view('customers.temp-customer-mobile-verification-form', [
            'customer' => $customer,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $mobile
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, string $mobile)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $customer_mobile = validate_mobile($mobile);

        if ($customer_mobile == 0) {
            abort(500, 'Invalid Mobile Number');
        }

        $temp_customer_where = [
            ['connection_type', '=', 'Hotspot'],
            ['mobile', '=', $customer_mobile],
        ];

        $temp_customer = temp_customer::where($temp_customer_where)->firstOrFail();

        if ($temp_customer->otp != $request->otp) {
            return redirect()->route('temp_customer.mobile.verification', ['mobile' => $customer_mobile])->with('error', 'Invalid PIN');
        }

        // <<operator>>
        $operator = operator::find($temp_customer->operator_id);

        // <<trial package>>
        $package = PackageController::trialPackage($operator);
        $master_package = $package->master_package;

        // <<expiry_time>>
        $expiry_time = Carbon::now(config('app.timezone'))->addDays($master_package->validity)->isoFormat(config('app.expiry_time_format'));

        // <<duplicate check>>
        $model = new customer();

        $model->setConnection($operator->radius_db_connection);

        if ($model->where('username', $temp_customer->username)->count()) {

            // <<save new informations>>
            $mac_customer = $model->where('username', $temp_customer->username)->first();
            $mac_customer->password = $temp_customer->password;
            $mac_customer->router_ip = $temp_customer->router_ip;
            $mac_customer->router_id = $temp_customer->router_id;
            $mac_customer->login_mac_address = $temp_customer->login_mac_address;
            $mac_customer->save();

            // <<internet login>>
            HotspotInternetLoginController::login($mac_customer);

            // <<web login>>
            CustomerWebLoginController::startWebSession($mac_customer);

            // <<show page>>
            if ($mac_customer->status == 'suspended') {

                return redirect()->route('customers.packages', ['mobile' => $mac_customer->mobile]);
            }

            return redirect()->route('customers.profile', ['mobile' => $mac_customer->mobile]);
        }

        // <<new customer>>
        $customer = new customer();
        $customer->setConnection($operator->radius_db_connection);
        $customer->mgid = $temp_customer->mgid;
        $customer->gid = $temp_customer->gid;
        $customer->operator_id = $temp_customer->operator_id;
        $customer->company = $temp_customer->company;
        $customer->connection_type = $temp_customer->connection_type;
        $customer->name = $temp_customer->name;
        $customer->mobile = $temp_customer->mobile;
        $customer->verified_mobile = 1;
        $customer->mobile_verified_at = date(config('app.date_format'));
        $customer->username = trim($temp_customer->username);
        $customer->password = trim($temp_customer->password);
        $customer->package_id = $package->id;
        $customer->package_name = $package->name;
        $customer->package_started_at = Carbon::now(config('app.timezone'));
        $customer->package_expired_at = $expiry_time;
        $customer->total_octet_limit = $master_package->total_octet_limit;
        $customer->router_ip = $temp_customer->router_ip;
        $customer->router_id = $temp_customer->router_id;
        $customer->link_login_only = $temp_customer->link_login_only;
        $customer->link_logout = $temp_customer->link_logout;
        $customer->login_ip = $temp_customer->login_ip;
        $customer->login_mac_address = $temp_customer->login_mac_address;

        // <<Registration timestamp>>
        $customer->registration_date = date(config('app.date_format'));
        $customer->registration_week = date(config('app.week_format'));
        $customer->registration_month = date(config('app.month_format'));
        $customer->registration_year = date(config('app.year_format'));
        $customer->save();

        // <<Central customer information>>
        $all_customer = new all_customer();
        $all_customer->mgid = $operator->mgid;
        $all_customer->operator_id = $temp_customer->operator_id;
        $all_customer->customer_id = $customer->id;
        $all_customer->mobile = $temp_customer->mobile;
        $all_customer->save();

        // <<radius information>>
        HotspotCustomersRadAttributesController::updateOrCreate($customer);

        // <<clean garbage>>
        $temp_customer->delete();

        $request->session()->forget('sms_sent');

        // <<web session>>
        CustomerWebLoginController::startWebSession($customer);

        return redirect()->route('customers.packages', ['mobile' => $customer->mobile]);
    }
}
