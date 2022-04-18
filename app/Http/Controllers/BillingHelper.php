<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Carbon\Carbon;

class BillingHelper extends Controller
{
    /**
     * Return package_started_at
     *
     * @param  \App\Models\Freeradius\customer $customer
     * @return string
     */
    public static function startingDate(customer $customer)
    {
        $expiration = Carbon::createFromIsoFormat(config('app.expiry_time_format'), $customer->package_expired_at);

        $now = Carbon::now(config('app.timezone'));

        if ($expiration->lessThan($now)) {
            return $now->isoFormat(config('app.expiry_time_format'));
        } else {
            return $expiration->isoFormat(config('app.expiry_time_format'));
        }
    }

    /**
     * Return Due Date
     *
     * @param  \App\Models\Freeradius\customer $customer
     * @return string
     */
    public static function dueDate(customer $customer)
    {
        $expiration = Carbon::createFromIsoFormat(config('app.expiry_time_format'), $customer->package_expired_at);

        $now = Carbon::now(config('app.timezone'));

        if ($expiration->lessThan($now)) {
            $due_date = $now->format(config('app.date_format'));
        } else {
            $due_date = $expiration->format(config('app.date_format'));
        }

        return $due_date;
    }

    /**
     * Return package_expired_at
     *
     * @param  \App\Models\customer $customer
     * @param int $validity
     * @return string
     */
    public static function stoppingDate(customer $customer, int $validity)
    {
        $package_started_at = self::startingDate($customer);

        $package_expired_at = Carbon::createFromIsoFormat(config('app.expiry_time_format'), $package_started_at)->addDays($validity)->isoFormat(config('app.expiry_time_format'));

        return $package_expired_at;
    }

    /**
     * Return Billing Period
     *
     * @param  string $starting_date
     * @param int $validity
     * @return string
     */
    public static function billingPeriod(string $starting_date, int $validity)
    {
        if ($validity !== 30) {
            $period_start = Carbon::createFromIsoFormat(config('app.expiry_time_format'), $starting_date)->addDays(1)->format(config('app.billing_period_format'));
            $period_stop =  Carbon::createFromIsoFormat(config('app.expiry_time_format'), $starting_date)->addDays($validity)->format(config('app.billing_period_format'));
            return $period_start . ' to ' . $period_stop;
        }
        return date('F-Y');
    }
}
