@extends ('laraview.layouts.sideNavLayout')

@section('title')
Reset Password
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '8';
$active_link = '1';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection


@section('contentTitle')

<h3>Reset Password</h3>

@endsection

@include('admins.components.change-password')
