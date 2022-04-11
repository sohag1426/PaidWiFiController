@extends ('laraview.layouts.sideNavLayout')

@section('title')
Edit card distributor
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '13';
$active_link = '1';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@include('admins.components.card-distributors-edit')
