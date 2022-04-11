@extends ('laraview.layouts.sideNavLayout')

@section('title')
Data Policy
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '14';
$active_link = '0';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@include('admins.components.data-policy')
