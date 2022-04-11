<?php

namespace App\Http\Controllers;

use App\Models\all_customer;
use App\Models\customer;
use App\Models\nas;
use App\Models\operator;
use App\Models\package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    /**
     * Retrieving Operator From The Cache
     *
     * @param  int $operator_id
     * @return \App\Models\operator
     */
    public static function getOperator(int $operator_id)
    {
        $key = 'app_models_operator_' . $operator_id;

        $ttl = 600;

        return Cache::remember($key, $ttl, function () use ($operator_id) {
            return operator::find($operator_id);
        });
    }

    /**
     * Retrieving Customer From The Cache
     *
     * @param string $mobile
     * @return \App\Models\Freeradius\customer
     */

    public static function getCustomer(string $mobile)
    {

        $customer_mobile = validate_mobile($mobile);

        if ($customer_mobile == 0) {
            abort(500, 'Invalid Mobile Number');
        }

        // Changing cache_key require a change in keys of the forgetCustomer function

        $cache_key = 'customer_' . $customer_mobile;

        $seconds = 600;

        return Cache::remember($cache_key, $seconds, function () use ($customer_mobile) {

            $customer_info = all_customer::where('mobile', $customer_mobile)->firstOrFail();

            $operator = self::getOperator($customer_info->operator_id);

            $model = new customer();

            $model->setConnection($operator->radius_db_connection);

            $customer = $model->findOrFail($customer_info->customer_id);

            return $customer;
        });
    }

    /**
     * Removing Customer From The Cache
     *
     * @param  \App\Models\Freeradius\customer
     * @return void
     */
    public static function forgetCustomer(customer $customer)
    {
        $customer_name = strlen($customer->name) ? $customer->name : 'f';

        // keys need to change if change made in the cache retrieving functions
        $keys = [
            'customer_' . $customer->mobile,
            'customer_' . $customer->operator_id . '_' . getVarName($customer->username),
            'customer_' . $customer->gid . '_' . getVarName($customer->username),
            'customer_' . $customer->operator_id . '_' . getVarName($customer_name),
            'customer_' . $customer->gid . '_' . getVarName($customer_name),
            'customer_' . $customer->operator_id . '_' . $customer->id,
            'customer_' . $customer->gid . '_' . $customer->id,
            'radaccts_history_' . $customer->operator_id . '_' . $customer->id,
            'radaccts_history_' . $customer->gid . '_' . $customer->id,
        ];

        foreach ($keys as $key) {
            if (Cache::has($key)) {
                Cache::forget($key);
            }
        }
    }

    /**
     * Retrieving Nas From The Cache
     *
     * @param  int $operator_id
     * @param  int $nas_id
     * @return \App\Models\Freeradius\nas
     */
    public static function getNas(int $operator_id, int $nas_id)
    {
        $key = 'app_models_freeradius_nas_' . $operator_id . '_' . $nas_id;

        $ttl = 600;

        $operator = self::getOperator($operator_id);

        return Cache::remember($key, $ttl, function () use ($operator, $nas_id) {
            $model = new nas();
            $model->setConnection($operator->node_connection);
            return $model->find($nas_id);
        });
    }

    /**
     * Retrieving Package From The Cache
     *
     * @param  int $package_id
     * @return \App\Models\package
     */
    public static function getPackage(int $package_id)
    {
        $key = 'app_models_package_' . $package_id;

        $ttl = 600;

        return Cache::remember($key, $ttl, function () use ($package_id) {
            return package::with('master_package')->find($package_id);
        });
    }
}
