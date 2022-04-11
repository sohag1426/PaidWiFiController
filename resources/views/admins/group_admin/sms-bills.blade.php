@extends ('laraview.layouts.sideNavLayout')

@section('title')
SMS Bills
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '10';
$active_link = '1';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@if ($merchant)
@include('admins.components.sms-bills-merchant')
@else
@include('admins.components.sms-bills-operator')
@endif
