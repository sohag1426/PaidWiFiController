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

<ul class="nav flex-column flex-sm-row">
    <!--New Operator-->
    <li class="nav-item mr-2">
        <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('routers.create') }}">
            <i class="fas fa-plus"></i>
            New Router
        </a>
    </li>
    <!--/New Operator-->

    <!--upload pppoe profile-->
    <li class="nav-item">
        <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('upload-ppp-profile') }}">
            <i class="fas fa-upload"></i>
            Upload PPP Profiles
        </a>
    </li>
    <!--/upload pppoe profile-->

</ul>

@endsection

@include('admins.components.routers')
