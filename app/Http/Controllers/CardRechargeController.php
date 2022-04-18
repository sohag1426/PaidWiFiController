<?php

namespace App\Http\Controllers;

use App\Models\customer_payment;
use App\Models\package;
use App\Models\recharge_card;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardRechargeController extends Controller
{
     /**
     * Show the form for creating a new resource.
     *
     * @param  string $mobile
     * @return \Illuminate\Http\Response
     */
    public function create(string $mobile)
    {
        $customer = CacheController::getCustomer($mobile);

        $operator = CacheController::getOperator($customer->operator_id);

        //return
        return view('customers.card-recharge', [
            'customer' => $customer,
            'operator' => $operator,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string $mobile
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, string $mobile)
    {
        $request->validate([
            'card_pin' => 'required|numeric',
        ]);

        $customer = CacheController::getCustomer($mobile);

        $operator = CacheController::getOperator($customer->operator_id);

        $card_pin = $request->card_pin;

        $pin_where = [
            ['operator_id', '=', $operator->id],
            ['status', '=', 'unused'],
            ['pin', '=', $card_pin],
        ];

        $card_count = recharge_card::where($pin_where)->count();

        if ($card_count == 0) {
            return redirect()->route('customers.packages', ['mobile' => $mobile])->with('error', 'Wrong PIN Number! Your Account My Get Locked!');
        }

        if ($card_count > 1) {
            return redirect()->route('customers.packages', ['mobile' => $mobile])->with('error', 'Processing Error! Try using Buy Package menu');
        }

        //update card
        $customer_payment = DB::transaction(function () use ($card_pin, $operator, $customer) {

            $pin_where = [
                ['operator_id', '=', $operator->id],
                ['status', '=', 'unused'],
                ['pin', '=', $card_pin],
            ];

            $card = recharge_card::where($pin_where)->lockForUpdate()->firstOrFail();

            $package = package::findOrFail($card->package_id);

            $master_package = $package->master_package;

            $mer_txnid = random_int(1000, 9999) . Carbon::now(config('app.timezone'))->timestamp;

            $customer_payment = new customer_payment();
            $customer_payment->mgid = $operator->mgid;
            $customer_payment->gid = $operator->gid;
            $customer_payment->operator_id = $operator->id;
            $customer_payment->cash_collector_id = 0;
            $customer_payment->customer_id = $customer->id;
            $customer_payment->package_id = $package->id;
            $customer_payment->validity_period = $master_package->validity;
            $customer_payment->previous_package_id = $customer->package_id;
            $customer_payment->payment_gateway_id = 0;
            $customer_payment->payment_gateway_name = 'recharge_card';
            $customer_payment->mobile = $customer->mobile;
            $customer_payment->name = $customer->name;
            $customer_payment->username = $customer->username;
            $customer_payment->type = 'RechargeCard';
            $customer_payment->pay_status = 'Successful';
            $customer_payment->amount_paid = $package->price;
            $customer_payment->store_amount = $package->price;
            $customer_payment->transaction_fee = 0;
            $customer_payment->mer_txnid = $mer_txnid;
            $customer_payment->pgw_txnid = $card_pin;
            $customer_payment->bank_txnid = $card_pin;
            $customer_payment->date = date(config('app.date_format'));
            $customer_payment->week = date(config('app.week_format'));
            $customer_payment->month = date(config('app.month_format'));
            $customer_payment->year = date(config('app.year_format'));
            $customer_payment->used = 0;
            $customer_payment->recharge_card_id = $card->id;
            $customer_payment->save();

            $card->customer_id = $customer_payment->customer_id;
            $card->mobile = $customer_payment->mobile;
            $card->status = 'used';
            $card->used_date = date(config('app.date_format'));
            $card->used_month = date(config('app.month_format'));
            $card->used_year = date(config('app.year_format'));
            $card->save();

            $new_due = $customer_payment->amount_paid - $card->commission;
            $card->distributor->amount_due = $card->distributor->amount_due + $new_due;
            $card->distributor->save();

            return $customer_payment;
        });

        //process payment
        CustomersPaymentProcessController::store($customer_payment);

        //Show Profile
        return redirect()->route('customers.profile', ['mobile' => $customer_payment->mobile])->with('success', 'Package has been activated successfully');
    }
}
