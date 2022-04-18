<?php

namespace App\Http\Controllers;

use App\Models\customer_payment;
use App\Models\package;
use App\Models\recharge_card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RechargeCardPaymentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(customer_payment $customer_payment)
    {
        //customer
        $customer = CacheController::getCustomer($customer_payment->mobile);

        $package = package::find($customer_payment->package_id);

        return view('customers.recharge-card-use', [
            'customer' => $customer,
            'customer_payment' => $customer_payment,
            'package' => $package,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, customer_payment $customer_payment)
    {
        $request->validate([
            'pin' => 'required|numeric',
        ]);

        $pin_where = [
            ['operator_id', '=', $customer_payment->operator_id],
            ['package_id', '=', $customer_payment->package_id],
            ['status', '=', 'unused'],
            ['pin', '=', $request->pin],
        ];

        $card_count = recharge_card::where($pin_where)->count();

        if ($card_count == 0) {
            return redirect()->route('customers.packages', ['mobile' => $customer_payment->mobile])->with('error', 'পিন নাম্বার প্যাকেজের  সাথে ম্যাচ করেনি !');
        }

        //update card
        $card = DB::transaction(function () use ($pin_where, $customer_payment) {
            $card = recharge_card::where($pin_where)->lockForUpdate()->firstOrFail();
            $card->customer_id = $customer_payment->customer_id;
            $card->mobile = $customer_payment->mobile;
            $card->status = 'used';
            $card->used_date = date(config('app.date_format'));
            $card->used_month = date(config('app.month_format'));
            $card->used_year = date(config('app.year_format'));
            $card->save();
            return $card;
        });

        $new_due = $customer_payment->amount_paid - $card->commission;
        $card->distributor->amount_due = $card->distributor->amount_due + $new_due;
        $card->distributor->save();

        //update payment
        $customer_payment->recharge_card_id = $card->id;
        $customer_payment->pgw_txnid = $request->pin;
        $customer_payment->bank_txnid = $request->pin;
        $customer_payment->pay_status = 'Successful';
        $customer_payment->store_amount = $customer_payment->amount_paid;
        $customer_payment->transaction_fee = 0;
        $customer_payment->save();

        //process payment
        CustomersPaymentProcessController::store($customer_payment);

        //Show Profile
        return redirect()->route('customers.profile', ['mobile' => $customer_payment->mobile])->with('success', 'Package has been activated successfully');
    }
}
