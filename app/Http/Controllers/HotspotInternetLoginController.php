<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\nas;
use Illuminate\Http\Request;
use RouterOS\Sohag\RouterosAPI;

class HotspotInternetLoginController extends Controller
{
    /**
     * Internet Login for Hotspot Customer
     *
     * @param \App\Models\Freeradius\customer $customer
     */
    public static function login(customer $customer)
    {
        $operator = CacheController::getOperator($customer->operator_id);

        //router
        $nas_where = [
            ['mgid', '=', $operator->mgid],
            ['nasname', '=', $customer->router_ip],
        ];

        $model = new nas();

        $model->setConnection($operator->radius_db_connection);

        $router = $model->where($nas_where)->firstOr(function () {
            return null;
        });

        if (!$router) {
            return 0;
        }

        $config  = [
            'host' => $router->nasname,
            'user' => $router->api_username,
            'pass' => $router->api_password,
            'port' => $router->api_port,
            'attempts' => 1
        ];

        $api = new RouterosAPI($config);

        $command = '/ip/hotspot/active/login';

        $row = [
            'ip' => $customer->login_ip,
            'mac-address' => $customer->login_mac_address,
            'user' => $customer->username,
            'password' => $customer->password,
        ];

        $api->ttyWirte($command, $row);
    }

    /**
     * Logout Hotspot Customer From Internet
     *
     * @param \App\Models\Freeradius\customer $customer
     */
    public static function logout(customer $customer)
    {
        $operator = CacheController::getOperator($customer->operator_id);

        //router
        $nas_where = [
            ['mgid', '=', $operator->mgid],
            ['nasname', '=', $customer->router_ip],
        ];

        $model = new nas();

        $model->setConnection($operator->radius_db_connection);

        $router = $model->where($nas_where)->firstOr(function () {
            return null;
        });

        if (!$router) {
            return 0;
        }

        $config  = [
            'host' => $router->nasname,
            'user' => $router->api_username,
            'pass' => $router->api_password,
            'port' => $router->api_port,
            'attempts' => 1
        ];

        $api = new RouterosAPI($config);

        $rows = $api->getMktRows('hotspot_active', ['user' => $customer->username]);

        $api->removeMktRows('hotspot_active', $rows);
    }
}
