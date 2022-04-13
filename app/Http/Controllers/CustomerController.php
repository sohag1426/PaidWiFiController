<?php

namespace App\Http\Controllers;

use App\Models\all_customer;
use App\Models\customer;
use App\Models\pgsql_radacct_history;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     * For Filter customers of the same operator, we do not go to the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $request->validate([
            'status' => 'nullable|in:active,suspended,disabled',
            'package_id' => 'nullable|numeric',
            'operator_id' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'sortby' => 'nullable|in:id,username',
        ]);

        // requester
        $operator = $request->user();

        $filter = [];

        $cache_key = 'customers_';

        $ttl = 600;

        // default filter || mgid
        $filter[] = ['mgid', '=', $operator->mgid];
        $filter[] = ['operator_id', '=', $operator->id];
        $cache_key .= $operator->id;


        if ($request->filled('refresh')) {
            if (Cache::has($cache_key)) {
                Cache::forget($cache_key);
            }
        }

        $customers = Cache::remember($cache_key, $ttl, function () use ($filter) {
            return customer::where($filter)->get();
        });


        if ($request->filled('status')) {
            $status = $request->status;
            $customers = $customers->filter(function ($customer) use ($status) {
                return $customer->status == $status;
            });
        }

        if ($request->filled('package_id')) {
            $package_id = $request->package_id;
            $customers = $customers->filter(function ($customer) use ($package_id) {
                return $customer->package_id == $package_id;
            });
        }

        if ($request->filled('ip')) {
            $login_ip = $request->ip;
            $customers = $customers->filter(function ($customer) use ($login_ip) {
                return $customer->login_ip == $login_ip;
            });
        }

        if ($request->filled('mac_bind')) {
            $mac_bind = $request->mac_bind;
            $customers = $customers->filter(function ($customer) use ($mac_bind) {
                return $customer->mac_bind == $mac_bind;
            });
        }

        if ($request->filled('year')) {
            $registration_year = $request->year;
            $customers = $customers->filter(function ($customer) use ($registration_year) {
                return $customer->registration_year == $registration_year;
            });
        }

        if ($request->filled('month')) {
            $registration_month = $request->month;
            $customers = $customers->filter(function ($customer) use ($registration_month) {
                return $customer->registration_month == $registration_month;
            });
        }

        if ($request->filled('username')) {
            $username = getUserName($request->username);
            $customers = $customers->filter(function ($customer) use ($username) {
                return false !== stristr($customer->username, $username);
            });
        }

        if ($request->filled('comment')) {
            $comment = $request->comment;
            $customers = $customers->filter(function ($customer) use ($comment) {
                return false !== stristr($customer->comment, $comment);
            });
        }

        if ($request->filled('sortby')) {
            $sortby = $request->sortby;
            $customers = $customers->sortBy($sortby);
        }

        // length
        $length = 10;

        if ($request->filled('length')) {
            $length = $request->length;
        }

        $current_page = $request->input("page") ?? 1;

        $view_customers = new LengthAwarePaginator($customers->forPage($current_page, $length), $customers->count(), $length, $current_page, [
            'path' => $request->url(),
            'query' => $request->except('refresh'),
        ]);

        return view('admins.group_admin.customers', [
            'customers' => $view_customers,
            'length' => $length,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Freeradius\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, customer $customer)
    {

        $operator = $request->user();

        $seconds = 600;

        $radaccts_history_key = 'radaccts_history_' . $operator->id . '_' . $customer->id;

        $radaccts_history = Cache::remember($radaccts_history_key, $seconds, function () use ($customer) {
            return pgsql_radacct_history::where('username', $customer->username)->get();
        });

        return view('admins.group_admin.customers-show', [
            'customer' => $customer,
            'radaccts_history' => $radaccts_history,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Freeradius\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, customer $customer)
    {
        $this->authorize('update', $customer);

        if ($request->has('page')) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        return view('admins.group_admin.customers-edit', [
            'customer' => $customer,
            'page' => $page,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, customer $customer)
    {
        $this->authorize('update', $customer);

        $request->validate([
            'comment' => 'nullable|string|max:255',
        ]);

        $mobile = validate_mobile($request->mobile);

        //Invalid Mobile
        if ($mobile == 0) {
            return redirect()->route('customers.edit', ['customer' => $customer->id])->with('error', 'Invalid Mobile');
        }

        //Mobile Changed
        if ($customer->mobile !== $mobile) {
            $duplicate_mobile = all_customer::where('mobile', $mobile)->count();

            //Duplicate Mobile
            if ($duplicate_mobile) {
                return redirect()->route('customers.edit', ['customer' => $customer->id])->with('error', 'Duplicate Mobile');
            }
        }

        //update Central Database
        all_customer::updateOrCreate(
            [
                'mgid' => $request->user()->mgid,
                'customer_id' => $customer->id,
            ],
            [
                'operator_id' => $customer->operator_id,
                'mobile' => $mobile,
            ]
        );

        //update customer
        $customer->name = $request->name;
        $customer->mobile = $mobile;
        if ($request->filled('username')) {

            if (trim($request->username) !== getUserName($request->username)) {
                return redirect()->route('customers.edit', ['customer' => $customer->id])->with('error', 'Rejected: User-Name contains white space or Invalid characters');
            }

            if (trim($customer->username) !== trim($request->username)) {

                $duplicate = customer::where('username', trim($request->username))->count();

                if ($duplicate) {
                    return redirect()->route('customers.edit', ['customer' => $customer->id])->with('error', 'Duplicate Username');
                }

                $old_username = $customer->username;

                $customer->username = trim($request->username);
            }

            $customer->password = trim($request->password);
        }

        $customer->house_no = $request->house_no;
        $customer->road_no = $request->road_no;
        $customer->thana = $request->thana;
        $customer->district = $request->district;
        $customer->invalid_username = 0;
        $customer->save();

        if ($customer->wasChanged('username')) {
            PgsqlCustomerController::updateOrCreate($customer);
        }
        if ($customer->wasChanged('password')) {
            CustomersRadPasswordController::updateOrCreate($customer);
        }

        // clear cache
        CacheController::forgetCustomer($customer);

        if ($request->filled('page')) {
            $page = $request->page;
        } else {
            $page = 1;
        }
        //return customer's list
        return redirect()->route('customers.index', ['refresh' => 1, 'page' => $page])->with('success', 'The customer has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(customer $customer)
    {
        $where = [
            ['operator_id', '=', $customer->operator_id],
            ['customer_id', '=', $customer->id],
        ];

        all_customer::where($where)->delete();

        PgsqlCustomerController::destroy($customer);

        $customer->delete();

        if (url()->previous() == route('customers.index')) {
            $url = route('customers.index') . '?refresh=1';
        } else {
            $url = url()->previous() . '&refresh=1';
        }

        return redirect($url)->with('success', 'Customer Has been Deleted successfully');
    }
}
