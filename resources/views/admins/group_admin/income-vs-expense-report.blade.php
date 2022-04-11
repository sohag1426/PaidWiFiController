@extends('laraview.layouts.sideNavLayout')

@section ('title')
Income Vs. Expense Report
@endsection

@section ('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '7';
$active_link = '5';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@include('admins.components.income-vs-expense-report')
