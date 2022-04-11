@extends ('laraview.layouts.sideNavLayout')

@section('title')
Due Notifier
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '6';
$active_link = '4';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@include('admins.components.due-notifier')
