@extends ('laraview.layouts.sideNavLayout')

@section('title')
Recharge Card
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

@include('admins.components.recharge-cards')
