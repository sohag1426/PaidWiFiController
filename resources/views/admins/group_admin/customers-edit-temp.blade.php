@extends ('laraview.layouts.sideNavLayout')

@section('title')
New customer
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '5';
$active_link = '0';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@section('contentTitle')
<ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('packages.index') }}">New Package</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('temp_billing_profiles.create') }}">New Billing Profile</a>
    </li>
</ul>
@endsection

@include('admins.components.customers-edit-temp')
