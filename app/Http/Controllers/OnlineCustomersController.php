<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\operator;
use App\Models\radacct;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class OnlineCustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'operator_id' => 'nullable|numeric',
        ]);

        if ($request->filled('operator_id')) {
            $operator_id = $request->operator_id;
            $operator = operator::findOrFail($operator_id);
            if ($request->user()->mgid !== $operator->mgid) {
                abort(403);
            }
        } else {
            if ($request->user()->role == 'manager') {
                $operator_id = $request->user()->gid;
            } else {
                $operator_id = $request->user()->id;
            }
        }

        $cache_key = 'online_customers_' . $operator_id;

        $seconds = 600;

        if ($request->filled('refresh')) {
            if (Cache::has($cache_key)) {
                Cache::forget($cache_key);
            }
        }

        $radaccts = Cache::remember($cache_key, $seconds, function () use ($operator_id) {
            return radacct::with('customer')->where('operator_id', $operator_id)
                ->whereNull('acctstoptime')
                ->get();
        });

        // Filter
        if ($request->filled('connection_type')) {
            $connection_type = $request->connection_type;
            $radaccts = $radaccts->filter(function ($radacct) use ($connection_type) {
                return $radacct->customer->connection_type == $connection_type;
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            $radaccts = $radaccts->filter(function ($radacct) use ($status) {
                return $radacct->customer->status == $status;
            });
        }

        if ($request->filled('payment_status')) {
            $payment_status = $request->payment_status;
            $radaccts = $radaccts->filter(function ($radacct) use ($payment_status) {
                return $radacct->customer->payment_status == $payment_status;
            });
        }

        if ($request->filled('zone_id')) {
            $zone_id = $request->zone_id;
            $radaccts = $radaccts->filter(function ($radacct) use ($zone_id) {
                return $radacct->customer->zone_id == $zone_id;
            });
        }

        if ($request->filled('device_id')) {
            $device_id = $request->device_id;
            $radaccts = $radaccts->filter(function ($radacct) use ($device_id) {
                return $radacct->customer->device_id == $device_id;
            });
        }

        if ($request->filled('package_id')) {
            $package_id = $request->package_id;
            $radaccts = $radaccts->filter(function ($radacct) use ($package_id) {
                return $radacct->customer->package_id == $package_id;
            });
        }

        if ($request->filled('username')) {
            $username = getUserName($request->username);
            $radaccts = $radaccts->filter(function ($radacct) use ($username) {
                return false !== stristr($radacct->username, $username);
            });
        }

        // Sorting
        if ($request->filled('sortby')) {
            $sortby = $request->sortby;

            if ($sortby == 'username') {
                $radaccts = $radaccts->sortBy('username');
            } else {
                $radaccts = $radaccts->sortByDesc('acctoutputoctets');
            }
        } else {
            $radaccts = $radaccts->sortByDesc('acctoutputoctets');
        }

        // length
        $length = 10;

        if ($request->filled('length')) {
            $length = $request->length;
        }

        $current_page = $request->input("page") ?? 1;
        $view_radaccts = new LengthAwarePaginator($radaccts->forPage($current_page, $length), $radaccts->count(), $length, $current_page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        $operator = $request->user();

        return view('admins.group_admin.online-customers', [
            'radaccts' => $view_radaccts,
            'length' => $length,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $online_customer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, string $online_customer)
    {
        $where = [];

        if ($online_customer == 'mobile') {
            if ($request->filled('mobile')) {
                $where[] = ['mobile', '=', $request->mobile];
            }
        }

        if ($online_customer == 'username') {
            if ($request->filled('username')) {
                $where[] = ['username', '=', $request->username];
            }
        }

        if (count($where) == 0) {
            return 'Offline';
        }

        $customer = customer::where($where)->first();

        if ($customer) {

            $this->authorize('viewDetails', $customer);

            $radacct = radacct::with('customer')->where('username', $customer->username)->whereNull('acctstoptime')->firstOr(function () {
                return 'Offline';
            });

            if ($radacct == 'Offline') {

                return '<button type="button" class="btn btn-block btn-outline-danger">Offline User</button>';
            } else {
                return view('admins.components.online-customer-search-result', [
                    'radacct' => $radacct,
                ]);
            }
        } else {
            return 'Customer Not Found';
        }
    }
}
