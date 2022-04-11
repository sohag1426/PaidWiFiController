@extends ('laraview.layouts.sideNavLayout')

@section('title')
SMS Bill Edit
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

@include('admins.components.sms-bills-edit')
