<?php

namespace App\Http\Controllers;

use App\Models\card_distributor;
use App\Models\customer_payment;
use App\Models\package;
use App\Models\pgsql_radacct_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CustomersWebInterfaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $mobile
     * @return \Illuminate\Http\Response
     */
    public function home(string $mobile)
    {
        $customer = CacheController::getCustomer($mobile);

        $operator = CacheController::getOperator($customer->operator_id);

        return view('customers.customer-home', [
            'customer' => $customer,
            'operator' => $operator,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $mobile
     * @return \Illuminate\Http\Response
     */
    public function profile(string $mobile)
    {
        $customer = CacheController::getCustomer($mobile);

        $operator = CacheController::getOperator($customer->operator_id);

        $cache_key = 'customer_radaccts_' . $customer->operator_id . '_' . $customer->id;

        $seconds = 600;

        $radaccts_history = Cache::remember($cache_key, $seconds, function () use ($customer, $operator) {
            $model = new pgsql_radacct_history();
            $model->setConnection($operator->pgsql_connection);
            return $model->where('username', $customer->username)->get();
        });

        return view('customers.customer-profile', [
            'customer' => $customer,
            'operator' => $operator,
            'radaccts_history' => $radaccts_history,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $mobile
     * @return \Illuminate\Http\Response
     */
    public function radaccts(string $mobile)
    {
        $customer = CacheController::getCustomer($mobile);

        $operator = CacheController::getOperator($customer->operator_id);

        $cache_key = 'customer_radaccts_' . $customer->operator_id . '_' . $customer->id;

        $seconds = 600;

        $radaccts_history = Cache::remember($cache_key, $seconds, function () use ($customer, $operator) {
            $model = new pgsql_radacct_history();
            $model->setConnection($operator->pgsql_connection);
            return $model->where('username', $customer->username)->get();
        });

        return view('customers.customer-radaccts', [
            'customer' => $customer,
            'radaccts_history' => $radaccts_history,
            'operator' => $operator,
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @param  string $mobile
     * @return \Illuminate\Http\Response
     */
    public function packages(Request $request, string $mobile)
    {

        $request->validate([
            'sort' => 'nullable|in:price,validity',
        ]);

        $customer = CacheController::getCustomer($mobile);

        // if a customer has a bill, customer package will change to package of id equal to package_id of the bill
        if ($customer->payment_status == 'billed') {
            return redirect()->route('customers.bills', ['mobile' => $customer->mobile]);
        }

        $operator = CacheController::getOperator($customer->operator_id);

        // packages
        $connection_type = $customer->connection_type;

        $cache_key = "customer_packages_" . $connection_type . '_' . $operator->id;

        $ttl = 600;

        $packages = Cache::remember($cache_key, $ttl, function () use ($operator, $customer) {

            $package_where = [
                ['operator_id', '=', $operator->id],
                ['visibility', '=', 'public'],
            ];

            $packages = package::with('master_package')->where($package_where)->get();

            $packages = $packages->filter(function ($package)  use ($customer) {
                return $package->master_package->connection_type === $customer->connection_type;
            });

            return $packages;
        });

        if ($request->filled('sort')) {
            $packages = $packages->sortBy($request->sort);
        }

        // payment_gateways
        if ($operator->subscription_status !== 'active') {
            $payment_gateways = 0;
            $recharge_card_gw =  0;
        } else {
            $PaymentGatewayController = new PaymentGatewayController();

            $payment_gateways = $PaymentGatewayController->getInternetPaymentGws($operator);

            $recharge_card_gw = PaymentGatewayController::rechargeCardGw($operator);
        }

        //return
        return view('customers.customers-packages', [
            'customer' => $customer,
            'packages' => $packages,
            'payment_gateways' => $payment_gateways,
            'recharge_card_gw' => $recharge_card_gw,
            'operator' => $operator,
        ]);
    }



    /**
     * Display a listing of the resource.
     *
     * @param  string $mobile
     * @return \Illuminate\Http\Response
     */
    public function cardStores(string $mobile)
    {

        $customer = CacheController::getCustomer($mobile);

        $operator = CacheController::getOperator($customer->operator_id);

        $card_distributors = card_distributor::where('operator_id', $operator->id)->get();

        //return
        return view('customers.customer-card-stores', [
            'customer' => $customer,
            'card_distributors' => $card_distributors,
            'operator' => $operator,
        ]);
    }



    /**
     * Display a listing of the resource.
     *
     * @param  string $mobile
     * @return \Illuminate\Http\Response
     */
    public function payments(string $mobile)
    {

        $customer = CacheController::getCustomer($mobile);

        $operator = CacheController::getOperator($customer->operator_id);

        // payments
        $payments_where = [
            ['operator_id', '=', $customer->operator_id],
            ['customer_id', '=', $customer->id],
        ];

        $payments = customer_payment::where($payments_where)->get();

        //return
        return view('customers.customer-payments', [
            'customer' => $customer,
            'payments' => $payments,
            'operator' => $operator,
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @param  string $mobile
     * @param  string $new_network
     * @return \Illuminate\Http\Response
     */
    public function networkCollision(string $mobile, string $new_network)
    {

        $customer = CacheController::getCustomer($mobile);

        //return
        return view('customers.found-in-other-network', [
            'customer' => $customer,
            'new_network' => $new_network,
        ]);
    }
}
