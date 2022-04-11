@extends ('laraview.layouts.sideNavLayout')

@section('title')
distributors payments download
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

@include('admins.components.distributors-payments-download-create')
