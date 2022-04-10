<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;

class DatabaseConnectionAssignController extends Controller
{
    /**
     * Assign Database connection
     *
     * @return database connection name
     */
    public static function assignDatabaseConnection()
    {
        $connections = [];

        if (config()->has('database.nodes')) {

            $nodes = explode(",", config('database.nodes'));
        } else {

            abort(500);
        }

        foreach ($nodes as $node) {
            $model = new customer();
            $model->setConnection($node);
            $customer_count = $model->count();
            $connections[$node] = $customer_count;
        }

        asort($connections);

        return array_key_first($connections);
    }
}
