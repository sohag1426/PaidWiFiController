@extends ('laraview.layouts.sideNavLayout')

@section('title')
Operator Packages
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '1';
$active_link = '1';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@section('contentTitle')

<form action="{{ route('operators.master_packages.create', ['operator' => $operator->id]) }}">

    <ul class="nav flex-column flex-sm-row">
        <li class="nav-item">
            <button type="submit" class="btn btn-primary ml-2"> <i class="fas fa-plus"></i> Add Package</button>
        </li>
    </ul>

</form>

@endsection

@include('admins.components.operator-packages')
