@extends ('laraview.layouts.sideNavLayout')

@section('title')
Distributor payments Summary Report
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '13';
$active_link = '2';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@include('admins.components.yearly_card_distributor_payments')
