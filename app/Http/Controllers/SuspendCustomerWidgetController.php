<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SuspendCustomerWidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $operator = $request->user();

        $operator_id = $operator->id;

        $filter = [];
        $filter[] = ['status', '=', 'suspended'];
        $filter[] = ['operator_id', '=', $operator_id];

        $cache_key = 'suspended_customer_widget_' . $operator_id;
        $seconds = 300;

        return Cache::remember($cache_key, $seconds, function () use ($filter) {
            return customer::where($filter)->count();
        });
    }
}
