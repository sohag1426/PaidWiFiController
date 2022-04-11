@extends ('laraview.layouts.sideNavLayout')

@section('title')
customers other Payment
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '6';
$active_link = '3';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@include('admins.components.customers-others-payment')
