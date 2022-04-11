@extends ('laraview.layouts.sideNavLayout')

@section('title')
SMS Broadcast
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '10';
$active_link = '4';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@include('admins.components.sms-broadcast-edit')
