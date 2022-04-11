@extends ('laraview.layouts.sideNavLayout')

@section('title')
Pending Transactions
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '3';
$active_link = '3';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@include('admins.components.pending-transactions')
