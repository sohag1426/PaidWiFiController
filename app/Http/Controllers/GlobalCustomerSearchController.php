<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GlobalCustomerSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $operator = $request->user();

        if (!$operator) {
            return json_encode([]);
        }

        $allowed_roles = ['group_admin', 'operator', 'sub_operator', 'manager'];

        if (in_array($operator->role, $allowed_roles) == false) {
            return json_encode([]);
        }

        if ($operator->role == 'manager') {
            $operator_id = $operator->group_admin->id;
        } else {
            $operator_id = $operator->id;
        }

        $cache_key = 'global_customer_search_' . $operator_id;

        $seconds = 600;

        return Cache::store('file')->remember($cache_key, $seconds, function () use ($operator_id) {

            $customers = customer::where('operator_id', $operator_id)->get();

            $mobiles = [];

            $usernames = [];

            $names = [];

            foreach ($customers as $customer) {

                $mobiles[] = $customer->mobile;

                if (strlen($customer->username)) {
                    $usernames[] = $customer->username;
                }

                if (strlen($customer->name)) {
                    $names[] = $customer->name;
                }
            }

            $mobiles_collection = collect($mobiles);
            $mobiles_collection->transform(function ($mobile) {
                return 'mobile :: ' . $mobile;
            });

            $usernames_collection = collect($usernames);
            $usernames_collection->transform(function ($username) {
                return 'username :: ' . $username;
            });

            $names_collection = collect($names);
            $names_collection->transform(function ($name) {
                return 'name :: ' . $name;
            });

            $collections = $mobiles_collection->concat($usernames_collection)->concat($names_collection);

            return $collections->toJson();
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $query)
    {
        $operator = $request->user();

        if ($operator->role == 'manager') {
            $operator_id = $operator->group_admin->id;
        } else {
            $operator_id = $operator->id;
        }

        $query_details = explode("::", $query);

        if (count($query_details) !== 2) {
            return 'Customer Not Found';
        }

        $key =  trim($query_details[0]);

        $value = trim($query_details[1]);

        $customer = 0;

        switch ($key) {
            case 'mobile':
                $cache_key = 'customer_' . $value;
                $seconds = 600;
                $customer = Cache::remember($cache_key, $seconds, function () use ($value) {
                    return customer::with(['custom_attributes', 'radaccts'])->where('mobile', $value)->first();
                });
                break;

            case 'username':
                $cache_key = 'customer_' . $operator_id . '_' . getVarName($value);
                $seconds = 600;
                $customer = Cache::remember($cache_key, $seconds, function () use ($value) {
                    return customer::with(['custom_attributes', 'radaccts'])->where('username', $value)->first();
                });
                break;

            case 'name':
                $cache_key = 'customer_' . $operator_id . '_' . getVarName($value);
                $seconds = 600;
                $customer = Cache::remember($cache_key, $seconds, function () use ($value, $operator_id) {
                    $where = [
                        ['name', '=', $value],
                        ['operator_id', '=', $operator_id],
                    ];
                    return customer::with(['custom_attributes', 'radaccts'])->where($where)->first();
                });
                break;
        }

        if ($customer) {
            $this->authorize('viewDetails', $customer);
            return CustomerDetailsController::getDetailedCustomerView($customer);
        } else {
            return 'Customer Not Found';
        }
    }
}
