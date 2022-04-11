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
<a class="btn btn-link" href="{{ route('customer_zones.create') }}">Add Customer Zone</a>
<a class="btn btn-link ml-2" href="{{ route('devices.create') }}">Add Device</a>
@endsection

@include('admins.components.customers-create-temp')
