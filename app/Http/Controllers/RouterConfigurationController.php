<?php

namespace App\Http\Controllers;

use App\Models\nas;
use App\Models\operator;
use Illuminate\Http\Request;
use RouterOS\Sohag\RouterosAPI;

class RouterConfigurationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\nas  $router
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, nas $router)
    {
        $where = [
            ['mgid', '=', $request->user()->id],
            ['role', '=', 'operator'],
        ];

        $operators = operator::where($where)->get();
        $operators = $operators->push($request->user());

        return view('admins.group_admin.router-configuration-create', [
            'router' => $router,
            'operators' => $operators,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\nas  $router
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, nas $router)
    {
        //configure for
        $operator = operator::findOrFail($request->operator_id);

        //radius server
        $radius_server = config('database.connections.' . $request->user()->radius_db_connection . '.host');

        if ($request->user()->role === 'developer') {
            $radius_server = config('database.connections.central.public_ip');
        }

        //central server
        $central_server = config('database.connections.central.public_ip');

        //API
        $config  = [
            'host' => $router->nasname,
            'user' => $router->api_username,
            'pass' => $router->api_password,
            'port' => $router->api_port,
            'attempts' => 1
        ];

        $api = new RouterosAPI($config);

        if (!$api->connect($config['host'], $config['user'], $config['pass'])) {

            return redirect()->route('routers.index')->with('error', 'Could not connect to the router!');
        }

        //Add radius information #hotspot,ppp
        $menu = 'radius';
        $rows = [
            [
                'accounting-port' => 3613,
                'address' => $radius_server,
                'authentication-port' => 3612,
                'secret' => $router['secret'],
                'service' => 'hotspot,ppp',
            ]
        ];
        $router_rows = $api->getMktRows($menu);
        $api->removeMktRows($menu, $router_rows);
        $api->addMktRows($menu, $rows);

        //system identity #Hotspot
        if ($request->filled('change_system_identity')) {
            NasIdentifierController::setIdentifier($operator, $router);
        }

        //Add Nat Rule #Hotspot
        $menu = 'ip_firewall_nat';
        $rows = [
            [
                'chain' => 'pre-hotspot',
                'dst-address-type' => '!local',
                'hotspot' => 'auth',
                'action' => 'accept',
                'comment' => 'bypassed auth',
            ]
        ];
        $api->addMktRows($menu, $rows);

        //walled-garden ip #Hotspot
        $walled_garden_ips = [
            ['action' => 'accept', 'dst-address' => $central_server, 'comment' => "Radius Server"],
        ];

        $api->addMktRows('walled_garden_ip', $walled_garden_ips);

        //Set IP Hotspot Profile #Hotspot
        $hotspot_profile = [
            'login-by' => 'mac,cookie,http-chap,http-pap,mac-cookie',
            'mac-auth-mode' => 'mac-as-username-and-password',
            'http-cookie-lifetime' => '6h',
            'split-user-domain' => 'no',
            'use-radius' => 'yes',
            'radius-accounting' => 'yes',
            'radius-interim-update' => '5m',
            'nas-port-type' => 'ethernet',
            'radius-mac-format' => 'XX:XX:XX:XX:XX:XX',
        ];

        $profiles = $api->getMktRows('ip_hotspot_profile');

        while ($profile = array_shift($profiles)) {

            $api->editMktRow('ip_hotspot_profile', $profile, $hotspot_profile);
        }

        // hotspot_user_profile <<priority GGC, FB, BDIX queues>>
        $login_script = [
            'on-login' => ':foreach n in=[/queue simple find comment=priority_1] do={ /queue simple move $n [:pick [/queue simple find] 0] }',
        ];

        $hotspot_user_profiles = $api->getMktRows('hotspot_user_profile');

        while ($user_profile = array_shift($hotspot_user_profiles)) {

            $api->editMktRow('hotspot_user_profile', $user_profile, $login_script);
        }

        //Set default-profile to default #ppp
        $pppoe_server_profile = [
            'authentication' => 'pap,chap,mschap1,mschap2',
            'one-session-per-host' => 'yes',
            'default-profile' => 'default',
        ];

        $pppoe_servers = $api->getMktRows('pppoe_server_server');
        while ($pppoe_server = array_shift($pppoe_servers)) {
            $api->editMktRow('pppoe_server_server', $pppoe_server, $pppoe_server_profile);
        }

        $local_address = [
            'local-address' => '10.0.0.1'
        ];

        $ppp_profiles = $api->getMktRows('ppp_profile', ['default' => 'yes']);
        while ($ppp_profile = array_shift($ppp_profiles)) {
            $api->editMktRow('ppp_profile', $ppp_profile, $local_address);
        }

        //Enable radius use #ppp
        $api->ttyWirte('/ppp/aaa/set', ['interim-update' => '5m', 'use-radius' => 'yes', 'accounting' => 'yes']);

        //Enable radius Incoming
        $api->ttyWirte('/radius/incoming/set', ['accept' => 'yes']);

        return redirect()->route('routers.index')->with('success', 'Router has been configured successfully!');
    }
}
