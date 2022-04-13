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

@include('admins.components.customers-create-temp')
