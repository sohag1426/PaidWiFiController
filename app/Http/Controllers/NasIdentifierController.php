<?php

namespace App\Http\Controllers;

use App\Models\nas;
use App\Models\operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Net_IPv4;
use RouterOS\Sohag\RouterosAPI;

class NasIdentifierController extends Controller
{
    /**
     * Sanitize operator name or router location.
     *
     * @param  string  $name
     * @return string
     */
    public static function sanitizeName(string $name)
    {
        $string = trim($name);

        $allowed_chars = ['_', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

        if (strlen($string)) {
            $var = '';
            $chars = str_split($string);
            $len = count($chars);
            for ($i = 0; $i < $len; $i++) {
                if (in_array($chars[$i], $allowed_chars)) {
                    $var .= $chars[$i];
                } else {
                    $var .= '_';
                }
            }
            return substr($var, 0, 15);
        } else {
            return '_';
        }
    }

    /**
     * Set Identifier
     *
     * @param  \App\Models\operator $operator
     * @param  \App\Models\nas $nas
     * @return void
     */
    public static function setIdentifier(operator $operator, nas $nas)
    {
        $identifier = $operator->id . '--' . self::sanitizeName($operator->company) . '--' . self::sanitizeName($nas->location) . '--' . $nas->nasname;

        //API
        $config  = [
            'host' => $nas->nasname,
            'user' => $nas->api_username,
            'pass' => $nas->api_password,
            'port' => $nas->api_port,
            'attempts' => 1
        ];

        $api = new RouterosAPI($config);

        if (!$api->connect($config['host'], $config['user'], $config['pass'])) {

            return 0;
        }

        $api->ttyWirte('/system/identity/set', ['name' => $identifier]);

        $nas->description = 'Router Identity :- ' . $identifier;
        $nas->save();
    }

    /**
     * Get Operator
     *
     * @param  string  $nasidentifier
     * @return int || \App\Models\operator
     */
    public static function getOperator(string $nasidentifier)
    {
        $identity_parts = explode('--', $nasidentifier);

        if (count($identity_parts) === 4) {
            $operator_id = $identity_parts[0];
            return CacheController::getOperator($operator_id);
        }

        // legacy support
        $identity_parts = explode(':', $nasidentifier);

        if (count($identity_parts) === 2) {
            $operator_id = $identity_parts[0];
            return CacheController::getOperator($operator_id);
        }

        // Bad Identity
        return 0;
    }

    /**
     * Get nasipaddress
     *
     * @param  string  $nasidentifier
     * @return string
     */
    public static function getNasIpAddress(string $nasidentifier)
    {
        $identity_parts = explode('--', $nasidentifier);

        if (count($identity_parts) === 4) {
            return $identity_parts[3];
        }

        // legacy support
        $identity_parts = explode(':', $nasidentifier);

        if (count($identity_parts) === 2) {
            return $identity_parts[1];
        }

        // Bad Identity
        return 0;
    }

    /**
     * Get Router
     *
     * @param  string  $nasidentifier
     * @return int || \App\Models\Freeradius\nas
     */
    public static function getRouter(string $nasidentifier)
    {
        $operator_id = 0;

        $router_ip = 0;

        $identity_parts = explode('--', $nasidentifier);

        if (count($identity_parts) === 4) {
            $operator_id = $identity_parts[0];
            $router_ip = $identity_parts[3];
        } else {
            // legacy support
            $identity_parts = explode(':', $nasidentifier);
            if (count($identity_parts) === 2) {
                $operator_id = $identity_parts[0];
                $router_ip = $identity_parts[1];
            }
        }

        // << Bad Identity
        if ($operator_id == 0) {
            return 0;
        }

        $lib = new Net_IPv4();
        if ($lib->validateIP($router_ip) == false) {
            return 0;
        }

        $operator = CacheController::getOperator($operator_id);
        if (!$operator) {
            return 0;
        }
        //  Bad Identity >>

        $key = 'app_models_freeradius_nas_' . $operator_id . '_' . $router_ip;

        $ttl = 600;

        return Cache::remember($key, $ttl, function () use ($operator, $router_ip) {
            $model = new nas();
            $model->setConnection($operator->node_connection);
            return $model->where('nasname', $router_ip)->first();
        });
    }
}
