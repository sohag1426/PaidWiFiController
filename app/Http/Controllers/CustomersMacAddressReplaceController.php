<?php

namespace App\Http\Controllers;

use App\Models\all_customer;
use App\Models\customer;
use App\Models\operator;
use Illuminate\Http\Request;

class CustomersMacAddressReplaceController extends Controller
{

    public function initiate(string $mobile)
    {

        /**
         * Show the form for creating a new resource.
         *
         * @param string $mobile
         * @return \Illuminate\Http\Response
         */
        $customer_mobile = validate_mobile($mobile);

        if ($customer_mobile == 0) {
            abort(500, 'Invalid Mobile Number');
        }

        $customer = CacheController::getCustomer($customer_mobile);

        if ($customer->mac_replace_date == date(config('app.date_format'))) {

            if (config('consumer.currency') == "BDT") {
                $message = "দুঃখিত, আপনি আপনার ডিভাইস দিনে একবারের বেশি পরিবর্তন  করতে পারবেন না ।";
            } else {
                $message = "Sorry, You can not change your device more than once daily!";
            }

            abort(500, $message);
        }

        return view('customers.suspicious-login', [
            'customer' => $customer,
        ]);
    }

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

        $customer_info = all_customer::where('mobile', $customer_mobile)->firstOrFail();

        $operator = operator::findOrFail($customer_info->operator_id);

        $model = new customer();

        $model->setConnection($operator->radius_db_connection);

        $customer = $model->findOrFail($customer_info->customer_id);

        //send and save otp
        if ($request->session()->has('sms_sent') == false) {

            $otp = random_int(1000, 9999);

            $customer->otp = $otp;

            $customer->save();

            $message = route('root') . 'এ ব্যবহার করার জন্য কোডঃ ' . $otp;

            $sms_gateway = new SmsGatewayController();

            $sms_gateway->sendSms($operator, $customer->mobile, $message, $customer->id);

            session(['sms_sent' => $otp]);
        }

        return view('customers.mac-replace-form', [
            'customer' => $customer,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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

        $customer_info = all_customer::where('mobile', $customer_mobile)->firstOrFail();

        $operator = operator::findOrFail($customer_info->operator_id);

        $model = new customer();

        $model->setConnection($operator->radius_db_connection);

        $customer = $model->findOrFail($customer_info->customer_id);

        if ($customer->otp != $request->otp) {
            return redirect()->route('customer.replace.mac', ['mobile' => $customer_mobile])->with('error', 'Invalid PIN');
        }

        $request->session()->forget('sms_sent');

        session(['verified_mobile' => $customer->verified_mobile]);

        $customer->verified_mobile = 1;
        $customer->mobile_verified_at = date(config('app.date_time_format'));
        $customer->mac_replace_date = date(config('app.date_format'));
        $customer->username = trim($customer->login_mac_address);
        $customer->password = trim($customer->login_mac_address);
        $customer->save();

        HotspotCustomersRadAttributesController::updateOrCreate($customer);

        HotspotInternetLoginController::login($customer);

        return redirect()->route('customers.profile', ['mobile' => $customer->mobile]);
    }
}
