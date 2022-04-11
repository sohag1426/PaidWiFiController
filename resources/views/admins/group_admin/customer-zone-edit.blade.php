@extends ('laraview.layouts.sideNavLayout')

@section('title')
Edit customer zone
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '5';
$active_link = '5';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@include('admins.components.customer-zone-edit')
