@extends ('laraview.layouts.sideNavLayout')

@section ('title')
Two Factor
@endsection

@section ('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '8';
$active_link = '2';
@endphp
@endsection

@section ('sidebar')
@include('admins.group_admin.sidebar')
@endsection


@section('contentTitle')
<h3>Two Factor Authentication</h3>
@endsection

@section('content')
@include('admins.components.two-factor-enabled')
@endsection

@section('pageJs')
@endsection
