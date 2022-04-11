@extends ('laraview.layouts.sideNavLayout')

@section('title')
Package edit
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
if(Auth::user()->id == $package->operator_id){
$active_menu = '2';
$active_link = '7';
} else {
$active_menu = '1';
$active_link = '1';
}
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@include('admins.components.packages-edit')
