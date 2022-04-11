@extends ('laraview.layouts.sideNavLayout')

@section('title')
Routers
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '2';
$active_link = '1';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@section('contentTitle')

<ul class="nav nav-fill flex-column flex-sm-row">

    <!--New Router-->
    <h3>New Router</h3>
    <!--/New Payment-->

    <!--Get VPN Account-->
    @can('viewAny', App\Models\vpn_account::class)
    <li class="nav-item">
        <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('vpn_accounts.create') }}">
            <i class="fas fa-shield-alt"></i>
            Get VPN Account
        </a>
    </li>
    @endcan
    <!--/Get VPN Account -->

</ul>

@endsection

@include('admins.components.routers-create')
