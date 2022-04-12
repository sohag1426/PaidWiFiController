@extends ('laraview.layouts.sideNavLayout')

@section('title')
Routers
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '2';
$active_link = '1';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@section('contentTitle')

<ul class="nav nav-fill flex-column flex-sm-row">

    <!--New Router-->
    <h3>New Router</h3>
    <!--/New Payment-->

</ul>

@endsection

@include('admins.components.routers-create')
