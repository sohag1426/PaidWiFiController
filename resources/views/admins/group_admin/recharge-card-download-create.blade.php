@extends ('laraview.layouts.sideNavLayout')

@section('title')
recharge card download
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '13';
$active_link = '3';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@include('admins.components.recharge-card-download-create')
