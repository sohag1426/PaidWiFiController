@extends ('laraview.layouts.sideNavLayout')

@section('title')
create vpn account
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@if (Auth::user()->role == 'developer')
@php
$active_menu = '12';
$active_link = '3';
@endphp
@else
@php
$active_menu = '2';
$active_link = '8';
@endphp
@endif

@endsection

@section('sidebar')
@if (Auth::user()->role == 'developer')
@include('admins.developer.sidebar')
@else
@include('admins.group_admin.sidebar')
@endif
@endsection

@section('contentTitle')
<h3>Configure vpn account</h3>
@endsection

@section('content')

<div class="card card-outline card-primary">

    <div class="card-header">
        Run the following code into your MikroTik Terminal.
    </div>

    <div class="card-body">
        <code>
            /ppp profile
        </code>
        <br>
        <code>
            add local-address="{{ long2ip($vpn_account->ip_address) }}" name="vpn-profile" remote-address="{{ long2ip($vpn_pool->gateway) }}"
    </code>
        <hr>
        <code>
            /interface pptp-client
        </code>
        <br>
        <code>
        add comment="vpn-client" connect-to="{{ $vpn_server->nasname }}" disabled=no name="pptp-{{ $vpn_account->id }}" password="{{ $vpn_account->password }}" profile="vpn-profile" user="{{ $vpn_account->username }}"
    </code>
        <hr>
        <code>
            /ip firewall nat
        </code>
        <br>
        <code>
        add action=masquerade chain=srcnat comment="vpn-nat" dst-address="{{ long2ip($server_pool->subnet) }}/{{ $server_pool->mask }}"
    </code>
        <hr>
        <code>
            /ip route
        </code>
        <br>
        <code>
        add comment="vpn-route" distance=1 dst-address="{{ long2ip($server_pool->subnet) }}/{{ $server_pool->mask }}" gateway="{{ long2ip($vpn_pool->gateway) }}"
    </code>

    </div>

</div>

<div class="card card-outline card-warning">
    <div class="card-header">
        After configuring VPN Account, use <code> {{ long2ip($vpn_account->ip_address) }} </code> as your router IP
        address while adding router into the billing software.
    </div>
    <div class="card-body">
        <a class="btn btn-dark" href="{{ route('routers.create') }}" role="button">Add Router</a>
    </div>
</div>

@endsection

@section('pageJs')
@endsection
